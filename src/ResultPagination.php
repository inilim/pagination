<?php

namespace Inilim\Pagination;

/**
 * @psalm-readonly
 */
final class ResultPagination
{
    protected int $countPages;
    protected int $countRecords;
    protected int $limitOnePage;
    protected int $curPage;
    protected int $offset;
    protected ?int $nextPage;
    protected ?int $prevPage;
    protected bool $isLastPage;
    protected bool $isFirstPage;

    public function __construct(
        int $countPages,
        int $countRecords,
        int $limitOnePage,
        int $curPage,
        int $offset,
        ?int $nextPage,
        ?int $prevPage,
        bool $isLastPage,
        bool $isFirstPage
    ) {
        $this->countPages   = $countPages;
        $this->countRecords = $countRecords;
        $this->limitOnePage = $limitOnePage;
        $this->curPage      = $curPage;
        $this->offset       = $offset;
        $this->nextPage     = $nextPage;
        $this->prevPage     = $prevPage;
        $this->isLastPage   = $isLastPage;
        $this->isFirstPage  = $isFirstPage;
    }

    public function getCountPages(): int
    {
        return $this->countPages;
    }

    public function getCountRecords(): int
    {
        return $this->countRecords;
    }

    public function getLimitOnePage(): int
    {
        return $this->limitOnePage;
    }

    public function getCurPage(): int
    {
        return $this->curPage;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function getNextPage(): ?int
    {
        return $this->nextPage;
    }

    public function getPrevPage(): ?int
    {
        return $this->prevPage;
    }

    public function isLastPage(): bool
    {
        return $this->isLastPage;
    }

    public function isFirstPage(): bool
    {
        return $this->isFirstPage;
    }

    /**
     * @return array{countPages:int,countRecords:int,limitOnePage:int,offset:int,curPage:int,nextPage:?int,prevPage:?int,isLastPage:bool,isFirstPage:bool}
     */
    public function toArray(): array
    {
        return [
            'countPages'   => $this->countPages,
            'countRecords' => $this->countRecords,
            'limitOnePage' => $this->limitOnePage,
            'offset'       => $this->offset,
            'curPage'      => $this->curPage,
            'nextPage'     => $this->nextPage,
            'prevPage'     => $this->prevPage,
            'isLastPage'   => $this->isLastPage,
            'isFirstPage'  => $this->isFirstPage,
        ];
    }
}
