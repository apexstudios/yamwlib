<?php
namespace YamwLibs\Infrastructure\Profiler;

/**
 * @author AnhNhan <anhnhan@outlook.com>
 */
class ProfilerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Profiler
     */
    private $profiler;

    public function setUp()
    {
        $this->profiler = new Profiler;
    }

    public function testSimpleProfile()
    {
        $timeStart = microtime(true);

        $id = $this->profiler->simpleProfiler("some name");

        usleep(5000);

        $timeEnd = microtime(true);
        $profiler = $this->profiler->stopProfiler($id);

        // Assert that the numbers are in the right order
        self::assertLessThan($timeEnd, $timeStart);
        self::assertLessThan($profiler['endTime'], $profiler['startTime']);

        // Our measured start and end times are roughly equal
        self::assertEquals($timeEnd, $profiler['endTime'], null, 0.0001);
        self::assertEquals($timeStart, $profiler['startTime'], null, 0.0001);
    }

    public function testSqlNumRows()
    {
        // Simulate three queries
        $this->profiler->sqlProfiler("some query");
        $this->profiler->sqlProfiler("some query");
        $this->profiler->sqlProfiler("some query");

        // Do not stop the profilers, jump right to the assertions
        // How evil!
        self::assertEquals(3, $this->profiler->getNumQueries());
    }
}
