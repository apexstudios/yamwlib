<?php
namespace YamwLibs\Infrastructure\Templater;

/**
 * @author AnhNhan <anhnhan@outlook.com>
 */
class TemplaterTest extends \PHPUnit_Framework_TestCase
{
    public function testSimpleTemplateGeneration()
    {
        $markupMgr = new MarkupManager;
        $filePath = __DIR__ . "/mocks/basic_template";
        $cmpPath = __DIR__ . "/mocks/generated_template";
        $date = date(DATE_RFC2822, time());

        $markupName = new Markup\SimpleTemplateMarkup(
            'name',
            'NAME',
            'John Doe'
        );

        $markupTime = new Markup\MethodInvocationMarkup(
            'time',
            'TIME',
            array(
                'date',
                array(DATE_RFC2822, time())
            )
        );

        $markupMgr->registerMarkup($markupName)->registerMarkup($markupTime);

        Templater::loadCache(file_get_contents($filePath));
        Templater::setMarkupMgr($markupMgr);
        Templater::generateTemplate();

        $generatedTemplate = Templater::retrieveTemplate();
        self::assertEquals(
            trim(file_get_contents($cmpPath)) . " " . $date,
            trim($generatedTemplate)
        );
    }
}
