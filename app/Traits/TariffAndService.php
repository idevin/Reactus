<?php

namespace App\Traits;


use App\Models\BillingService;
use App\Models\BillingTariff;
use App\Models\User as UserModel;
use Illuminate\Contracts\Auth\Authenticatable;

trait TariffAndService
{
    /**
     * @param $tariffId
     * @param UserModel $user
     * @return void
     */
    public static function syncTariffPermissions($tariffId, UserModel $user)
    {
        $tariff = BillingTariff::query()->find($tariffId);

        $userRoles = $user->roles->pluck('id')->toArray();

        $services = $tariff->services()->with(['roles'])->get();

        if (!empty($services)) {

            foreach ($services as $service) {
                $userRoles = self::mergeUserRoles($userRoles, $service);
            }
            $userRoles = array_unique($userRoles);
            $user->roles()->sync($userRoles);
            $user->syncAllPermissions($user);
        }
    }

    /**
     * @param $serviceId
     * @param Authenticatable|UserModel $user
     * @return void
     */
    public static function syncServicePermissions($serviceId, $user)
    {
        $service = BillingService::query()->with(['roles'])->find($serviceId);

        $userRoles = $user->roles->pluck('id')->toArray();

        if (!empty($service)) {

            $userRoles = self::mergeUserRoles($userRoles, $service);

            $userRoles = array_unique($userRoles);
            $user->roles()->sync($userRoles);
            $user->syncAllPermissions($user);
        }
    }

    private function deleteSubscription(mixed $deleteForever, $subscription)
    {
        switch ($deleteForever) {
            case 0:
                $subscription->delete();
                break;
            case 1:
                $subscription->forceDelete();
                break;
        }
    }

    public static function mergeUserRoles($userRoles, $service)
    {
        if (!empty($service->roles)) {
            $serviceRoles = $service->roles->pluck('id')->toArray();
            $userRoles = array_merge($userRoles, $serviceRoles);
        }

        return $userRoles;

    }
}