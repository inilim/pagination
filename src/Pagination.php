<?php

namespace Inilim\Pagination;

use Inilim\Pagination\ResultPagination;

class Pagination
{
    /**
     * @param int $cur_page текущая страница
     * @param int $limit количество записей на одну страницу
     * @param int $count_record общее количество записей
     */
    public function getAll(int $cur_page, int $limit, int $count_record): ResultPagination
    {
        $cur_page     = $this->prepareCurPage($cur_page);
        $limit        = \abs($limit);
        $count_record = \abs($count_record);

        return new ResultPagination(
            count_page: $count_page = $this->getCountPage($limit, $count_record),
            count_record: $count_record,
            limit: $limit,
            cur_page: $cur_page = $this->getValidCurPage($cur_page, $count_page),
            offset: $this->getOffset($cur_page, $count_record, $limit),
            next_page: $this->nextPage($cur_page, $count_page),
            prev_page: $this->prevPage($cur_page, $count_page),
            is_last_page: $this->isLastPage($cur_page, $count_page),
            is_first_page: $this->isFirstPage($cur_page),
        );
    }

    /**
     * @param int $cur_page текущая страница
     * @param int $count_page общее количество страниц Применяется abs()
     */
    public function nextPage(int $cur_page, int $count_page): ?int
    {
        $count_page = $this->prepareCountPage($count_page);
        $cur_page   = $this->getValidCurPage($cur_page, $count_page);
        if ($cur_page === $count_page || $count_page === 1) return null;
        return $cur_page + 1;
    }

    /**
     * @param int $cur_page текущая страница
     * @param int $count_page общее количество страниц Применяется abs()
     */
    public function prevPage(int $cur_page, int $count_page): ?int
    {
        $count_page = $this->prepareCountPage($count_page);
        $cur_page   = $this->getValidCurPage($cur_page, $count_page);
        if ($cur_page === 1) return null;
        return $cur_page - 1;
    }

    /**
     * Получить общее количество страниц
     * @param int $limit количество записей на одну страницу Применяется abs()
     * @param int $count_record общее количество записей Применяется abs()
     * @return int<1,max>
     */
    public function getCountPage(int $limit, int $count_record): int
    {
        $limit        = \abs($limit);
        $count_record = \abs($count_record);
        $c = \intval(\ceil(\intval($count_record) / $limit));
        return $c === 0 ? 1 : $c;
    }

    /**
     * расчитываем offset для sql запроса
     * @param int $cur_page текущая страница
     * @param int $count_page общее количество страниц Применяется abs()
     * @param int $limit количество записей на одну страницу Применяется abs()
     * @return int<0,max>
     */
    public function getOffset(int $cur_page, int $count_page, int $limit): int
    {
        $cur_page = $this->getValidCurPage($cur_page, $count_page);
        $limit  = \abs($limit);
        $offset = ($cur_page * $limit) - $limit;
        return $offset < 0 ? 0 : $offset;
    }

    /**
     * @param int $cur_page текущая страница
     * @param int $count_page общее количество страниц Применяется abs()
     * @return int<1,max>
     */
    public function getValidCurPage(int $cur_page, int $count_page): int
    {
        $cur_page   = $this->prepareCurPage($cur_page);
        if ($cur_page === 1) return 1;
        $count_page = $this->prepareCountPage($count_page);
        return $cur_page > $count_page ? $count_page : $cur_page;
    }

    /**
     * @param int $cur_page текущая страница
     * @param int $count_page общее количество страниц Применяется abs()
     */
    public function isLastPage(int $cur_page, int $count_page): bool
    {
        $count_page = $this->prepareCountPage($count_page);
        $cur_page   = $this->prepareCurPage($cur_page, $count_page);
        return $cur_page >= $count_page;
    }

    /**
     * @param int $cur_page текущая страница
     */
    public function isFirstPage(int $cur_page): bool
    {
        $cur_page = $this->prepareCurPage($cur_page);
        return $cur_page === 1;
    }

    // ------------------------------------------------------------------
    // protected
    // ------------------------------------------------------------------

    /**
     * @return int<1,max>
     */
    protected function prepareCurPage(int $cur_page): int
    {
        return $cur_page <= 0 ? 1 : $cur_page;
    }

    /**
     * @return int<1,max>
     */
    protected function prepareCountPage(int $count_page): int
    {
        $count_page = \abs($count_page);
        return $count_page === 0 ? 1 : $count_page;
    }
}
