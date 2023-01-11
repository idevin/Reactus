<?php


namespace App\Helpers\Deployer\Classes;

use App\Helpers\Deployer\Contracts\Command;
use App\Helpers\Deployer\Contracts\Domain;
use App\Helpers\Deployer\Contracts\Pvc;
use App\Models\DomainVolume;

abstract class Deploy implements Command, Domain, Pvc
{
    public static function setup(string $domain, DomainVolume $pvc, bool $isPersonal = false, string $customerDomain = '')
    {
        $alias = slugify($domain);

        self::run("helm repo update --repository-config /var/secret/helm/repositories.yaml");

        self::install($pvc, $domain);

        $pvcName = $pvc->getName();
        $baseDomain = main_domain($domain);
        $customerDomainIssuer = 'reactus';
        $defaultIssuer = 'selectel';

        if ($isPersonal) {
            $domainParts = preg_split('/\./', idnToAscii($domain));
            $alias = 'personal-' . slugify($domainParts[0]);
            $socketEnabled = false;
        } else {
            $socketEnabled = true;
        }

        $baseDomainCertName = slugify($baseDomain) . "-wildcard-tls";
        $backendTag = env('BACKEND_TAG');
        $frontendTag = env('FRONTEND_TAG');
        $rootReleaseName = env('ROOT_RELEASE_NAME');
        $prerendererToken = env('PRERENDERER_TOKEN');
        $affinity = env('AFFINITY');
        $extraHelmOpts = env('EXTRA_HELM_OPTS');

        $secretEnvs = '/var/secret/chart/envs.yml';
        $kubeConfig = base64_encode(file_get_contents('/var/secret/kube/kube.yml'));
        $helmConfig = base64_encode(file_get_contents('/var/secret/helm/repositories.yaml'));

        $helmUpgrade = "helm upgrade ";
        $helmChartRepo = "$alias reactus/reactus ";
        $helmFlags = "-i ";
        $helmConfigs = "--kubeconfig /var/secret/kube/kube.yml --repository-config /var/secret/helm/repositories.yaml ";
        $helmSetCustomerDomain = isset($customerDomain) ? "--set ingress.customerDomain=$customerDomain,ingress.customerDomainIssuer=$customerDomainIssuer " : "";
        $helmSetImage = "--set image.backendTag=$backendTag,image.frontendTag=$frontendTag ";
        $helmSetIngress = "--set ingress.host=$domain,ingress.certName=$baseDomainCertName,ingress.issuer=$defaultIssuer --set ingress.baseDomain=$baseDomain ";
        $helmSetSocketEnabled = "--set deployment.socketEnabled=$socketEnabled ";
        $helmSetSecretEnvs = "--set-file secretEnvs=$secretEnvs ";
        $helmSetKubeConfig = "--set-string kubeConfig=$kubeConfig ";
        $helmSetHelmConfig = "--set-string helmConfig=$helmConfig ";
        $helmSetAffinity = "--set deployment.nodeAffinityKey=$affinity ";
        $helmSetExtraOpts = "--set extraHelmOpts=$extraHelmOpts ";
        $otherHelmSetOptions = "--set rootReleaseName=$rootReleaseName,dataPvcName=$pvcName,ingress.prerendererToken=$prerendererToken ";

        $cmd = $helmUpgrade . $helmChartRepo . $helmFlags . $helmConfigs . $helmSetCustomerDomain . $helmSetImage .
            $helmSetIngress . $helmSetSocketEnabled . $helmSetSecretEnvs . $helmSetKubeConfig . $helmSetHelmConfig .
            $helmSetAffinity . $helmSetExtraOpts . $otherHelmSetOptions . $extraHelmOpts;

        self::run($cmd);
    }

    public static function run(string $cmd)
    {
        $debug = env('APP_DEBUG_VARS');

        if ($debug) {
            debugvars('HELM CMD: ' . $cmd);
        }

        exec($cmd, $helmOutput);

        if ($debug) {
            debugvars('HELM INSTALL/UPGRADE', $helmOutput);
        }
    }

    public static function install(DomainVolume $pvc, string $domain): void
    {
        $pvcName = $pvc->getName();
        $volSize = $pvc->getSize();

        $helmUpgrade = "helm upgrade ";
        $helmChartRepo = "$pvcName reactus/reactus-pvc ";
        $helmFlags = "-i ";
        $helmConfigs = "--kubeconfig /var/secret/kube/kube.yml --repository-config /var/secret/helm/repositories.yaml ";
        $helmSet = "--set size=$volSize,extraLabels.domain=$domain ";

        $cmd = $helmUpgrade . $helmChartRepo . $helmFlags . $helmConfigs . $helmSet;

        Deploy::run($cmd);
    }

    public static function create()
    {
        // TODO: Implement create() method.
    }
}