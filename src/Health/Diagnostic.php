<?php

namespace Health;

use Health\Doctor;


class Diagnostic
{
    private $count;
    private $score;
    private $logfile;

    public function __construct(string $file = '')
    {
        $this->count = 0;
        $this->score = 0;
        if (!empty($file)) {
            $this->logfile = $file;
            file_put_contents($this->logfile, '');
        }
    }

    public function run(string $class)
    {
        $doc = new Doctor($class);
        $this->count += 1;
        $this->score += $doc->getScore();
        $this->log(join(PHP_EOL, $doc->getReport()));
        $this->log('Score: ' . round($doc->getScore() * 100) . '%');
        $this->log();
    }

    public function globalScore()
    {
        return $this->score / $this->count;
    }

    public function report()
    {
        $this->log('Global Score: ' . round(($this->globalScore()) * 100) . '%');
    }

    private function log($message = '')
    {
        fwrite(STDOUT, $message . PHP_EOL);
        if (isset($this->logfile)) {
            file_put_contents($this->logfile, $message . PHP_EOL, FILE_APPEND);
        }
    }
}
