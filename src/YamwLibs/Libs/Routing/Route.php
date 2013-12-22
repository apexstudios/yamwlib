<?php
namespace YamwLibs\Libs\Routing;

/**
 * A single Route for the Routing framework
 *
 * @author AnhNhan <anhnhan@outlook.com>
 */
class Route
{
    private $name;
    private $pattern;
    private $target;

    private $requirements = array();
    private $parameters = array();

    /**
     * Contructs a Route
     *
     * @param string $name
     * An identifier - currently unused, but would still be cool if you were to
     * provide one
     *
     * @param string $pattern
     * A pattern against which incoming URLs are being matched
     *
     * @param string $target
     * The name of the target controller class
     */
    public function __construct($name, $pattern, $target)
    {
        $this->name = $name;
        $this->pattern = $pattern;
        $this->target = $target;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setRequirements(array $requirements)
    {
        $this->requirements = $requirements;
    }

    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Whether this route will handle the current URI or not
     *
     * @param string $uri
     * @return boolean
     */
    public function doesHandle($uri)
    {
        return PatternMatcher::isMatching($uri, $this->pattern);
    }

    /**
     * Processes a URI and extracts the information
     *
     * @param string $uri
     * @return array
     */
    public function handle($uri)
    {

        $variableList = PatternMatcher::extract($uri, $this->pattern);

        // Now check for some given params in the routes scheme file
        // Overwrites any values obtained from URL
        if ($this->parameters) {
            foreach ($this->parameters as $parameterName => $parameterValue) {
                $variableList[$parameterName] = $parameterValue;
            }
        }

        // Now check if there are requirements
        if ($this->requirements) {
            foreach ($this->requirements as $variableField => $requirement) {
                foreach ($requirement as $req_type => $req_value) {
                    switch ($req_type) {
                        case 'type':
                            if (gettype($variableList[$variableField]) != $req_value) {
                                return false;
                            }
                            break;
                        default:
                            trigger_error('Requirement type '.$requirement.' does not exist');
                            break;
                    }
                }
            }
        }

        $variableList['target'] = $this->target;
        $variableList['route']  = $this;

        return $variableList;
    }
}
