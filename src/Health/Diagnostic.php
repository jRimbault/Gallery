<?php

namespace Health;

/**
 * Doctor Rigor
 */
Class Diagnostic
{
    private $class;
    private $docs;
    private $methodsComment;
    private $report;
    private $score;

    /**
     * Instantiate a rigorous doctor ;)
     * @param string $class name of the class
     */
    public function __construct(string $class)
    {
        $this->class = $class;
        $this->initDocumenation();
    }

    /** Return a the report made by `analyze()` */
    public function getReport(): array
    {
        return $this->report ?? $this->analyze();
    }

    /** Return a the score calculated by `score()` */
    public function getScore(): float
    {
        return $this->score ?? $this->score();
    }

    /**
     * Gets the docs of a class
     * @param string $class name of the class
     */
    private function initDocumenation()
    {
        $reflector = new \ReflectionClass($this->class);
        foreach ($reflector->getMethods() as $m) {
            $this->methodsComment[$m->name] = $reflector
                                    ->getMethod($m->name)
                                    ->getDocComment();
        }
    }

    /**
     * Generates a human readable report of the class
     */
    private function analyze(): array
    {
        $this->report[] = "Class `$this->class`:";
        $undocumented = 0;
        foreach ($this->methodsComment as $key => $value) {
            if (empty($value)) {
                $undocumented += 1;
                $this->report[] = " • `$key` is missing docs";
            }
        }
        $methods = $this->countMethods();
        $this->report[] = "$undocumented out of $methods methods missing docs.";
        return $this->report;
    }

    /** makes the number of methods accessible from exterior */
    public function countMethods()
    {
        return count($this->methodsComment);
    }

    /**
     * Gives a health score between 0 and 1
     */
    private function score(): float
    {
        $undocumented = 0;
        foreach ($this->methodsComment as $key => $value) {
            if (empty($value)) {
                $undocumented += 1;
            }
        }
        $methods = $this->countMethods();
        return $this->score = ((float)$methods - (float)$undocumented) / (float)$methods;
    }
}

