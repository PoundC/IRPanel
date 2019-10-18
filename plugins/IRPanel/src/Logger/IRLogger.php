<?php

namespace IRPanel\Logger;

use Cake\ORM\TableRegistry;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use IRPanel\Utility\Database;
use IRPanel\Utility\IRCParser;

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
        file_put_contents('/tmp/irc', $message . "\n", FILE_APPEND);

        if(IRCParser::isIRCMessage($message) == true) {

            if(count($context) > 0) {

                $context = print_r($context, true);
            }
            else {

                $context = '';
            }

            $parsed = IRCParser::parseIRCText($message);

            $i_r_c_network_id = Database::getNetworkId($parsed['serverHostname']);

            $loggingTable = TableRegistry::get('IRPanel.IRCLogs');

            $logEntity = $loggingTable->newEntity([
                'i_r_c_network_id' => $i_r_c_network_id,
                'i_r_c_channel_id' => Database::getChannelId(
                    $i_r_c_network_id,
                    $parsed['pound_name']
                ),
                'i_r_c_user_id' => Database::getUserId(
                    $i_r_c_network_id,
                    $parsed['nickname'],
                    $parsed['username'],
                    $parsed['hostname']
                ),
                'msg_type' => $parsed['msg_type'],
                'message' => $parsed['message'],
                'context' => $context,
                'created' => new \DateTime('now')
            ]);

            $loggingTable->save($logEntity);
        }
    }

    function interpolate($message, array $context = array())
    {
        // build a replacement array with braces around the context keys
        $replace = array();
        foreach ($context as $key => $val) {
            // check that the value can be casted to string
            if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                $replace['{' . $key . '}'] = $val;
            }
        }

        // interpolate replacement values into the message and return
        return strtr($message, $replace);
    }
}
