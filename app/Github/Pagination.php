<?php

namespace Github;


use Github\Contracts\Pager;

class Pagination implements Pager
{
    protected $pager;

    public function __construct($currentPage = 1, $query = '', $total = 0, $perPage = 100, $pagerCount = 5)
    {
        $this->pager = $this->setPager($currentPage, $query, $total, $perPage, $pagerCount);
    }

    public function render()
    {
        $pagination = $this->pager;
        
        $template = '<ul class="pagination">';

        $firstDisabled = $pagination["first"]["disabled"] ? 'disabled':'';
        $previousDisabled = $pagination["previous"]["disabled"] ? 'disabled':'';

        $template.= '<li class="'.$firstDisabled.'"><a href="'.$pagination["first"]["url"].'" aria-label="Previous"><span aria-hidden="true">First</span></a></li>';
        $template.= '<li class="'.$previousDisabled.'"><a href="'.$pagination["previous"]["url"].'" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';

        foreach($pagination['links'] as $link) {
            $linkActive = $link["active"] ? 'active':'';
            $linkCurrent = $link["active"] ? '<span class="sr-only">(current)</span>':'';

            $template.= '<li class="'.$linkActive.'"><a href="'.$link["url"].'">'.$link["page"].' '.$linkCurrent.'</a></li>';
        }

        $nextDisabled = $pagination["next"]["disabled"] ? 'disabled':'';
        $lastDisabled = $pagination["last"]["disabled"] ? 'disabled':'';

        $template.= '<li class="'.$nextDisabled.'"><a href="'.$pagination["next"]["url"].'" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
        $template.= '<li class="'.$lastDisabled.'"><a href="'.$pagination["last"]["url"].'" aria-label="Next"><span aria-hidden="true">Last</span></a></li>';
        $template.= '</ul>';

        return $template;
    }
    
    public function raw()
    {
        return $this->pager;
    }

    /**
     * Set pager for search results.
     *
     * @param int $currentPage
     * @param string $query
     * @param int $total
     * @param int $perPage
     * @param int $pagerCount
     * @return array
     */
    protected function setPager($currentPage = 1, $query = '', $total = 0, $perPage = 100, $pagerCount = 5)
    {
        $totalPage = $this->getTotalPageCount($total, $perPage);

        $firstPage = 1;
        $previousPage = $currentPage <= 1 ? $currentPage : $currentPage - 1;
        $nextPage = $currentPage >= $totalPage ? $totalPage : $currentPage + 1;
        $lastPage = $totalPage;

        $links = $this->getPageLinks($currentPage, $query, $pagerCount, $totalPage);

        $first = http_build_query(['q' => $query, 'p' => $firstPage]);
        $previous = http_build_query(['q' => $query, 'p' => $previousPage]);
        $next = http_build_query(['q' => $query, 'p' => $nextPage]);
        $last = http_build_query(['q' => $query, 'p' => $lastPage]);

        $pagination = [
            'first' => [
                'disabled' => ($currentPage == $firstPage),
                'url' => '/search?' . $first
            ],
            'previous' => [
                'disabled' => ($currentPage == $previousPage),
                'url' => '/search?' . $previous
            ],
            'links' => $links,
            'next' => [
                'disabled' => ($currentPage == $nextPage),
                'url' => '/search?' . $next
            ],
            'last' => [
                'disabled' => ($currentPage == $lastPage),
                'url' => '/search?' . $last
            ],
            'current' => $currentPage,
            'total' => $totalPage,
        ];

        return $pagination;
    }

    /**
     * @param $total
     * @param $perPage
     * @return float|int
     */
    protected function getTotalPageCount($total, $perPage)
    {
        $totalPage = $total > 1000 ? 1000 / $perPage : $total / $perPage;
        if (is_float($totalPage)) {
            $totalPage = intval($totalPage) + 1;
        }
        return $totalPage;
    }

    /**
     * @param $currentPage
     * @param $pagerCount
     * @param $totalPage
     * @return mixed
     */
    protected function getNextPage($currentPage, $pagerCount, $totalPage)
    {
        if ($totalPage >= $pagerCount) {
            $nextPage = $currentPage + $pagerCount;
            if ($nextPage >= $totalPage) {
                $nextPage = $totalPage;
                return $nextPage;
            }
            return $nextPage;
        } else {
            $nextPage = $totalPage;
            return $nextPage;
        }
    }

    /**
     * @param $currentPage
     * @param $query
     * @param $pagerCount
     * @param $totalPage
     * @return array
     */
    protected function getPageLinks($currentPage, $query, $pagerCount, $totalPage)
    {
        $links = [];
        if ($currentPage > 2) {
            $min = $currentPage - 2;
            $max = $currentPage + 2;
        } elseif ($currentPage > 1) {
            $min = $currentPage - 1;
            $max = $currentPage + 3;
        } else {
            $min = $currentPage;
            $max = $currentPage + $pagerCount - 1;
        }

        if ($max > $totalPage) {
            $max = $totalPage;
        }

        for ($i = $min; $i <= $max; $i++) {
            $links[] = [
                'active' => ($currentPage == $i),
                'page' => $i,
                'url' => '/search?' . http_build_query(['q' => $query, 'p' => $i])
            ];
        }
        return $links;
    }
}