<?php
namespace YamwLibs\Infrastructure\Templater\Markup;

/**
 * @author AnhNhan <anhnhan@outlook.com>
 * @covers YamwLibs\Infrastructure\Templater\Markup\MethodInvocationMarkup
 */
class MethodInvocationMarkupTest extends \PHPUnit_Framework_TestCase
{
    public function testCanInvokeFunction()
    {
        $markup = new MethodInvocationMarkup(
            "somename",
            "somepattern",
            array( // The method array, invokes str_repeat with "hey"
                "str_repeat",
                array("hey", 2)
            )
        );

        // Assert that the string was repeated twice
        self::assertSame("heyhey", $markup->getContent());
    }

    public function testCanInvokeMethodOfAClass()
    {
        $object = new SomeClass;

        $markup = new MethodInvocationMarkup(
            "somename",
            "somepattern",
            array( // The method array
                array($object, "someMethod"),
                array("hey")
            )
        );

        self::assertSame("heyheyhey", $markup->getContent());
    }

    public function testCanInvokeStaticMethod()
    {
        $markup = new MethodInvocationMarkup(
            "somename",
            "somepattern",
            array( // The method array
                array(
                    "YamwLibs\Infrastructure\Templater\Markup\SomeClass",
                    "someStaticMethod"
                ),
                array("hey")
            )
        );

        self::assertSame("heyheyheyhey", $markup->getContent());
    }

    // Trivial tests following

    public function testTrivialStuff()
    {
        $this->object = new MethodInvocationMarkup(
            "somename",
            "somepattern",
            array( // The method array, invokes str_repeat with "hey"
                "str_repeat",
                array("hey", 2)
            ),
            true
        );

        // We don't assert for content here, since that is covered above

        // Assert for the name
        self::assertSame("somename",$this->object->getName());

        // Assert for the pattern
        self::assertSame("somepattern",$this->object->getPattern());

        // Assert for type
        self::assertSame("MethodInvocationMarkup",$this->object->getType());

        // Assert for the critical status
        // Object was initialized with $critical = true, which is not the
        // default value of `false`
        self::assertSame(true, $this->object->isCritical());
    }
}

class SomeClass
{
    public static function someStaticMethod($string)
    {
        return str_repeat($string, 4);
    }

    public function someMethod($string)
    {
        return str_repeat($string, 3);
    }
}
