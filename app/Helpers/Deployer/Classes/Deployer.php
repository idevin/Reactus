<?php


namespace App\Helpers\Deployer\Classes;


use App\Helpers\Deployer\V1;
use App\Helpers\Deployer\V2;
use App\Models\DomainVolume;

/**
 * @method v1()
 * @property string $domain
 */
class Deployer
{

    /**
     * Deployer constructor.
     * @param string $domain
     * @param DomainVolume $pvc
     * @param bool $isPersonal
     * @param string $customerDomain
     */
    public function __construct(
        public string $domain,
        public DomainVolume $pvc,
        public bool $isPersonal = false,
        public string $customerDomain = '')
    {
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @return DomainVolume
     */
    public function getPvc(): DomainVolume
    {
        return $this->pvc;
    }

    /**
     * @return string
     */
    public function getIsPersonal(): string
    {
        return $this->isPersonal;
    }

    /**
     * @return string
     */
    public function getCustomerDomain(): string
    {
        return $this->customerDomain;
    }

    public function __call(string $name, array $args)
    {
        $methods = get_class_methods($this);

        if (!in_array($name, $methods)) {
            $name = ucfirst($name);
            $classFound = array_filter($this->versions(), function ($className) use ($name) {
                $basename = class_basename($className);
                if ($basename == $name) {
                    return true;
                } else {
                    return false;
                }
            });

            if (empty($classFound)) {
                throw new \BadMethodCallException('There is no version like ' . $name);
            } else {
                /** @var V1 $classFound[0] */
                return $classFound[0]::setup(
                    $this->getDomain(),
                    $this->getPvc(),
                    $this->getIsPersonal(),
                    $this->getCustomerDomain());
            }
        }
    }

    /**
     * @param string $domain domain name
     * @param null $prefix
     */
    public static function uninstall(string $domain, $prefix = null)
    {
        $domain = slugify($domain);
        if ($prefix) {
            $domain = $prefix . '-' . $domain;
        }

        Deploy::run("helm uninstall $domain --kubeconfig /var/secret/kube/kube.yml");
    }

    public static function versions(): array
    {
        return [
            V1::class, V2::class
        ];
    }
}