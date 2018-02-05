<?php

namespace Gallery\Utils;


class Color
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
        $this->toHex();
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
    private function toHSL()
    {
        $rgb = $this->toRGB();
        $r = 0xFF & ($rgb >> 0x10);
        $g = 0xFF & ($rgb >> 0x8);
        $b = 0xFF & $rgb;

        $r = ( (float) $r ) / 255.0;
        $g = ( (float) $g ) / 255.0;
        $b = ( (float) $b ) / 255.0;

        $maxColor = max([$r, $g, $b]);
        $minColor = min([$r, $g, $b]);

        $lightness = ($maxColor + $minColor) / 2.0;

        if ($maxColor == $minColor) {
            $saturation = 0;
            $hue = 0;
        } else {
            if ($lightness < .5) {
                $saturation = ($maxColor - $minColor) / ($maxColor + $minColor);
            } else {
                $saturation = ($maxColor - $minColor) / (2.0 - $maxColor + $minColor);
            }
            switch ($maxColor) {
                case $r:
                    $hue = ($g - $b) / ($maxColor - $minColor);
                    break;
                case $g;
                    $hue = 2.0 + ($b - $r) / ($maxColor - $minColor);
                    break;
                case $b;
                    $hue = 4.0 + ($r - $g) / ($maxColor - $minColor);
                    break;
            }
            $hue /= 6.0;
        }

        $this->hue = (int) round(255.0 * $hue);
        $this->saturation = (int) round(255.0 * $saturation);
        $this->lightness = (int) round(255.0 * $lightness);
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

    public function __toString(): string
    {
        return "#$this->color";
    }
}
