<?php
namespace YamwLibs\Libs\View;

/**
 * @author Anh Nhan Nguyen <anhnhan@outlook.com>
 */
interface ViewInterface
{
    /**
     * @return \YamwLibs\Libs\Html\Interfaces\YamwMarkupInterface
     */
    public function render();
}
