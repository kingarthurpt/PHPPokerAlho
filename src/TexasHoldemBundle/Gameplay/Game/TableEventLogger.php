<?php

namespace TexasHoldemBundle\Gameplay\Game;

use Psr\Log\LoggerInterface;

class TableEventLogger
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function info(string $message)
    {
        $this->logger->info($message);
    }
}
