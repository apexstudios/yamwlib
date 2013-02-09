<?php
namespace YamwLibs\Libs\Text\Providers;

/**
 * @author AnhNhan <anhnhan@outlook.com>
 */
class DefaultTextProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DefaultTextProvider
     */
    private $provider;

    public function setUp()
    {
        $this->provider = new DefaultTextProvider;
    }

    public function testSimpleProvide()
    {
        $string = "Hey this is some string";

        $text = $this->provider->getSpecificText($string);

        self::assertSame(
            $string,
            (string)$text
        );
    }

    public function testFormattedProvide()
    {
        $string = "Hey %s, you have %d new messages";
        $arg1 = "Joe";
        $arg2 = 15;

        $compare = "Hey Joe, you have 15 new messages";

        $provided = $this->provider->getSpecificText($string, $arg1, $arg2);

        self::assertSame($compare, (string)$provided);
    }
}
