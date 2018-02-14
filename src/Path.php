<?php

namespace Gallery;


class Path implements \JsonSerializable
{
    private $path;

    public function __construct(string $path)
    {
        $this->path = str_replace('/', DIRECTORY_SEPARATOR, $path);
    }

    public function __toString()
    {
        if ($this->path[0] === DIRECTORY_SEPARATOR) {
            return self::Root() . $this->path;
        }
        return $this->path;
    }

    public function jsonSerialize()
    {
        return $this->__toString();
    }

    public function name()
    {
        return basename($this->path);
    }

    public function extension()
    {
        if (strpos($this->name(), '.') === false) {
            return $this->name();
        }
        $array = explode('.', $this->name());
        return end($array);
    }

    public function atomize()
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
    public static function Root()
    {
        return dirname(__DIR__);
    }

    /** Shortcut to the gallery directory */
    public static function Gallery() {
        return join(DIRECTORY_SEPARATOR, [
            self::Root(),
            'public',
            'gallery',
        ]);
    }

    /** Shortcut to the front-end libraries directory */
    public static function AssetsLib() {
        return join(DIRECTORY_SEPARATOR, [
            self::Root(),
            'public',
            'assets',
            'lib',
        ]);
    }
}
