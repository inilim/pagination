<?php

require __DIR__ . '/../vendor/autoload.php';

use Inilim\Pagination\Pagination;
use Inilim\Dump\Dump;

Dump::init();

$pag = new Pagination;

$res = $pag->getAll(1, 10, 1);
de($res);
