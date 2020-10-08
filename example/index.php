<?php

use Tonix\TmpFile;

require_once __DIR__ . '/../vendor/autoload.php';

$dir = __DIR__ . '/dir';
$tmpFile = new TmpFile();
$tmpFile->create($dir, 'prefix_', '.suffix');
$tmpFile->create($dir, 'prefix_', '.suffix', false);
