<?php
namespace YamwLibs\Libs\Assertions;

/**
 * Assertions on file operations
 *
 * @author AnhNhan <anhnhan@outlook.com>
 */
class FileAssertions extends BasicAssertions
{
    public static function assertFileExists($path, $msg)
    {
        if (file_exists(path($path)) && is_file(path($path))) {
            return true;
        } else {
            static::throwException(
                $msg,
                $path . " does not exist",
                null,
                "Yamw\Lib\Assertions\Exceptions\FileNotFoundException"
            );
        }
    }

    public static function assertFileNotExists($path, $msg)
    {
        if (!file_exists(path($path)) && is_file(path($path))) {
            return true;
        } else {
            static::throwException(
                $msg,
                $path . " does exist",
                null,
                "Yamw\Lib\Assertions\Exceptions\FileFoundException"
            );
        }
    }

    public static function assertFileWritable($path, $msg)
    {
        if (is_writable(path($path)) && is_file(path($path))) {
            return true;
        } else {
            static::throwException(
                $msg,
                $path . " is not writeable",
                null,
                "Yamw\Lib\Assertions\Exceptions\FileNotWriteableException"
            );
        }
    }

    public static function assertFileReadable($path, $msg)
    {
        if (is_readable(path($path)) && is_file(path($path))) {
            return true;
        } else {
            static::throwException(
                $msg,
                $path . " is not readable",
                null,
                "Yamw\Lib\Assertions\Exceptions\FileNotReadableException"
            );
        }
    }

    public static function assertFileExecutable($path, $msg)
    {
        if (is_executable(path($path)) && is_file(path($path))) {
            return true;
        } else {
            static::throwException(
                $msg,
                $path . " is not executable",
                null,
                "Yamw\Lib\Assertions\Exceptions\FileNotExecutableException"
            );
        }
    }

    public static function assertFileHasExtension($path, $msg)
    {
        if (count(explode('.', basename(path($path)))) >= 1 && is_file(path($path))) {
            return true;
        } else {
            static::throwException(
                $msg,
                $path . " does not have an extension",
                null,
                "Yamw\Lib\Assertions\Exceptions\FileWrongExtensionException"
            );
        }
    }

    public static function assertFileHasSpecifiedExtension($path, $extension)
    {
        $filename = explode('.', basename(path($path)));

        if (strcasecmp($filename[count($filename) - 1], $extension) === 0 && is_file(path($path))) {
            return true;
        } else {
            static::throwException(
                $msg,
                $path . " does not have the extension $extension",
                null,
                "Yamw\Lib\Assertions\Exceptions\FileWrongExtensionException"
            );
        }
    }

    public static function assertIsFile($path, $msg)
    {
        if (is_file(path($path))) {
            return true;
        } else {
            static::throwException(
                $msg,
                $path . " is not a file",
                null,
                "Yamw\Lib\Assertions\Exceptions\FileNotIsFileException"
            );
        }
    }

    /**
     * Checks whether the given file is an uploaded file.
     *
     * @param type $path
     * This is *NOT* sent through path()
     *
     * @param type $msg
     * @return boolean
     */
    public static function assertIsUploadedFile($path, $msg)
    {
        if (is_uploaded_file($path) && is_file(path($path))) {
            return true;
        } else {
            static::throwException(
                $msg,
                $path . " is not an uploaded file",
                null,
                "Yamw\Lib\Assertions\Exceptions\FileNotIsUploadedFileException"
            );
        }
    }

    public static function assertIsSymlink($path, $msg)
    {
        if (is_link(path($path))) {
            return true;
        } else {
            static::throwException(
                $msg,
                $path . " is not a symlink",
                null,
                "Yamw\Lib\Assertions\Exceptions\FileNotIsSymlinkException"
            );
        }
    }

    public static function assertIsDirectory($path, $msg)
    {
        if (is_dir(path($path))) {
            return true;
        } else {
            static::throwException(
                $msg,
                $path . " is not a dir",
                null,
                "Yamw\Lib\Assertions\Exceptions\DirNotIsDirException"
            );
        }
    }

    public static function assertDirectoryExists($path, $msg)
    {
        if (file_exists(path($path)) && is_dir(oath($path))) {
            return true;
        } else {
            static::throwException(
                $msg,
                $path . " does not exist",
                null,
                "Yamw\Lib\Assertions\Exceptions\DirNotFoundException"
            );
        }
    }

    public static function assertNotExists($path, $msg)
    {
        if (!file_exists(path($path))) {
            return true;
        } else {
            static::throwException(
                $msg,
                $path . " does exist",
                null,
                "Yamw\Lib\Assertions\Exceptions\FoundException"
            );
        }
    }

    public static function assertDirectoryWritable($path, $msg)
    {
        if (is_writeable(path($path)) && is_dir(path($path))) {
            return true;
        } else {
            static::throwException(
                $msg,
                $path . " is not writeable",
                null,
                "Yamw\Lib\Assertions\Exceptions\DirNotWriteableException"
            );
        }
    }
}
