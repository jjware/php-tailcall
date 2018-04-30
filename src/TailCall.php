<?php

namespace JJWare\Utils\TailCall;

abstract class TailCall
{
    public abstract function resume(): TailCall;
    public abstract function eval();
    public abstract function isSuspended(): bool;

    public static function ret($t): TailCall
    {
        return new Ret($t);
    }

    public static function sus(callable $f): TailCall
    {
        return new Sus($f);
    }
}