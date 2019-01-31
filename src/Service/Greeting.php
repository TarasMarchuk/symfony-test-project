<?php
/**
 * Created by PhpStorm.
 * User: taras
 * Date: 09.01.19
 * Time: 0:32
 */

namespace App\Service;


use Psr\Log\LoggerInterface;

class Greeting
{
    private $logger;

    private $message;

    public function __construct(LoggerInterface $logger, string $message)
    {
        $this->logger = $logger;
        $this->message = $message;
    }

    public function greet(string $name): string
    {
        $this->logger->info("Greeted $name");
        return "{$this->message} $name";
    }
}