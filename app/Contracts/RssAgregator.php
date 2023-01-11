<?php namespace App\Contracts;

use AaronDDM\XMLBuilder\Writer\XMLWriterService;
use AaronDDM\XMLBuilder\XMLBuilder;
use App\Models\Site;
use Illuminate\Support\Collection;

/**
 * Class RssAgregator
 * @package App\Contracts
 */
class RssAgregator
{
    const STATUS_ERROR = 0;
    const STATUS_SUCCESS = 1;
    const STATUS_VALIDATE_SUCCESS = 2;

    /** @var Site $obSite */
    protected $obSite = null;
    protected array $arErrors = [];
    protected int $iStatus = 0;

    protected array $arWithModels = [];

    /**
     * RssAgregator constructor.
     * @param Site $obSite
     */
    public function __construct(Site $obSite)
    {
        if (empty($obSite->domain) || $obSite->domain == ' ') {
            $this->arErrors[] = "error site domain is empty";
            return;
        }

        if (empty($obSite->title) || $obSite->title == ' ') {
            $this->arErrors[] = "error site title is empty";
            return;
        }

        $this->iStatus = self::STATUS_VALIDATE_SUCCESS;
        $this->obSite = $obSite;
    }

    /**
     * @return int
     */
    public function status()
    {
        return $this->iStatus;
    }

    /**
     * @param $arModelNames
     * @return $this
     */
    public function with($arModelNames)
    {
        if (is_string($arModelNames)) {
            $obModel = new $arModelNames();
            if (!$obModel instanceof Rss || $this->iStatus == self::STATUS_ERROR) {
                return $this;
            }

            if (!in_array($arModelNames, $this->arWithModels)) {
                $this->arWithModels[] = $arModelNames;
            }
            return $this;
        }

        foreach ($arModelNames as $sModelName) {
            $obModel = new $sModelName();
            if (!$obModel instanceof Rss || $this->iStatus == self::STATUS_ERROR) {
                return $this;
            }

            if (in_array($sModelName, $this->arWithModels)) {
                continue;
            }

            $this->arWithModels[] = $sModelName;
        }

        return $this;
    }

    public function getXML(): string
    {
        $this->iStatus = self::STATUS_ERROR;
        try {
            $xmlWriterService = new XMLWriterService();
        } catch (\Exception $exception) {
            return '';
        }

        $xmlBuilder = new XMLBuilder($xmlWriterService);

        try {
            $xmlArray = $xmlBuilder
                ->createXMLArray()
                ->start('rss', ['xmlns:media' => "http://search.yahoo.com/mrss/", 'xmlns:turbo' => 'http://turbo.yandex.ru', 'xmlns:yandex' => 'http://news.yandex.ru', 'version' => '2.0'])
                ->start('channel')
                ->add('title', $this->obSite->title . ' RSS')
                ->add('link', getSchema() . $this->obSite->domain);
            if (!empty($this->obSite->slogan)) {
                $xmlArray->add('description', $this->obSite->slogan);
            } else if (!empty($this->obSite->title)) {
                $xmlArray->add('description', $this->obSite->title);
            } else {
                $xmlArray->add('description', $this->obSite->domain);
            }

            foreach ($this->arWithModels as $sModelClass) {
                $obList = null;
                try {
                    $obList = $sModelClass::getForRss($this->obSite)->get();
                } catch (\Exception $e) {
                    continue;
                }

                /** @var Collection $obList */
                if ($obList->count() <= 0) {
                    continue;
                }

                foreach ($obList as $obItem) {
                    $sItem = $obItem->getRSSItem();
                    if (empty($sItem) || $sItem == '') {
                        continue;
                    }

                    $xmlArray->add('item', $sItem, ['turbo' => 'true']);
                }
            }
            $xmlArray->end();
            $xmlArray->end();
            $sResXML = $xmlBuilder->getXML();
        } catch (\Exception $e) {
            return '';
        }

        $this->iStatus = self::STATUS_SUCCESS;
        return $sResXML;
    }

    public function errors(): array
    {
        return $this->arErrors;
    }
}
