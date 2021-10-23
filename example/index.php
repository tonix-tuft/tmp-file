<?php

use Tonix\TmpFile;

require_once __DIR__ . '/../vendor/autoload.php';

$dir = __DIR__ . '/dir';
$tmpFile = new TmpFile();
$absoluteTmpFilename1 = $tmpFile->create($dir, 'prefix_', '.suffix');
$absoluteTmpFilename2 = $tmpFile->create($dir, 'prefix_', '.suffix', false);

echo PHP_EOL;
echo json_encode(
  ['absoluteTmpFilename1 (auto-deleted)' => $absoluteTmpFilename1],
  JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
);
echo PHP_EOL;

echo PHP_EOL;
echo json_encode(
  ['absoluteTmpFilename2' => $absoluteTmpFilename2],
  JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
);
echo PHP_EOL;

echo PHP_EOL;
