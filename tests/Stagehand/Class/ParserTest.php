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
 * @package    sh-class-parser
 * @copyright  2009 KUMAKURA Yousuke <kumatch@gmail.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 * @version    Release: @package_version@
 * @since      File available since Release 0.1.0
 */

// {{{ Stagehand_Class_ParserTest

/**
 * Some tests for Stagehand_Class_Parser
 *
 * @package    sh-class-parser
 * @copyright  2009 KUMAKURA Yousuke <kumatch@gmail.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 * @version    Release: @package_version@
 * @since      Class available since Release 0.1.0
 */
class Stagehand_Class_ParserTest extends PHPUnit_Framework_TestCase
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

    private $_filename;

    /**#@-*/

    /**#@+
     * @access public
     */

    public function setUp()
    {
        $this->_filename = dirname(__FILE__) . '/ParserTest/Foo.php';
    }

    public function tearDown() { }

    /**
     * @test
     */
    public function parseAClass()
    {
        $class = Stagehand_Class_Parser::parse($this->_filename);

        $this->assertType('Stagehand_Class', $class);
        $this->assertEquals($class->getName(), 'Stagehand_Class_ParserTest_Foo');
        $this->assertFalse($class->isAbstract());
        $this->assertFalse($class->isInterface());
    }

    /**
     * @test
     */
    public function parseAllConstantsOfAClass()
    {
        $class = Stagehand_Class_Parser::parse($this->_filename);

        $constants = $class->getConstants();

        $this->assertEquals(count($constants), 8);

        $this->assertEquals($constants['number']->getValue(), 10);
        $this->assertEquals($constants['string']->getValue(), 'example');
        $this->assertEquals($constants['namespace']->getValue(), 'Foo::A');
        $this->assertEquals($constants['entryFoo']->getValue(), 20);
        $this->assertEquals($constants['entryBar']->getValue(), 30);

        $this->assertFalse($constants['number']->isParsable());
        $this->assertFalse($constants['string']->isParsable());
        $this->assertTrue($constants['namespace']->isParsable());
        $this->assertFalse($constants['entryFoo']->isParsable());
        $this->assertFalse($constants['entryBar']->isParsable());
    }

    /**
     * @test
     */
    public function parseAllPropertiesOfAClass()
    {
        $class = Stagehand_Class_Parser::parse($this->_filename);

        $properties = $class->getProperties();

        $this->assertEquals(count($properties), 24);

        $this->assertNull($properties['foo']->getValue());
        $this->assertEquals($properties['bar']->getValue(), 100);
        $this->assertEquals($properties['baz']->getValue(), 'BAZ');
        $this->assertEquals($properties['qux']->getValue(), 'Foo::A');

        $this->assertNull($properties['a']->getValue());
        $this->assertNull($properties['b']->getValue());
        $this->assertEquals($properties['c']->getValue(), 'c');
        $this->assertNull($properties['d']->getValue());
        $this->assertNull($properties['e']->getValue());
        $this->assertEquals($properties['f']->getValue(), 'f');
        $this->assertEquals($properties['g']->getValue(), 'g');
        $this->assertEquals($properties['h']->getValue(), 'h');
        $this->assertNull($properties['i']->getValue());
        $this->assertEquals($properties['j']->getValue(), 'j');

        $this->assertTrue($properties['foo']->isPublic());
        $this->assertTrue($properties['bar']->isPublic());
        $this->assertTrue($properties['bar']->isStatic());
        $this->assertTrue($properties['baz']->isPublic());
        $this->assertTrue($properties['qux']->isPublic());
        $this->assertTrue($properties['_bar']->isProtected());
        $this->assertTrue($properties['_baz']->isPrivate());

        $this->assertTrue($properties['a']->isPublic());
        $this->assertTrue($properties['b']->isPublic());
        $this->assertTrue($properties['c']->isPublic());
        $this->assertTrue($properties['d']->isPublic());
        $this->assertTrue($properties['e']->isPublic());
        $this->assertTrue($properties['f']->isPublic());
        $this->assertTrue($properties['g']->isPublic());
        $this->assertTrue($properties['h']->isPublic());
        $this->assertTrue($properties['i']->isPublic());
        $this->assertTrue($properties['i']->isStatic());
        $this->assertTrue($properties['j']->isPublic());
        $this->assertTrue($properties['j']->isStatic());


    }

    /**#@-*/

    /**#@+
     * @access protected
     */

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
