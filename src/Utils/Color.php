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

    public function __construct(string $string)
    {
        $string = ltrim($string, '#');
        if (!$this->isHexColor($string)) {
            throw new \Exception('String isn\'t an rgb or rrggbb color');
        }
        $this->color = $string;
        $this->toRGB();
        $this->toHSL();
    }

    /**
     * Sanity check before proceeding
     * Could be improved by accepting other format than RRGGBB
     * and supply to the RRGGBB string needed by the other functions
     */
    private function isHexColor(string $string): bool
    {
        if (!ctype_xdigit($string)) return false;
        if (!in_array(strlen($string), [3, 6])) return false;
        return true;
    }

    /** Mainly here because it allows the computation of the HSL values */
    private function toRGB(): int
    {
        if (strlen($this->color) === 3) {
            $this->color = $this->color[0] . $this->color[0]
                    . $this->color[1] . $this->color[1]
                    . $this->color[2] . $this->color[2];
        }
        $this->red = hexdec($this->color[0] . $this->color[1]);
        $this->green = hexdec($this->color[2] . $this->color[3]);
        $this->blue = hexdec($this->color[4] . $this->color[5]);

        return $this->rgb = $this->blue + ($this->green << 0x8) + ($this->red << 0x10);
    }

    /**
     * Computes the HSL (Hue, Saturation, Lightness) of the color
     * I want this to determine if the color is light or dark
     * to change the color of the text accordingly
     */
    private function toHSL(): array
    {
        $rgb = $this->toRGB();
        $r = 0xFF & ($rgb >> 0x10);
        $g = 0xFF & ($rgb >> 0x8);
        $b = 0xFF & $rgb;

        $r = $r / 255;
        $g = $g / 255;
        $b = $b / 255;

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

    public function getRgbString(): string
    {
        return "rgb($this->red, $this->green, $this->blue)";
    }

    public function jsonSerialize()
    {
        return "#$this->color";
    }

    public function __toString(): string
    {
        return "#$this->color";
    }
}
