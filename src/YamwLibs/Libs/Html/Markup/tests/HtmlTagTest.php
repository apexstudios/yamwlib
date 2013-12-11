<?php
namespace YamwLibs\Libs\Html\Markup;

/**
 * Description of HtmlTagTest
 *
 * @author AnhNhan
 */
class HtmlTagTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider data_classes
     */
    public function testClassesCanBeAdded(array $classes)
    {
        $tag = new HtmlTag('somename');

        foreach ($classes as $value) {
            $tag->addClass($value);
        }

        $string = " ".implode(" ", $classes)." ";
        self::assertEquals($string, $tag->getClasses());
        self::assertRegExp('/<somename class="'.$string.'" \/>/i', $tag->__toString());
    }

    public function data_classes()
    {
        return array(
            array(array('class')),
            array(array('class1', 'class2', 'class3')),
            array(array('class-hey', 'class-hey-ho')),
            array(array('class-hallo', 'class'))
        );
    }

    public function testClassCanBeRemoved()
    {
        $tag = new HtmlTag('somename');

        $tag->addClass(array('class1', 'class2', 'class3'));

        $tag->removeClass('class2');

        $test_classes = $tag->getClasses();
        self::assertFalse(strpos('class2', $test_classes));

        // Remove one from the end
        $tag->removeClass('class3');
        $test_classes = $tag->getClasses();
        self::assertFalse(strpos('class3', $test_classes));

        // Don't accidentally remove class1 when removing class
        $tag->removeClass('class');
        self::assertEquals($test_classes, $tag->getClasses());
    }

    public function testIdCanBeSet()
    {
        $tag = new HtmlTag('somename');

        $tag->setId('someid');

        self::assertRegExp('/<somename id="someid" \/>/i', $tag->__toString());
    }
}
