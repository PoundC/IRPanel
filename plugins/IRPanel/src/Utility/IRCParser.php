<?php

namespace IRPanel\Utility;

class IRCParser
{
    public static function isIRCMessage($messageLine) {

        $split = explode(' ', $messageLine);

        if(count($split) > 1) {
            if (strpos($split[1], '!') > -1 && strpos($split[3], '#') > -1) {

                return true;
            } else {

                return false;
            }
        }
    }

    public static function parseIRCText($messageLine) {

        $split = explode(' ', $messageLine);

        return [
            'serverHostname' => self::getServerHostname($split),
            'pound_name' => self::getChannelPoundName($split),
            'nickname' => self::getUserNickName($split),
            'username' => self::getUserUserName($split),
            'hostname' => self::getUserHostName($split),
            'msg_type' => self::getMessageType($split),
            'message' => self::getMessage($messageLine, $split)
        ];
    }

    public static function getServerHostname($split) {

        $first = explode('@', $split[0]);

        return $first[1];
    }

    public static function getChannelPoundName($split) {

        if(strpos($split[3], ':') === 0) {

            $split[3] = substr($split[3], 1);
        }

        return $split[3];
    }

    public static function getUserNickName($split) {

        $split[1] = substr($split[1], 1);

        $second = explode('!', $split[1]);

        return $second[0];
    }

    public static function getUserUserName($split) {

        $third = explode('!', $split[1]);

        $userName = explode('@', $third[1]);
        $userName = $userName[0];

        if(strpos($userName, '~') === 0) {

            $userName = substr($userName, 1);
        }

        return $userName;
    }

    public static function getUserHostName($split) {

        $userHostName = explode('@', $split[1]);
        $userHostName = $userHostName[1];

        return $userHostName;
    }

    public static function getMessageType($split) {

        return $split[2];
    }

    public static function getMessage($messageLine, $split) {

        if(count($split) >= 5) {

            if(strpos($split[4], ':') === 0) {

                $messageStart = strpos($messageLine, $split[4]) + 1;
            }
            else {

                $messageStart = strpos($messageLine, $split[4]);
            }

            $message = substr($messageLine, $messageStart);
        }
        else {

            $message = '';
        }

        return $message;
    }
}
