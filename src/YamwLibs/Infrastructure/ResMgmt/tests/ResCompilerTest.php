<?php
namespace YamwLibs\Infrastructure\ResMgmt;

/**
 * Description of ResCompilerTest
 *
 * @author anhnhan
 */
class ResCompilerTest extends \PHPUnit_Framework_TestCase
{
    public function testSimpleCompile()
    {
        $basePath = __DIR__ . '/mocks/';
        $cmpPath = $basePath . 'output';
        $cmpContent = file_get_contents($cmpPath);
        $fileList = array(
            $basePath . 'file1.less',
            $basePath . 'file2.less',
        );

        $resC = new ResCompiler('css');
        foreach ($fileList as $file) {
            var_dump($file);
            $resC->pushResource($file);
        }

        self::assertEquals(
            $cmpContent,
            $resC->compile()
        );
    }
}
