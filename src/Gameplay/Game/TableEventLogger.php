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
        // $this->logger->emergency($message);
        // $this->logger->alert($message);
        // $this->logger->critical($message);
        // $this->logger->error($message);
        // $this->logger->warning($message);
        // $this->logger->notice($message);
        $this->logger->info($message);
        // $this->logger->debug($message);
    }
}
