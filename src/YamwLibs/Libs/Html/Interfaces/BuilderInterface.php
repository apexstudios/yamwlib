<?php
namespace YamwLibs\Libs\Html\Interfaces;

/**
 * The Builder interface
 *
 * @author Anh Nhan Nguyen <anhnhan@outlook.com>
 * @package YamwLibs
 */
interface BuilderInterface
{
    /**
     * Tells the builder to build its mark-up
     */
    public function build();

    public function isBuilt();

    /**
     * Returns the built mark-up
     *
     * @return string The generated mark-up
     */
    public function retrieve();
}
