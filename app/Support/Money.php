<?php

namespace App\Support;

class Money
{
    /** Formats an amount in pence, e.g. 1999 => "£19.99". */
    public static function format(int $pence): string
    {
        return '£'.number_format($pence / 100, 2);
    }
}
