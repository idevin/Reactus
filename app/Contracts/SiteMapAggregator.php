<?php namespace App\Contracts;

use AaronDDM\XMLBuilder\Writer\XMLWriterService;
use AaronDDM\XMLBuilder\XMLBuilder;
use App\Models\Site;
use Illuminate\Support\Collection;

/**
 * Class SiteMapAggregator
 * @package App\Contracts
 */
class SiteMapAggregator
{
    const STATUS_ERROR = 0;
    const STATUS_SUCCESS = 1;
    const SITE_MAP_DATA_TEMPLATE = [
        'loc' => '',
        'lastmod' => '',
        'changefreq' => 'monthly',
        'priority' => 1.0,
    ];

    protected int $iStatusCode = self::STATUS_ERROR;

    /** @var ?Site $obSite */
    protected ?Site $obSite = null;

    protected array $arModelsList = [];
    protected array $arHidden = [];

    public function __construct(Site $site)
    {
        $this->site = $site;
        $this->statusCode = self::STATUS_SUCCESS;
    }

    /**
     * @param array|string $modelList
     * @return SiteMapAggregator
     */
    public function with(array|string $modelList): self
    {
        if (!is_string($modelList) && !is_array($modelList)) {
            return $this;
        }

        if (is_string($modelList)) {
            $modelList = [$modelList];
        }

        foreach ($modelList as $modelName) {
            if (!is_string($modelName)) {
                continue;
            }

            $this->add($modelName);
        }

        return $this;
    }

    /**
     * @param string $modelName
     */
    protected function add(string $modelName)
    {
        $model = new $modelName();
        if (!$model instanceof SiteMap) {
            return;
        }

        $this->arModelsList[$modelName] = $model;
    }

    /**
     * @param array|string $modelNamesList
     * @return SiteMapAggregator
     */
    public function makeHidden(array|string $modelNamesList): self
    {
        if (!is_string($modelNamesList) || !is_array($modelNamesList)) {
            return $this;
        }

        if (is_string($modelNamesList)) {
            $modelNamesList = [$modelNamesList];
        }

        $this->arHidden = array_intersect($this->arHidden, $modelNamesList);
        return $this;
    }

    public function getSiteMapXMLString(): string
    {
        $this->statusCode = self::STATUS_ERROR;
        try {
            $xmlWriterService = new XMLWriterService();
        } catch (\Exception $exception) {
            if (env('APP_DEBUG_VARS') == true) {
                debugvars($exception->getMessage(), $exception->getTrace());
            }
            return '';
        }

        $xmlBuilder = new XMLBuilder($xmlWriterService);
        try {
            $xmlArray = $xmlBuilder
                ->createXMLArray()
                ->start('urlset', ['xmlns' =>'http://www.sitemaps.org/schemas/sitemap/0.9']);

            /** @var SiteMap $obModel */
            foreach ($this->arModelsList as $obModel) {
                $obList = null;
                try {
                    $obList = $obModel->getSiteMapList($this->site);
                } catch (\Exception $e) {
                    if (env('APP_DEBUG_VARS') == true) {
                        debugvars($e->getMessage(), $e->getTrace());
                    }
                    continue;
                }

                /** @var Collection $obList */
                if ($obList->count() <= 0) {
                    continue;
                }

                $arTemplateDataKeys = array_keys(self::SITE_MAP_DATA_TEMPLATE);
                /** @var SiteMap $obItem */
                foreach ($obList as $obItem) {
                    $arSiteMapData = $obItem->getSiteMapDATA();
                    if (!is_array($arSiteMapData) || empty($arSiteMapData)) {
                        continue;
                    }

                    if (!isset($arSiteMapData['loc'])) {
                        continue;
                    }

                    $xmlArray = $xmlArray->start('url', []);
                    foreach ($arSiteMapData as $sKey => $uValue) {
                        if (!in_array($sKey, $arTemplateDataKeys)) {
                            continue;
                        }

                        $xmlArray->add($sKey, $uValue);
                    }
                    $xmlArray = $xmlArray->end();
                }
            }
            $xmlArray->end();
            $sResXML = $xmlBuilder->getXML();
        } catch (\Exception $e) {
            return '';
        }

        $this->statusCode = self::STATUS_SUCCESS;
        return $sResXML;
    }

    public function error(): int
    {
        return $this->statusCode;
    }
}