<?php

namespace JJWare\Utils\TailCall;

class Ret extends TailCall
{
    private $t;

    public function __construct($t)
    {
        $this->t = $t;
    }

    public function resume(): TailCall
    {
        throw new \BadMethodCallException("Ret has no resume");
    }

    public function eval()
    {
        return $this->t;
    }

    public function isSuspended(): bool
    {
        return false;
    }
}