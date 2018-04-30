<?php

namespace JJWare\Utils\TailCall;

class Sus extends TailCall
{
    private $r;

    public function __construct(callable $f)
    {
        $this->r = $f;
    }

    public function resume(): TailCall
    {
        return call_user_func($this->r);
    }

    public function eval()
    {
        $tailRec = $this;

        while ($tailRec->isSuspended()) {
            $tailRec = $tailRec->resume();
        }
        return $tailRec->eval();
    }

    public function isSuspended(): bool
    {
        return true;
    }
}