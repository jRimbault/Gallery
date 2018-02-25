<?php

namespace Gallery\Utils;


class Color implements \JsonSerializable
{
    private $color;
    private $rgb;

    private $red;
    private $green;
    private $blue;

    private $hue;
    private $saturation;
    private $lightness;

    /**
     * Color constructor.
     * @param string $string rgb or rrggbb string with or without a leading '#'
     * @throws \Exception
     */
    public function __construct(string $input)
    {
        $input = ltrim($input, '#');
        if (!$this->isHexColor($input)) {
            throw new \Exception(
                "Class Color: `$input` isn't a valid color, only accepts" .
                " `rgb` or `rrggbb`, with or without a leading `#`",
                1
            );
        }
        $this->color = $input;
        $this->toHSL();
    }

    /**
     * Color constructor.
     * @param string $string rgb or rrggbb string with or without a leading '#'
     * @throws \Exception
     */
    public static function withHEX(string $input): self
    {
        return new self($input);
    }

    /**
     * Color constructor. Values must be between [0-255]
     * @param int $red   red value
     * @param int $green green value
     * @param int $blue  blue value
     * @throws \Exception
     */
    public static function withRGB(int $red, int $green, int $blue): self
    {
        self::isValidRGB($red, $green, $blue);
        $hex[] = (string) dechex($red);
        $hex[] = (string) dechex($green);
        $hex[] = (string) dechex($blue);
        foreach ($hex as &$e) {
            $e = strlen($e) === 1 ? '0' . $e : $e;
        }
        return new self(join($hex));
    }

    /**
     * Check if the three values are in the correct RGB range [0-255]
     * @param int $red
     * @param int $green
     * @param int $blue
     */
    private static function isValidRGB(int $red, int $green, int $blue)
    {
        $errors = [false, false, false];
        if (!self::isInValidRange($red)) { $errors[0] = true; }
        if (!self::isInValidRange($green)) { $errors[1] = true; }
        if (!self::isInValidRange($blue)) { $errors[2] = true; }
        if (in_array(true, $errors)) {
            $message[] = "Value(s) should be between 0 and 255";
            if ($errors[0]) { $message[] = "red=$red"; }
            if ($errors[1]) { $message[] = "green=$green"; }
            if ($errors[2]) { $message[] = "blue=$blue"; }
            throw new \Exception(join($message, ', '), 2);
        }
    }

    /**
     * Check if n is in [0-255]
     * @param int $n
     */
    private static function isInValidRange(int $n): bool
    {
        if ($n < 0) return false;
        if ($n > 255) return false;
        return true;
    }

    /**
     * Sanity check before proceeding
     * Could be improved by accepting other format than RRGGBB
     * and supply to the RRGGBB string needed by the other functions
     */
    private function isHexColor(string $input): bool
    {
        if (!ctype_xdigit($input)) return false;
        if (!in_array(strlen($input), [3, 6])) return false;
        return true;
    }

    /** Mainly here because it allows the computation of the HSL values */
    private function toRGB(): int
    {
        if (strlen($this->color) === 3) {
            $this->color = self::doubleString($this->color);
        }
        $this->red = hexdec(substr($this->color, 0, 2));
        $this->green = hexdec(substr($this->color, 2, 2));
        $this->blue = hexdec(substr($this->color, 4, 2));

        return $this->rgb = $this->blue + ($this->green << 0x8) + ($this->red << 0x10);
    }

    /** Double each char in a string */
    private static function doubleString(string $input): string
    {
        $string = [];
        foreach (str_split($input) as $char) {
            $string[] = str_repeat($char, 2);
        }
        return join($string);
    }

    /**
     * Computes the HSL (Hue, Saturation, Lightness) of the color
     * I want this to determine if the color is light or dark
     * to change the color of the text accordingly
     */
    private function toHSL(): array
    {
        $this->toRGB();
        $r = $this->red / 255;
        $g = $this->green / 255;
        $b = $this->blue / 255;

        $max = max([$r, $g, $b]);
        $min = min([$r, $g, $b]);

        /** shade of grey (monochromatic) */
        $hue = 0;
        $saturation = 0;
        $lightness = ($max + $min) / 2;

        /** not shade of grey (!monochromatic) */
        if (0 < $delta = $max - $min) {
            $saturation = $delta / (1 - abs(2 * $lightness - 1));
            switch ($max) {
                case $r:
                    $hue = ($g - $b) / $delta;
                    break;
                case $g;
                    $hue = 2 + ($b - $r) / $delta;
                    break;
                case $b;
                    $hue = 4 + ($r - $g) / $delta;
                    break;
            }
            $hue /= 6;
        }

        return [
            'hue' => $this->hue = (int) round(255 * $hue),
            'saturation' => $this->saturation = (int) round(255 * $saturation),
            'lightness' => $this->lightness = (int) round(255 * $lightness),
        ];
    }

    /** Magic getter method */
    public function __call($method, $params = [])
    {
        $var = strtolower(substr($method, 3));
        if (strncasecmp($method, 'get', 3) === 0 && isset($this->$var)) {
            return $this->$var;
        }
        return null;
    }

    /** translate the color to RGB values in string format */
    public function getRgbString(): string
    {
        return "rgb($this->red, $this->green, $this->blue)";
    }

    /** translate the color to its HEX encoding, with leading '#' */
    public function getHexString(): string
    {
        return "#$this->color";
    }

    /** will json_encode in HEX format */
    public function jsonSerialize(): string
    {
        return $this->getHexString();
    }

    /** default toString is HEX format */
    public function __toString(): string
    {
        return $this->getHexString();
    }

    /** get the lightness value of the color */
    public function getLightness(): int
    {
        return $this->lightness;
    }
}
