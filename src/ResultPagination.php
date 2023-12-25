<?php

namespace Inilim\Pagination;

readonly class ResultPagination
{
    public function __construct(
        public int $count_page,
        public int $count_record,
        public int $limit,
        public int $cur_page,
        public int $offset,
        public bool $is_last_page,
        public bool $is_first_page,
    ) {
    }
}
