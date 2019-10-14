<?php

namespace IRPanel\Logger;

use Cake\ORM\TableRegistry;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class IRLogger implements LoggerInterface
{
    public $logLevel;

    public function __construct()
    {
        $this->logLevel = new LogLevel();
    }

    public function emergency($message, array $context = array())
    {
        $this->logit($this->logLevel::EMERGENCY, $message, $context);
    }

    public function alert($message, array $context = array())
    {
        $this->logit($this->logLevel::ALERT, $message, $context);
    }

    public function critical($message, array $context = array())
    {
        $this->logit($this->logLevel::CRITICAL, $message, $context);
    }

    public function error($message, array $context = array())
    {
        $this->logit($this->logLevel::ERROR, $message, $context);
    }

    public function warning($message, array $context = array())
    {
        $this->logit($this->logLevel::WARNING, $message, $context);
    }

    public function notice($message, array $context = array())
    {
        $this->logit($this->logLevel::NOTICE, $message, $context);
    }

    public function info($message, array $context = array())
    {
        $this->logit($this->logLevel::INFO, $message, $context);
    }

    public function debug($message, array $context = array())
    {
        $this->logit($this->logLevel::DEBUG, $message, $context);
    }

    public function log($level, $message, array $context = array())
    {
        $this->logit($level, $message, $context);
    }

    public function logit($level, $message, array $context = array())
    {
        $loggingTable = TableRegistry::get('IRPanel.IRCLogs');
        $logEntity = $loggingTable->newEntity([

        ]);
        $loggingTable->save($logEntity);
    }
}
