<?php namespace App\Console\Commands;

use App\Models\Domain;
use Illuminate\Console\Command;
use Log;
use phpWhois\Whois;

/**
 * Class DomainAvailableCommand
 * @package App\Console\Commands
 * @author  Ilya Beltyukov, 968597@gmail.com
 */
class DomainAvailableCommand extends Command
{
    protected $signature = 'domain:check-available';

    protected $description = 'Checking available domain and set active=false if whois not available';

    public function handle()
    {
        $obDomainList = Domain::where('domain_type', '<>', Domain::DOMAIN_TYPE_SYSTEM)->get();
        $obWhois = new Whois();

        foreach ($obDomainList as $obDomain) {

            $arDataCheck = $obWhois->lookup($obDomain->name);
            if (!isset($arDataCheck['regrinfo']) || !isset($arDataCheck['regrinfo']['registered'])) {
                continue;
            }

            if ($arDataCheck['regrinfo']['registered'] == 'yes') {
                continue;
            }
            if (env('APP_DEBUG_VARS') == true) {
               debugvars("DOMAIN ACTIVE SET TO FALSE");
            }
        }
    }
}