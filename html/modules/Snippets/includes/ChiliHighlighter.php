<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * The main include file for ChiliHighlighter class
 *
 * PHP version 4 and 5
 *
 * ChiliHighlighter is a simple PHP wrapper for client-side Chili code highlighter
 * created by Andrea Ercolino as a plugin for jQuery library.
 *
 * JS Chili Plugin (c) 2007 Andrea Ercolino
 * ChiliHighlighter PHP Class (c) 2007 Vagharshak Tozalakyan
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @version  0.1.0
 * @author   Vagharshak Tozalakyan <vagh@tozalakyan.com>
 * @license  http://www.opensource.org/licenses/mit-license.php
 */

/**
 * Syntax highlighting tool for C++, C#, CSS, Delphi, Java, JavaScript, LotusScript,
 * MySQL, PHP, and XHTML listings.
 *
 * This class can be used to decorate code listings in most of popular computer
 * languages.
 *
 * @author   Vagharshak Tozalakyan <vagh@tozalakyan.com>
 * @license  http://www.opensource.org/licenses/mit-license.php
 */
class ChiliHighlighter
{
    public static function init($dir)
    {
        $dir = str_replace('\\', '/', $dir);
        if (substr($dir, -1) == '/') {
            $dir = substr($dir, 0, -1);
        }
        echo '<script type="text/javascript" src="modules/Snippets/includes/' . $dir . '/chili-1.7b.pack.js"></script>' . "\n";
        echo '<script type="text/javascript" src="modules/Snippets/includes/' . $dir . '/recipes.js"></script>' . "\n";
    }

    public static function highlightFile($fileName, $lang = 'php')
    {
        $fp = fopen($fileName, 'r');
        $content = fread($fp, filesize($fileName));
        fclose($fp);
        echo '<pre><code class="' . $lang . '">' . "\n";
        echo htmlspecialchars($content);
        echo '</code></pre>' . "\n";
    }

    public static function highlightString($code, $lang = 'php')
    {
        echo '<pre><code class="' . $lang . '">' . "\n";
        echo $code;
        echo '</code></pre>' . "\n";
    }
}
?>