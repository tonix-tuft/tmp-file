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
 * The interface of a temporary file.
 *
 * @author Anton Bagdatyev (Tonix-Tuft) <antonytuft@gmail.com>
 */
interface TmpFileInterface {
  /**
   * Create a temporary file.
   *
   * @param string $dir The directory where to create the temporary file.
   *                    The temporary file MAY also be created in a subdirectory of the given directory.
   *                    In any case it MUST be created in the given directory or its subdirectories,
   *                    where the subdirectories MAY also be creating by the implementors to further
   *                    lower the probability of name collisions.
   * @param string $prefix The prefix of the temporary file.
   * @param string $suffix The suffix of the temporary file.
   * @param bool $autoDelete Whether or not to automatically delete the temporary file. Defaults to TRUE.
   *                         Implementors are free to choose when to automatically delete the temporary file
   *                         when this parameter is set to TRUE (e.g. on script shutdown or after a particular event),
   *                         though they need to keep in mind that the deletion has to happen when the created temporary
   *                         file is really not needed anymore by the consuming code.
   * @return string The absolute filename of the temporary file created.
   * @throws TmpFileException If the creation of the temporary file fails for some reason.
   */
  public function create($dir, $prefix, $suffix, $autoDelete = true);
}
