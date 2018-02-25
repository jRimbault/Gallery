<?php

namespace Health;


Class Diagnostic implements \JsonSerializable
{
    private $comments;
    private $methods;
    private $list;
    /**
     * Make a diagnostics of the class
     * @param string $class name of the class to diagnose
     */
    public function __construct(string $class)
    {
        $this->class = $class;
        $this->comments = [];
        $this->methods = [];
        $this->list = [];
        $this->initDocumenation()->analyze();
    }

    /**
     * Gets the docs of a class
     * @param string $class name of the class
     */
    private function initDocumenation()
    {
        $reflector = new \ReflectionClass($this->class);
        foreach ($reflector->getMethods() as $method) {
            $this->comments[$method->name] = $reflector
                                    ->getMethod($method->name)
                                    ->getDocComment();
        }
        $this->methods = array_keys($this->comments);
        return $this;
    }

    /**
     * Counts and stores the undocumented methods
     */
    private function analyze()
    {
        foreach ($this->methods as $method) {
            if (empty($this->comments[$method])) {
                $this->list[] = $method;
            }
        }
        return $this;
    }

    /**
     * Returns an array containing a diagnosis of the class
     */
    public function report(): array
    {
        return [
            'class' => $this->class,
            'count' => [
                'all' => $this->getTotalMethods(),
                'undocumented' => $this->getCountOfUndocumentedMethods(),
            ],
            'methods' => [
                'all' => $this->methods,
                'undocumented' => $this->getListOfUndocumentedMethods(),
            ],
            'score' => $this->getScore()
        ];
    }

    /** Get the total number of methods in the class */
    public function getTotalMethods(): int
    {
        return count($this->methods);
    }

    /** Get the number of undocumented methods in the class */
    public function getCountOfUndocumentedMethods(): int
    {
        return count($this->list);
    }

    /** Get the list of undocumented methods */
    public function getListOfUndocumentedMethods(): array
    {
        return $this->list;
    }

    /**
     * Gives a health score between 0 and 1
     */
    public function getScore(): float
    {
        return ((float) $this->getTotalMethods() -
            (float) $this->getCountOfUndocumentedMethods()) /
            (float) $this->getTotalMethods();
    }

    /** Returns the diagnosed class */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * Return JSON string
     */
    public function __toString(): string
    {
        return json_encode(
            $this->jsonSerialize(),
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
    }

    /** Is the default toString */
    public function jsonSerialize(): array
    {
        return $this->report();
    }
}
