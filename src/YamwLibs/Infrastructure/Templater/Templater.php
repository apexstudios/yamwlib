<?php
namespace YamwLibs\Infrastructure\Templater;

/**
 * Processes and generates templates
 *
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Templater
 */
class Templater
{
    /**
     * @var MarkupManager
     */
    private static $markupMgr;
    private static $template_name;
    private static $template_code;
    private static $proc_crit;
    private static $proc_uncrit;

    public static function loadTemplate($template)
    {
        if (!file_exists($template) || !is_readable($template)) {
            return false;
        }

        self::$template_name = $template;
        self::$template_code = file_get_contents($template);

        return true;
    }

    public static function noTemplate()
    {
        return static::loadTemplate(Config::get('template.default.nt'));
    }

    public static function isUsingTemplate()
    {
        return static::getCurrentTemplate() == Config::get('template.default.nt');
    }

    public static function getCurrentTemplate()
    {
        return static::$template_name;
    }

    public static function generateTemplate()
    {
        if (
            empty(self::$template_code) &&
            !self::loadTemplate(Config::get('template.default'))
        ) {
            throw new \RuntimeException('No template could be loaded!');
        }

        self::processTemplate(false);
        self::processTemplate(true);
    }

    public static function loadCache($cache)
    {
        self::$template_name = 'cached';
        self::$template_code = $cache;
        self::$proc_uncrit = true;
    }

    public static function generateCache()
    {
        if (
            empty(self::$template_code) ||
            !self::loadTemplate(Config::get('template.default'))
        ) {
            throw new RuntimeException('No template could be loaded!');
        }

        self::processTemplate(false);
    }

    public static function processTemplate($crit = true)
    {
        if (($crit ? self::$proc_crit : self::$proc_uncrit)) {
            return false;
        }

        $markupMgr = self::$markupMgr;

        foreach ($markupMgr as $markup) {
            $pattern = '{'.$markup->getPattern().'}';
            if (strpos(self::$template_code, $pattern) !== false) {
                self::$template_code = str_replace(
                    $pattern,
                    $markup->getContent(),
                    self::$template_code
                );
            }
        }

        if ($crit) {
            self::$proc_crit = true;
        } else {
            self::$proc_uncrit = true;
        }
    }

    public static function retrieveTemplate()
    {
        return self::$template_code;
    }

    public static function setMarkupMgr(MarkupManager $mgr)
    {
        self::$markupMgr = $mgr;
    }
}
