<?php

declare(strict_types=1);

use Inilim\Test\TestCase;
use Inilim\Pagination\Pagination;

final class PaginationTest extends TestCase
{
    public function test_result_array(): void
    {
        $logName = __FUNCTION__ . ' | ';

        foreach ($this->getTestData() as $i => $subValues) {
            $dto = (new Pagination)->getAll(
                $subValues['curPage'],
                $subValues['limitOnePage'],
                $subValues['countRecords']
            );

            $this->assertSame(
                $dto->toArray(),
                $subValues['expecting'],
                $logName . $i
            );
        }
    }

    function getTestData(): array
    {
        return [
            0 => [
                'curPage'      => 1,
                'limitOnePage' => 25,
                'countRecords' => 100,
                'expecting' => [
                    'countPages'   => 4,
                    'countRecords' => 100,
                    'limitOnePage' => 25,
                    'offset'       => 0,
                    'curPage'      => 1,
                    'nextPage'     => 2,
                    'prevPage'     => null,
                    'isLastPage'   => false,
                    'isFirstPage'  => true,
                ],
            ],
            1 => [
                'curPage'      => 7,
                'limitOnePage' => 25,
                'countRecords' => 100,
                'expecting' => [
                    'countPages'   => 4,
                    'countRecords' => 100,
                    'limitOnePage' => 25,
                    'offset'       => 75,
                    'curPage'      => 4,
                    'nextPage'     => null,
                    'prevPage'     => 3,
                    'isLastPage'   => true,
                    'isFirstPage'  => false,
                ],
            ],
            2 => [
                'curPage'      => -5,
                'limitOnePage' => 25,
                'countRecords' => 100,
                'expecting' => [
                    'countPages'   => 4,
                    'countRecords' => 100,
                    'limitOnePage' => 25,
                    'offset'       => 0,
                    'curPage'      => 1,
                    'nextPage'     => 2,
                    'prevPage'     => null,
                    'isLastPage'   => false,
                    'isFirstPage'  => true,
                ],
            ],
            3 => [
                'curPage'      => 0,
                'limitOnePage' => 25,
                'countRecords' => 99,
                'expecting' => [
                    'countPages'   => 4,
                    'countRecords' => 99,
                    'limitOnePage' => 25,
                    'offset'       => 0,
                    'curPage'      => 1,
                    'nextPage'     => 2,
                    'prevPage'     => null,
                    'isLastPage'   => false,
                    'isFirstPage'  => true,
                ],
            ],
            4 => [
                'curPage'      => 2,
                'limitOnePage' => 50,
                'countRecords' => 25,
                'expecting' => [
                    'countPages'   => 1,
                    'countRecords' => 25,
                    'limitOnePage' => 50,
                    'offset'       => 0,
                    'curPage'      => 1,
                    'nextPage'     => null,
                    'prevPage'     => null,
                    'isLastPage'   => true,
                    'isFirstPage'  => true,
                ],
            ],
        ];
    }
}
