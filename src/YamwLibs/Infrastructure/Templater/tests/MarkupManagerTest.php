<?php
namespace YamwLibs\Infrastructure\Templater;

/**
 * @author AnhNhan <anhnhan@outlook.com>
 * @covers YamwLibs\Infrastructure\Templater\MarkupManager
 */
class MarkupManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MarkupManager
     */
    private $mgr;

    public function setUp()
    {
        $this->mgr = new MarkupManager;
    }

    public function testCanAddMarkupAndRetrieveIt()
    {
        $markup = new Markup\SimpleTemplateMarkup(
            "name", "p", "c"
        );

        $this->mgr->registerMarkup($markup);

        self::assertSame($markup, $this->mgr->getMarkup("name"));
    }

    public function testCanAddMultipleMarkupsInTheSameExpression()
    {
        $markup1 = new Markup\SimpleTemplateMarkup(
            "name1", "p", "p"
        );

        $markup2 = new Markup\SimpleTemplateMarkup(
            "name2", "p", "p"
        );

        $this->mgr->registerMarkup($markup1)->registerMarkup($markup2);

        self::assertSame($markup1, $this->mgr->getMarkup("name1"));
        self::assertSame($markup2, $this->mgr->getMarkup("name2"));
    }

    public function testKnowsTheNumberOfRegisteredMarkups()
    {
        // Add five markup instances to the manager
        $this->addMultipleMarkup(5);

        self::assertEquals(5, $this->mgr->getMarkupCount());
    }

    public function testCanIterateOverMarkup()
    {
        $this->addMultipleMarkup(2);

        $var = "";

        // Just do something to prove that we iterated over it
        // In this case, we concatenate each content to one string and check it
        foreach ($this->mgr as $markup) {
            $var .= $markup->getContent();
        }

        // Assert that the concatenated string is correct
        self::assertEquals("c1c2", $var);
    }

    public function addMultipleMarkup($count)
    {
        for ($ii = 1; $ii <= $count; $ii++) {
            $markup = new Markup\SimpleTemplateMarkup(
                "name$ii", "p$ii", "c$ii"
            );

            $this->mgr->registerMarkup($markup);
        }
    }
}
