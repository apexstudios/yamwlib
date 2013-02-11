<?php
namespace YamwLibs\Infrastructure\Profiler;

/**
 * Keeping track of how long stuff takes and how often
 *
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Profiler
 */
class Profiler
{
    /**
     * @var Profiler
     */
    private static $instance;

    /**
     * @var int
     */
    private $numQueries = 0;

    /**
     * Just meant to keep track of all profiler IDs
     *
     * @var array
     */
    private $profilerLog = array();

    /**
     * Gets the profiler instance
     *
     * @return Profiler
     */
    final public static function getInstance()
    {
        if (!isset(self::$instance)) {
            $class = __CLASS__;
            self::$instance = new $class;
        }
        return self::$instance;
    }

    /**
     * Registers a new profiler, optionally including some $extras along the way
     *
     * @param array $extras
     *
     * @return string
     * The id of the profiler
     */
    private function registerNewProfiler(array $extras = null)
    {
        for (;;) {
            $profilerId = md5(microtime());

            if (!in_array($profilerId, $this->profilerLog)) {
                break;
            }
        }

        $profiler = array(
            'id' => $profilerId,
            'extras' => $extras,
            'startTime' => microtime(true),
            'endTime' => -1,
        );

        $this->profilerLog[$profilerId] = $profiler;
        return $profilerId;
    }

    public function simpleProfiler($name)
    {
        return $this->registerNewProfiler(array('name' => $name));
    }

    /**
     *
     *
     * @param type $profilerId
     * The id of the profiler
     *
     * @return array
     * The profiler data
     *
     * @throws \RuntimeException
     * When the profiler was not found
     */
    public function &getProfiler($profilerId)
    {
        if (!isset($this->profilerLog[$profilerId])) {
            throw new \RuntimeException("Profiler $profilerId not registered!");
        }

        return $this->profilerLog[$profilerId];
    }

    public function sqlProfiler($query)
    {
        $this->numQueries++;

        $extra = array(
            'type' => 'sql',
            'query' => $query,
        );

        return $this->registerNewProfiler($extra);
    }

    /**
     * Ends a profiler, setting the end time
     *
     * @param string $profilerId
     * The id of the profiler
     *
     * @throws \RuntimeException
     * When no such profiler was found
     */
    public function stopProfiler($profilerId)
    {
        if (!isset($this->profilerLog[$profilerId])) {
            throw new \RuntimeException("Profiler $profilerId not registered!");
        }

        $profiler =& $this->profilerLog[$profilerId];

        if ($profiler['endTime'] !== -1) {
            throw new Exceptions\ProfilerAlreadyStoppedException(
                "The profiler $profilerId has already been stopped"
            );
        }

        $profiler['endTime'] = microtime(true);
        $profiler['timeTaken'] = $profiler['endTime'] - $profiler['startTime'];
        return $profiler;
    }

    /**
     * Gets the number of sql queries
     *
     * @return int
     */
    public function getNumQueries()
    {
        return $this->numQueries;
    }
}
