<?php

namespace MagpieLib\Cerberus\Impl;

use Magpie\Cryptos\Algorithms\Hashes\CommonHasher;
use Magpie\General\Sugars\Excepts;
use Magpie\General\Traits\StaticClass;

/**
 * Utility to capture information from stack
 * @internal
 */
class StackCapture
{
    use StaticClass;


    /**
     * Generate a unique ID based on desire class (of given base class) and method
     * @param class-string $baseClassName
     * @return string
     */
    public static function generateId(string $baseClassName) : string
    {
        $traces = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        foreach ($traces as $trace) {
            $traceClass = $trace['class'] ?? null;
            if ($traceClass === null) continue;
            $traceFunction = $trace['function'] ?? null;
            if ($traceFunction === null) continue;

            if (!is_subclass_of($traceClass, $baseClassName)) continue;

            $plaintext = "$traceClass::$traceFunction";

            return Excepts::noThrow(fn () =>
                CommonHasher::sha1()->hashString($plaintext)->asLowerHex()
            , '');
        }

        return '';
    }
}