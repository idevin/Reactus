<?php

namespace App\Pagination;

use Illuminate\Contracts\Pagination\Presenter as PresenterContract;
use Illuminate\Contracts\Pagination\Paginator as PaginatorContract;
use Illuminate\Pagination\UrlWindow;
use Illuminate\Support\HtmlString;

class NGPresenter
{
    /**
     * The paginator implementation.
     *
     * @var \Illuminate\Contracts\Pagination\Paginator
     */
    protected $paginator;

    /**
     * The URL window data structure.
     *
     * @var array
     */
    protected $window;

    public function __construct(PaginatorContract $paginator, UrlWindow $window = null)
    {
        $this->paginator = $paginator;
        $this->window = is_null($window) ? UrlWindow::make($paginator) : $window->get();
    }

    public function render()
    {
        if ($this->hasPages()) {
            return new HtmlString(sprintf(
                '<div class="pagination clearfix">%s %s %s</div>',
                $this->getNextButton(),
                $this->getPreviousButton(),
                $this->getLinks()
            ));
        }

        return '';
    }

    public function hasPages()
    {
        return $this->paginator->hasPages();
    }

    public function getPreviousButton($text = '&laquo;')
    {
        $class = 'pagination-prev';
        if ($this->paginator->currentPage() <= 1) {
            $class .= ' disabled';
        }

        $url = $this->paginator->url($this->paginator->currentPage() - 1);

        return new HtmlString(sprintf(
            '<a href="%s" class="%s"><span class="icon arrow-pagination-prev"></span></a>',
            $url,
            $class
        ));
    }

    /**
     * Get the next page pagination element.
     *
     * @param  string $text
     * @return string
     */
    public function getNextButton($text = '&raquo;')
    {
        $class = 'pagination-next';
        if (!$this->paginator->hasMorePages()) {
            $class .= ' disabled';
        }

        $url = $this->paginator->url($this->paginator->currentPage() + 1);

        return new HtmlString(sprintf(
            '<a href="%s" class="%s"><span class="icon arrow-pagination-next"></span></a>',
            $url,
            $class
        ));
    }

    protected function getPageLinkWrapper($url, $page, $rel = null)
    {
        if ($page == $this->paginator->currentPage()) {
            return $this->getActivePageWrapper($page);
        }

        return $this->getAvailablePageWrapper($url, $page, $rel);
    }

    protected function getActivePageWrapper($text)
    {

        // if ($this->paginator->lastPage() > config('netgamer.paginarion.size-left-slider') * 2) {

        //    }
        return '<li><span class="pagination-item">' . $text . '</span></li>';
        // return '<li class="active"><span>'.$text.'</span></li>';
    }

    /**
     * Get a pagination "dot" element.
     *
     * @return string
     */
    protected function getDots()
    {
        return '<li><span class="pagination-item">&hellip;</span></li>';
        // return $this->getDisabledTextWrapper('...');
    }

    protected function getAvailablePageWrapper($url, $page, $rel = null)
    {
        $rel = is_null($rel) ? '' : ' rel="' . $rel . '"';

        return '<li><a href="' . htmlentities($url) . '"' . $rel . ' class="pagination-item">' . $page . '</a></li>';
    }

    protected function getUrlLinks(array $urls)
    {
        $html = '';

        foreach ($urls as $page => $url) {
            $html .= $this->getPageLinkWrapper($url, $page);
        }

        return $html;
    }

    protected function getLinks()
    {
        $html = '<ul>';

        if (is_array($this->window['first'])) {
            $html .= $this->getUrlLinks($this->window['first']);
        }

        if (is_array($this->window['slider'])) {
            $html .= $this->getDots();
            $html .= $this->getUrlLinks($this->window['slider']);
        }

        if (is_array($this->window['last'])) {
            $html .= $this->getDots();
            $html .= $this->getUrlLinks($this->window['last']);
        }

        $html .= '</ul>';

        return $html;
    }


}