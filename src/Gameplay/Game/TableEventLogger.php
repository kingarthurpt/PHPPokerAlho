<?php

namespace PHPPokerAlho\Gameplay\Game;

use Psr\Log\LoggerInterface;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
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
