<?php

/*
 * Copyright (c) 2021 Anton Bagdatyev (Tonix)
 *
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 */

namespace Tonix;

/**
 * A class for creating temporary files.
 *
 * @author Anton Bagdatyev (Tonix-Tuft) <antonytuft@gmail.com>
 */
class TmpFile implements TmpFileInterface {
  /**
   * @var string
   */
  const CHARS = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

  /**
   * {@inheritdoc}
   */
  public function create($dir, $prefix, $suffix, $autoDelete = true) {
    $dir = realpath(rtrim($dir, DIRECTORY_SEPARATOR));
    $chars = static::CHARS;
    $length = strlen($chars) - 1;

    $attemptsPerCharsCount = 1024;
    $variableCharsCount = 6;

    $randomChars = function () use ($chars, $length, &$variableCharsCount) {
      $len = $variableCharsCount;
      $random = '';
      for ($i = 0; $i < $len; $i++) {
        $random .= $chars[mt_rand(0, $length)];
      }
      return $random;
    };

    $attempts = 0;
    $filePath = implode(DIRECTORY_SEPARATOR, [
      $dir,
      $prefix . $randomChars() . $suffix,
    ]);
    while (!($fd = @fopen($filePath, 'x+'))) {
      $attempts++;
      if ($attempts >= $attemptsPerCharsCount) {
        $attempts = 0;
        $variableCharsCount++;
      }
      $filePath = implode(DIRECTORY_SEPARATOR, [
        $dir,
        $prefix . $randomChars() . $suffix,
      ]);
    }
    $tmpFilePath = $filePath;
    register_shutdown_function(function () use ($fd) {
      if ($fd) {
        fclose($fd);
      }
    });
    if ($autoDelete) {
      register_shutdown_function(function () use ($tmpFilePath) {
        if (file_exists($tmpFilePath)) {
          unlink($tmpFilePath);
        }
      });
    }

    return $tmpFilePath;
  }
}
