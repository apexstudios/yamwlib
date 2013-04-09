<?php
namespace YamwLibs\Libs\Assertions;

/**
 * Assertions on file operations
 *
 * @author AnhNhan <anhnhan@outlook.com>
 */
class FileAssertions extends BasicAssertions
{
    public static function assertFileExists($path, $msg = null)
    {
        if (file_exists($path) && is_file($path)) {
            return true;
        } else {
            static::throwException(
                $msg,
                $path . " does not exist",
                null,
                "YamwLibs\Libs\Assertions\Exceptions\FileNotFoundException"
            );
        }
    }

    public static function assertFileNotExists($path, $msg = null)
    {
        if (!file_exists($path) && is_file($path)) {
            return true;
        } else {
            static::throwException(
                $msg,
                $path . " does exist",
                null,
                "YamwLibs\Libs\Assertions\Exceptions\FileFoundException"
            );
        }
    }

    public static function assertFileWritable($path, $msg = null)
    {
        if (is_writable($path) && is_file($path)) {
            return true;
        } else {
            static::throwException(
                $msg,
                $path . " is not writeable",
                null,
                "YamwLibs\Libs\Assertions\Exceptions\FileNotWriteableException"
            );
        }
    }

    public static function assertFileReadable($path, $msg = null)
    {
        if (is_readable($path) && is_file($path)) {
            return true;
        } else {
            static::throwException(
                $msg,
                $path . " is not readable",
                null,
                "YamwLibs\Libs\Assertions\Exceptions\FileNotReadableException"
            );
        }
    }

    public static function assertFileExecutable($path, $msg = null)
    {
        if (is_executable($path) && is_file($path)) {
            return true;
        } else {
            static::throwException(
                $msg,
                $path . " is not executable",
                null,
                "YamwLibs\Libs\Assertions\Exceptions\FileNotExecutableException"
            );
        }
    }

    public static function assertFileHasExtension($path, $msg = null)
    {
        if (count(explode('.', basename($path))) >= 1 && is_file($path)) {
            return true;
        } else {
            static::throwException(
                $msg,
                $path . " does not have an extension",
                null,
                "YamwLibs\Libs\Assertions\Exceptions\FileWrongExtensionException"
            );
        }
    }

    public static function assertFileHasSpecifiedExtension($path, $extension)
    {
        $filename = explode('.', basename($path));

        if (strcasecmp($filename[count($filename) - 1], $extension) === 0 && is_file($path)) {
            return true;
        } else {
            static::throwException(
                $msg,
                $path . " does not have the extension $extension",
                null,
                "YamwLibs\Libs\Assertions\Exceptions\FileWrongExtensionException"
            );
        }
    }

    public static function assertIsFile($path, $msg = null)
    {
        if (is_file($path)) {
            return true;
        } else {
            static::throwException(
                $msg,
                $path . " is not a file",
                null,
                "YamwLibs\Libs\Assertions\Exceptions\FileNotIsFileException"
            );
        }
    }

    /**
     * Checks whether the given file is an uploaded file.
     *
     * @param type $path
     * This is *NOT* sent through
     *
     * @param type $msg
     * @return boolean
     */
    public static function assertIsUploadedFile($path, $msg = null)
    {
        if (is_uploaded_file($path) && is_file($path)) {
            return true;
        } else {
            static::throwException(
                $msg,
                $path . " is not an uploaded file",
                null,
                "YamwLibs\Libs\Assertions\Exceptions\FileNotIsUploadedFileException"
            );
        }
    }

    public static function assertIsSymlink($path, $msg = null)
    {
        if (is_link($path)) {
            return true;
        } else {
            static::throwException(
                $msg,
                $path . " is not a symlink",
                null,
                "YamwLibs\Libs\Assertions\Exceptions\FileNotIsSymlinkException"
            );
        }
    }

    public static function assertIsDirectory($path, $msg = null)
    {
        if (is_dir($path)) {
            return true;
        } else {
            static::throwException(
                $msg,
                $path . " is not a dir",
                null,
                "YamwLibs\Libs\Assertions\Exceptions\DirNotIsDirException"
            );
        }
    }

    public static function assertDirectoryExists($path, $msg = null)
    {
        if (file_exists($path) && is_dir(oath($path))) {
            return true;
        } else {
            static::throwException(
                $msg,
                $path . " does not exist",
                null,
                "YamwLibs\Libs\Assertions\Exceptions\DirNotFoundException"
            );
        }
    }

    public static function assertNotExists($path, $msg = null)
    {
        if (!file_exists($path)) {
            return true;
        } else {
            static::throwException(
                $msg,
                $path . " does exist",
                null,
                "YamwLibs\Libs\Assertions\Exceptions\FoundException"
            );
        }
    }

    public static function assertDirectoryWritable($path, $msg = null)
    {
        if (is_writeable($path) && is_dir($path)) {
            return true;
        } else {
            static::throwException(
                $msg,
                $path . " is not writeable",
                null,
                "YamwLibs\Libs\Assertions\Exceptions\DirNotWriteableException"
            );
        }
    }
}
