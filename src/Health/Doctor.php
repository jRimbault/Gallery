<?php

namespace Health;

use Health\Diagnostic;
use Gallery\Utils\Console;


class Doctor
{
    private $count;
    private $countMethod;
    private $score;
    private $logtext;
    private $classes;

    /**
     * Use the Diagnostic class to run one or several diagnostics
     * and present a human readable report
     */
    public function __construct()
    {
        $this->count = 0;
        $this->countMethod = 0;
        $this->score = 0;
        $this->logtext = [];
        $this->classes = [];
    }

    /**
     * Add a class to the list of class to be diagnosed
     * @param string $class class to diagnose
     */
    public function add(string $class)
    {
        $doc = new Diagnostic($class);
        $this->classes[] = $doc;
        $this->score += $doc->getScore();
        return $this;
    }

    /**
     * Put the doctor to work on the current queue
     * Empties the current queue
     */
    public function runDiagnostic()
    {
        foreach ($this->classes as $class) {
            $this->run($class);
            unset($class);
        }
        return $this;
    }

    /**
     * Get the human readable report for the class
     * @param Diagnostic $class class to diagnose
     */
    private function run(Diagnostic $class)
    {
        $this->log(join(PHP_EOL, $class->getReport()));
        $this->log('Score: ' . round($class->getScore() * 100) . '%');
        $this->log();
        return $this;
    }

    /** alias used for calculating the global percentage score */
    private function globalScore()
    {
        return $this->score / count($this->classes);
    }

    /** Get the global percentage score */
    public function getScore()
    {
        $this->log('Global Score: ' . round(($this->globalScore()) * 100) . '%');
        return $this;
    }

    /** fill the report line by line */
    private function log($message = '')
    {
        $this->logtext[] = $message;
    }

    /**
     * Prints the report in a human readable output format
     * @param string $file destination file, if left null goes to STDOUT
     */
    public function print(string $file = '')
    {
        $text = join(PHP_EOL, $this->logtext);
        if (!empty($file)) {
            Console::message("Report in '".basename($file)."'");
            file_put_contents($file, $text);
        } else {
            Console::message($text);
        }
    }
}
