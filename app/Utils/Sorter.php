<?php namespace App\Utils;

use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Sorter
 * @package App\Utils
 */
class Sorter
{
    /**
     * @param Builder|QueryBuilder $query
     * @param $sGetOrderKey
     * @param string $sDefaultOrder
     */
    public static function setOrder(Builder|QueryBuilder &$query, $sGetOrderKey, string $sDefaultOrder = "asc")
    {
        if (empty($sGetOrderKey)) {
            return;
        }

        if (!isset($_GET[$sGetOrderKey])) {
            return;
        }

        $sOrderValue = $_GET[$sGetOrderKey];

        if (mb_substr($sOrderValue, 0, 1) == "-") {
            $sOrderValue = mb_substr($sOrderValue, 1);
            $sDefaultOrder = "desc";
        }

        $query->orderBy($sOrderValue, $sDefaultOrder);
    }

    /**
     * @param string $sRequestField
     * @param int $iDefaultPerPage
     *
     * @return int
     */
    public static function getPerPage(string $sRequestField = "limit", int $iDefaultPerPage = 10): int
    {
        return isset($_GET[$sRequestField]) ? (int)$_GET[$sRequestField] : $iDefaultPerPage;
    }
}