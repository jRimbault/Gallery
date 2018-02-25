<?php

namespace Gallery\Utils;


class Json
{
    /**
     * Send a JSON payload to the client and an http responde code
     * and terminates the program
     * Shortcut method
     * @param array $array
     * @param int   $code  http response code
     */
    public static function Response(array $array, int $code = 200)
    {
        header('Content-Type: application/json');
        http_response_code($code);
        die(json_encode($array, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    /**
     * Wrapper around json_decode and file_get_contents
     * Allow quickly decoding any json stream reachable by file_get_contents
     */
    public static function DecodeFile(
        string $file,
        bool $assoc = true,
        int $depth = 512,
        int $options = 0)
    {
        return json_decode(
            file_get_contents($file),
            $assoc,
            $depth,
            $options
        );
    }

    /**
     * Pretty print an array to a file
     * @param array  $array json object
     * @param string $file  path to the destination file
     */
    public static function writeToFile(array $array, string $file)
    {
        return file_put_contents(
            $file,
            json_encode(
                $array,
                JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
            )
        );
    }
}
