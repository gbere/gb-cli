<?php

namespace App\Util;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class Os
{
    const UNKNOWN = 'unknown';
    const LINUX = 'linux';
    const OSX = 'osx';

    private $os;
    private $name;
    private $release;
    private $relMajor;
    private $relMinor;
    private $relPatch;

    public function __construct()
    {
        $process = new Process([
            'uname', '-s',
        ]);
        $process->run();
        if (false === $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        $this->name = trim($process->getOutput());

        $process = new Process([
            'uname', '-r',
        ]);
        $process->run();
        if (false === $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        $this->release = trim($process->getOutput());

        switch ($this->name) {
            case 'Darwin':
                $this->os = self::OSX;
                break;
            case 'Linux':
                $this->os = self::LINUX;
                break;
            default:
                $this->os = self::OSX;
        }

        $arrRelease = explode('.', $this->release);
        $this->relMajor = isset($arrRelease[0]) ? $arrRelease[0] : '';
        $this->relMinor = isset($arrRelease[1]) ? $arrRelease[1] : '';
        $this->relPatch = isset($arrRelease[2]) ? $arrRelease[2] : '';
    }

    public function getOs(): string
    {
        return $this->os;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRelease(): string
    {
        return $this->release;
    }

    public function getRelMayor(): string
    {
        return $this->relMajor;
    }

    public function getRelMinor(): string
    {
        return $this->relMinor;
    }

    public function getRelPatch(): string
    {
        return $this->relPatch;
    }
}
