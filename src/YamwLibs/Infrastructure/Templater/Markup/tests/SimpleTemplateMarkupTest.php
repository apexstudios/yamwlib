<?php
namespace YamwLibs\Infrastructure\Templater\Markup;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-02-10 at 23:17:10.
 *
 * @author AnhNhan <john.doe@example.com>
 */
class SimpleTemplateMarkupTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SimpleTemplateMarkup
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new SimpleTemplateMarkup(
            "somename",
            "somepattern",
            "somecontent",
            true
        );
    }

    /**
     * @covers YamwLibs\Infrastructure\Templater\Markup\SimpleTemplateMarkup::getContent
     */
    public function testHasContent()
    {
        self::assertSame("somecontent",$this->object->getContent());
    }

    /**
     * @covers YamwLibs\Infrastructure\Templater\Markup\SimpleTemplateMarkup::getName
     */
    public function testHasName()
    {
        self::assertSame("somename",$this->object->getName());
    }

    /**
     * @covers YamwLibs\Infrastructure\Templater\Markup\SimpleTemplateMarkup::getPattern
     */
    public function testHasPattern()
    {
        self::assertSame("somepattern",$this->object->getPattern());
    }

    /**
     * @covers YamwLibs\Infrastructure\Templater\Markup\SimpleTemplateMarkup::getPattern
     */
    public function testHasType()
    {
        self::assertSame("SimpleTemplateMarkup",$this->object->getType());
    }

    /**
     * @covers YamwLibs\Infrastructure\Templater\Markup\SimpleTemplateMarkup::isCritical
     */
    public function testHasCriticalStatus()
    {
        // Object was initialized with $critical = true, which is not the
        // default value of `false`
        self::assertSame(true, $this->object->isCritical());
    }
}
