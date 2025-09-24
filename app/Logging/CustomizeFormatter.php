<?php

namespace App\Logging;

use Monolog\Formatter\LineFormatter;
use Monolog\Logger;

class CustomizeFormatter
{
    public function __invoke($logger)
    {
        foreach ($logger->getHandlers() as $handler) {
            // biar langsung 1 baris JSON tanpa prefix
            $handler->setFormatter(new LineFormatter("%message%\n", null, true, true));
        }
    }
}
