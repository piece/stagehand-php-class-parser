<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * PHP version 5
 *
 * Copyright (c) 2009 KUMAKURA Yousuke <kumatch@gmail.com>,
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package    stagehand-php-class-parser
 * @copyright  2009 KUMAKURA Yousuke <kumatch@gmail.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 * @version    Release: @package_version@
 * @since      File available since Release 0.1.0
 */

// {{{ Stagehand_PHP_Class_Parser

/**
 * A class for parsing PHP class.
 *
 * @package    stagehand-php-class-parser
 * @copyright  2009 KUMAKURA Yousuke <kumatch@gmail.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 * @version    Release: @package_version@
 * @since      Class available since Release 0.1.0
 */
class Stagehand_PHP_Class_Parser
{

    // {{{ properties

    /**#@+
     * @access public
     */

    /**#@-*/

    /**#@+
     * @access protected
     */

    /**#@-*/

    /**#@+
     * @access private
     */

    /**#@-*/

    /**#@+
     * @access public
     */

    // }}}
    // {{{ parse()

    /**
     * Parses PHP classes from file.
     *
     * @param string $filename  a filename of PHP script.
     * @return mixed
     */
    public static function parse($filename)
    {
        $lexer = new Stagehand_PHP_Lexer($filename);

        return self::_parse($lexer);
    }

    // }}}
    // {{{ parseContents()

    /**
     * Parses PHP classes from text contents.
     *
     * @param string $contents  PHP script contents.
     * @return mixed
     */
    public static function parseContents($contents)
    {
        $lexer = new Stagehand_PHP_Lexer();
        $lexer->setContents($contents);

        return self::_parse($lexer);
    }

    /**#@-*/

    /**#@+
     * @access protected
     */

    // }}}
    // {{{ _parse()

    /**
     * Parses PHP classes.
     *
     * @param mixed $lexer   A lexical analyzer for Stagehand_PHP_Parser
     * @return mixed
     */
    protected static function _parse($lexer)
    {
        $filter = new Stagehand_PHP_Class_Parser_Filter();

        $parser = new Stagehand_PHP_Parser($lexer, $filter);
        $parser->parse();

        $classes = $filter->getClasses();

        $code = $filter->getExternalCode();
        if ($code) {
            $class = $filter->getCurrentClass();
            $class->setPostCode($code);
            $filter->setExternalCode('');
        }

        if (!count($classes)) {
            return;
        }

        if (count($classes) == 1) {
            return $classes[0];
        }

        return $classes;
    }

    /**#@-*/

    /**#@+
     * @access private
     */

    /**#@-*/

    // }}}
}

// }}}

/*
 * Local Variables:
 * mode: php
 * coding: iso-8859-1
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * indent-tabs-mode: nil
 * End:
 */
