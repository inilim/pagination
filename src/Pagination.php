<?php

namespace Inilim\Pagination;

use Inilim\Pagination\ResultPagination;

final class Pagination
{
    public function getAll(int $curPage, int $limitOnePage, int $countRecords): ResultPagination
    {
        $limitOnePage = \abs($limitOnePage);
        $countRecords = \abs($countRecords);
        $countPages   = $this->getCountPages($limitOnePage, $countRecords);
        $curPage      = $this->getValidCurPage($curPage, $countPages);

        return new ResultPagination(
            $countPages,
            $countRecords,
            $limitOnePage,
            $curPage,
            $this->getOffset($curPage, $countPages, $limitOnePage),
            $this->nextPage($curPage, $countPages),
            $this->prevPage($curPage, $countPages),
            $this->isLastPage($curPage, $countPages),
            $this->isFirstPage($curPage)
        );
    }

    public function nextPage(int $curPage, int $countPages): ?int
    {
        $curPage    = $this->getValidCurPage($curPage, $countPages);
        $countPages = $this->prepareCountPages($countPages);
        if ($curPage === $countPages || $countPages === 1) return null;
        return $curPage + 1;
    }

    public function prevPage(int $curPage, int $countPages): ?int
    {
        $curPage    = $this->getValidCurPage($curPage, $countPages);
        if ($curPage === 1) return null;
        return $curPage - 1;
    }

    /**
     * Получить общее количество страниц
     * @return int<1,max>
     */
    public function getCountPages(int $limitOnePage, int $countRecords): int
    {
        $limitOnePage = \abs($limitOnePage);
        if ($limitOnePage === 0) return 1;
        $countRecords = \abs($countRecords);
        if ($countRecords === 0) return 1;
        $c = \intval(
            \ceil($countRecords / $limitOnePage)
        );
        return $c <= 0 ? 1 : $c;
    }

    /**
     * расчитываем offset для sql запроса
     * @return int<0,max>
     */
    public function getOffset(int $curPage, int $countPages, int $limitOnePage): int
    {
        $curPage      = $this->getValidCurPage($curPage, $countPages);
        $limitOnePage = \abs($limitOnePage);
        $offset       = ($curPage * $limitOnePage) - $limitOnePage;
        return $offset < 0 ? 0 : $offset;
    }

    /**
     * @return int<1,max>
     */
    public function getValidCurPage(int $curPage, int $countPages): int
    {
        $curPage   = $this->prepareCurPage($curPage);
        if ($curPage === 1) return 1;
        $countPages = $this->prepareCountPages($countPages);
        return $curPage > $countPages ? $countPages : $curPage;
    }

    public function isLastPage(int $curPage, int $countPages): bool
    {
        $countPages = $this->prepareCountPages($countPages);
        $curPage    = $this->prepareCurPage($curPage);
        return $curPage >= $countPages;
    }

    public function isFirstPage(int $curPage): bool
    {
        return $this->prepareCurPage($curPage) === 1;
    }

    // ------------------------------------------------------------------
    // protected
    // ------------------------------------------------------------------

    /**
     * @return int<1,max>
     */
    protected function prepareCurPage(int $curPage): int
    {
        return $curPage <= 0 ? 1 : $curPage;
    }

    /**
     * @return int<1,max>
     */
    protected function prepareCountPages(int $countPages): int
    {
        $countPages = \abs($countPages);
        return $countPages === 0 ? 1 : $countPages;
    }
}
