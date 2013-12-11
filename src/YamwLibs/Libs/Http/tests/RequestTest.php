<?php
namespace YamwLibs\Libs\Http;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    public $className = '\Yamw\Lib\Request';

    public function testInitializationPopulatesInitialState()
    {
        $request = new Request;
        // Just to be sure that it is non-existent
        self::assertSame(null, $request->getValue('heyho'));
        self::assertSame(null, $request->getValue('dzde'));

        $data = array(
            'dzde' => 'default',
            'heyho' => 'it exists'
        );
        $request->populate($data);

        // Now the data exists
        self::assertSame('it exists', $request->getValue('heyho'));
        self::assertSame('default', $request->getValue('dzde'));

        // Init with other data
        $data = array(
            'dzde' => 'wut?',
            'heyho' => 'yup, it\'s true'
        );
        $request->populate($data);

        // Now some other data exists
        self::assertSame('yup, it\'s true', $request->getValue('heyho'));
        self::assertSame('wut?', $request->getValue('dzde'));
    }

    public static function testCanSetRequestValues()
    {
        $request = new Request;
        // Init with other data
        $data = array(
            'section' => 'wut?',
        );
        $request->populate($data);

        self::assertSame('wut?', $request->getValue('section'));

        // Set it to a new value
        $request->setValue('section', 'whatever');
        self::assertSame('whatever', $request->getValue('section'));
    }

    public function testCanPopulateFromGet()
    {
        $request = new Request;
        // Just filling the superglobal...
        $_GET['hi'] = 'hey';
        self::assertArrayHasKey('hi', $_GET);

        $request->populateFromGet();

        self::assertEquals('hey', $request->getValue('get-hi'));
    }

    public function testCanPopulateFromPost()
    {
        $request = new Request;
        // Just filling the superglobal...
        $_POST['hi'] = 'hey';
        self::assertArrayHasKey('hi', $_POST);

        $request->populateFromPost();

        self::assertEquals('hey', $request->getValue('post-hi'));
    }
}
