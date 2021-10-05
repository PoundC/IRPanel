<?php

namespace AdminLTE\Utility;

use AdminLTE\Utility\Users;
use AdminLTE\Utility\Dates;
use Cake\ORM\TableRegistry;

class Messaging
{
    public static $userCount;
    public static $vendorCount;

    public static function getTotalCount($user_id)
    {
        if(!isset(self::$userCount)) {

            $userCount = self::getUserCount($user_id);
        }
        else {

            $userCount = self::$userCount;
        }

        return $userCount;
    }

    public static function getNavMessages($user_id)
    {
        $messagesArray = array();
        $messagesTable = TableRegistry::get('AdminLTE.Messaging');

        $messages = $messagesTable->find('all', ['contain' => ['Users', 'Recipients']])->where([
            'recipient_read' => 0,
            'to_user_id' => $user_id,
            'recipient_deleted' => 0
        ])->orderDesc('modified')->limit(3);

        foreach($messages as $message)
        {
            $user = Users::getOtherUserByID($message->get('user_id'));

            $messageArray['username'] = $user->get('first_name') . ' ' . $user->get('last_name');
            $messageArray['avatar'] = $user->get('avatar');
            $messageArray['subject'] = $message->get('subject');
            $messageArray['lapsed'] = Dates::getLapsedTime($message->get('created'));
            $messageArray['id'] = $message->get('id');

            $messagesArray[] = $messageArray;
        }

        return $messagesArray;
    }

    public static function getUserCount($user_id)
    {
        if(isset(self::$userCount)) {

            return self::$userCount;
        }

        $messagesTable = TableRegistry::get('AdminLTE.Messaging');

        $userCount = $messagesTable->find('all')
//            ->where([
//            'messaging.read' => 0,
//            'messaging.user_id' => $user_id,
//            'messaging.user_deleted' => 0
//        ])
            ->where([
            'recipient_read' => 0,
            'recipient_deleted' => 0,
            'to_user_id' => $user_id
                ])->count();

        self::$userCount = $userCount;

        return $userCount;
    }
}
