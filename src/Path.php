<?php

namespace Gallery;

/**
 * Helper class to deal with paths
 * Roughly inspired by the pathlib in python
 */
class Path implements \JsonSerializable
{
    private $path;
    private static $root;

    /**
     * Helper class to deal with paths
     * Roughly inspired by the pathlib in python
     */
    public function __construct(string $path = '')
    {
        $this->set($path);
    }

    /**
     * User can set an arbitrary root path to be used
     * for absolute paths
     * @param string $path absolute path to the project root directory
     */
    public static function setRoot(string $path)
    {
        self::$root = rtrim(
            str_replace('/', DIRECTORY_SEPARATOR, $path),
            DIRECTORY_SEPARATOR
        );
    }

    /** change the path */
    public function set(string $path)
    {
        $this->path = str_replace('/', DIRECTORY_SEPARATOR, $path);
    }

    /** automatic translation of the path */
    public function __toString(): string
    {
        if ($this->path[0] === DIRECTORY_SEPARATOR) {
            return self::Root() . $this->path;
        }
        return $this->path;
    }

    /**
     * Calling file_exists directly on the object works (toString),
     * but this is cleaner
     */
    public function fileExists(): bool
    {
        return file_exists(join(DIRECTORY_SEPARATOR, [
            self::Root(),
            $this->path
        ]));
    }

    /** implementation of jsonSerialize, just use toString */
    public function jsonSerialize(): string
    {
        return $this->__toString();
    }

    /**
     * Alias for explicitely calling toString
     */
    public function get(): string
    {
        return $this->__toString();
    }

    /** get the last part of the path */
    public function name(): string
    {
        return basename($this->path);
    }

    /** get the file extension at the end of the filename */
    public function extension(): string
    {
        if (strpos($this->name(), '.') === false) {
            return $this->name();
        }
        $array = explode('.', $this->name());
        return end($array);
    }

    /**
     * Returns the parts composing the path
     */
    public function atomize(): array
    {
        return array_filter(explode(
            DIRECTORY_SEPARATOR,
            $this->path
        ));
    }

    /**
     * Collection of static methods
     */

    /** Short for the root directory of the current project */
    public static function Root(): string
    {
        return self::$root ?? dirname(__DIR__);
    }

    /** Shortcut to the gallery directory */
    public static function Gallery(): string
    {
        return join(DIRECTORY_SEPARATOR, [
            self::Root(),
            'public',
            'gallery',
        ]);
    }

    /** Shortcut to the front-end libraries directory */
    public static function AssetsLib(): string
    {
        return join(DIRECTORY_SEPARATOR, [
            self::Root(),
            'public',
            'assets',
            'lib',
        ]);
    }
}
