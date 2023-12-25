<?php

namespace Inilim\Pagination;

class Pagination
{
    /**
     * @param integer $cur_page текущая страница
     * @param integer $limit количество записей на одну страницу
     * @param integer $count_record общее количество записей
     * @return array{count_page:int,count_record:int,limit:int,offset:int,cur_page:int,is_last_page:bool,is_first_page:bool}
     */
    public function getAll(int $cur_page, int $limit, int $count_record): array
    {
        return [
            'count_page'    => $count_page = $this->getCountPage($limit, $count_record),
            'count_record'  => $count_record,
            'limit'         => $limit,
            'offset'        => $this->getOffset($cur_page, $count_record, $limit),
            'cur_page'      => $cur_page = $this->getValidCurPage($cur_page, $count_page),
            'is_last_page'  => $this->isLastPage($cur_page, $count_page),
            'is_first_page' => $this->isFirstPage($cur_page),
        ];
    }

    /**
     * Получить общее количество страниц
     * @param integer $limit количество записей на одну страницу
     * @param integer $count_record общее количество записей
     * @return integer
     */
    public function getCountPage(int $limit, int $count_record): int
    {
        $r = intval(ceil(intval($count_record) / $limit));
        return $r === 0 ? 1 : $r;
    }

    /**
     * расчитываем offset
     * @param integer $cur_page текущая страница
     * @param integer $count_page общее количество страниц
     * @param integer $limit количество записей на одну страницу
     * @return integer offset
     */
    public function getOffset(int $cur_page, int $count_page, int $limit): int
    {
        $cur_page = $cur_page <= 0 ? 1 : $cur_page;
        $offset = $cur_page > $count_page ? $count_page : $cur_page;
        $offset = ($offset * $limit) - $limit;
        return ($offset < 0) ? 0 : $offset;
    }

    /**
     * @param integer $cur_page текущая страница
     * @param integer $count_page общее количество страниц
     */
    public function getValidCurPage(int $cur_page, int $count_page): int
    {
        $cur_page = $cur_page <= 0 ? 1 : $cur_page;
        if ($cur_page === 1) return 1;
        $cur_page = ($cur_page > $count_page) ? $count_page : $cur_page;
        return $cur_page > $count_page ? $count_page : $cur_page;
    }

    public function isLastPage(int $cur_page, int $count_page): bool
    {
        $cur_page = $cur_page <= 0 ? 1 : $cur_page;
        return $cur_page >= $count_page;
    }

    public function isFirstPage(int $cur_page): bool
    {
        return $cur_page <= 1;
    }
}
