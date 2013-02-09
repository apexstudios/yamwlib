<?php
namespace YamwLibs\Libs\Text;

class Text
{
    const STD_PROVIDER = "DefaultTextProvider";

    public static function getText()
    {
        return new static(func_get_args());
    }

    private $name;

    /**
     * @var Providers\AbstractTextProvider
     */
    private $provider;

    public function __construct(array $args)
    {
        $this->name = $args;
    }

    public function setProvider($name)
    {
        $className = "YamwLibs\Libs\Text\Providers\\" . $name;

        if (!class_exists($className)) {
            throw new \RuntimeException("Provider $name does not exist");
        }

        $this->provider = new $className;
    }

    public function __toString()
    {
        if (!$this->provider) {
            $this->setProvider(self::STD_PROVIDER);
        }

        $this->name = $this->provider->getSpecificText($this->name);

        return $this->name->__toString();
    }
}
