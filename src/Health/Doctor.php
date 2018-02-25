<?php

namespace Health;

use Health\Diagnostic;


class Doctor implements \JsonSerializable
{
    private $classes;

    /**
     * The Doctor is used to run multiple diagnosis and get full
     * reports about multiple classes
     */
    public function __construct()
    {
        $this->classes = [];
    }

    /**
     * Add a class to the Doctor workbench
     */
    public function add(string $class): self
    {
        $this->classes[] = new Diagnostic($class);
        return $this;
    }

    /**
     * Get the Doctor's global opinion about his current workbench
     * From 0 to 1
     */
    public function getScore(): float
    {
        $score = 0;
        foreach ($this->classes as $class) {
            $score += $class->getScore();
        }
        return $score / count($this->classes);
    }

    /**
     * Get the Doctor's full report
     */
    public function report(): array
    {
        $report = [];
        foreach ($this->classes as $class) {
            $report[] = $class->report();
        }
        return $report;
    }

    /** Uses the JSON serialize */
    public function __toString(): string
    {
        return json_encode(
            $this->jsonSerialize(),
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
    }

    /**
     * Returns the report in JSON formatted string
     */
    public function jsonSerialize(): array
    {
        return $this->report();
    }

    /**
     * The Doctor will write a human readable report
     */
    public function print(): string
    {
        $text = [];
        foreach ($this->classes as $class) {
            $text[] = 'Class `'.$class->getClass().'`:';
            foreach ($class->getListOfUndocumentedMethods() as $method) {
                $text[] = " • `$method` is missing docs";
            }
            $text[] = $class->getCountOfUndocumentedMethods() . ' out of ' .
                $class->getTotalMethods() . ' methods missing docs.';
            $text[] = 'Score: ' . $this->toPercent($class->getScore());
            $text[] = '';
        }
        $text[] = 'Gloabl Score: ' . $this->toPercent($this->getScore());
        $text[] = '';
        return join(PHP_EOL, $text);
    }

    /** does what it says ? */
    private function toPercent(float $f): string
    {
        return round($f * 100) . '%';
    }
}
