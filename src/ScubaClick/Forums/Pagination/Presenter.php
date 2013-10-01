<?php namespace ScubaClick\Forums\Pagination;

use Illuminate\Pagination\Paginator;

class Presenter
{
    /**
     * The paginator instance being rendered.
     *
     * @var \Illuminate\Pagination\Paginator
     */
    protected $paginator;

    /**
     * The last available page of the paginator.
     *
     * @var int
     */
    protected $lastPage;

    /**
     * Create a new Bootstrap presenter instance.
     *
     * @param  \Illuminate\Pagination\Paginator $paginator
     * @return void
     */
    public function __construct(Paginator $paginator)
    {
        $this->paginator = $paginator;
        $this->lastPage  = $this->paginator->getLastPage();
    }

    /**
     * Render the Bootstrap pagination contents.
     *
     * @return string
     */
    public function render()
    {
        if ($this->lastPage < 6) {
            $content = $this->getPageRange(1, $this->lastPage);
        } else {
            $content = $this->getPageSlider();
        }

        return $content;
    }

    /**
     * Create a range of pagination links.
     *
     * @param  int    $start
     * @param  int    $end
     * @return string
     */
    public function getPageRange($start, $end)
    {
        $pages = array();

        for ($page = $start; $page <= $end; $page++) {
            $pages[] = $this->getLink($page);
        }

        return implode('', $pages);
    }

    /**
     * Create a pagination slider link window.
     *
     * @return string
     */
    protected function getPageSlider()
    {
        return $this->getPageRange(1, 3) . $this->getFinish();
    }

    /**
     * Create the ending cap of a pagination slider.
     *
     * @return string
     */
    public function getFinish()
    {
        $content = $this->getPageRange($this->lastPage - 2, $this->lastPage);

        return $this->getDots() . $content;
    }

    /**
     * Get a pagination "dot" element.
     *
     * @return string
     */
    public function getDots()
    {
        return '<li class="disabled"><span>...</span></li>';
    }

    /**
     * Create a pagination slider link.
     *
     * @param  mixed  $page
     * @return string
     */
    public function getLink($page)
    {
        $url = $this->paginator->getUrl($page);

        return '<li><a href="'.$url.'">'.$page.'</a></li>';
    }
}
