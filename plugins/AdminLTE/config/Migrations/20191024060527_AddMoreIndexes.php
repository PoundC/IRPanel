<?php
use Migrations\AbstractMigration;

class AddMoreIndexes extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $tableMessages = $this->table('messages');
        $tableMessages->addIndex('id');
        $tableMessages->addIndex('user_id');
        $tableMessages->addIndex(['user_id', 'read']);
        $tableMessages->addIndex(['user_id', 'replied']);
        $tableMessages->addIndex(['user_id', 'closed']);
        $tableMessages->addIndex(['user_id', 'read', 'replied']);
        $tableMessages->addIndex(['user_id', 'read', 'closed']);
        $tableMessages->addIndex(['user_id', 'read', 'replied', 'closed']);
        $tableMessages->save();

        $tableRecipients = $this->table('recipients');
        $tableRecipients->addIndex('id');
        $tableRecipients->addIndex(['user_id', 'message_id']);
        $tableRecipients->save();

        $tableChatRooms = $this->table('chat_chatrooms');
        $tableChatRooms->addIndex('id');
        $tableChatRooms->addIndex('name');
        $tableChatRooms->save();

        $tableChatChats = $this->table('chat_chats');
        $tableChatChats->addIndex('id');
        $tableChatChats->addIndex('chatroom_id');
        $tableChatChats->addIndex('user_id');
        $tableChatChats->save();

        $tableChatOpenChats = $this->table('chat_openchats');
        $tableChatOpenChats->addIndex('id');
        $tableChatOpenChats->addIndex('chatroom_id');
        $tableChatOpenChats->addIndex('user_id');
        $tableChatOpenChats->addIndex('open');
        $tableChatOpenChats->addIndex('active');
        $tableChatOpenChats->addIndex(['chatroom_id', 'user_id']);
        $tableChatOpenChats->addIndex(['user_id', 'open']);
        $tableChatOpenChats->addIndex(['user_id', 'active']);
        $tableChatOpenChats->save();

        $tableChatHelpTabs = $this->table('chat_helptabs');
        $tableChatHelpTabs->addIndex('id');
        $tableChatHelpTabs->addIndex(['chatroom_id']);
        $tableChatHelpTabs->addIndex(['faq_answer_id']);
        $tableChatHelpTabs->save();

        $tableFAQTopics = $this->table('faq_topics');
        $tableFAQTopics->addIndex('id');
        $tableFAQTopics->addIndex('topic');
        $tableFAQTopics->addIndex('slug', ['limit' => 16]);
        $tableFAQTopics->save();

        $tableFAQAnswers = $this->table('faq_answers');
        $tableFAQAnswers->addIndex('id');
        $tableFAQAnswers->addIndex('slug', ['limit' => 16]);
        $tableFAQAnswers->addIndex('faq_topic_id');
        $tableFAQAnswers->save();

        $tableFAQQuestions = $this->table('faq_questions');
        $tableFAQQuestions->addIndex('id');
        $tableFAQQuestions->addIndex('faq_answer_id');
        $tableFAQQuestions->save();

        $tableFAQTags = $this->table('faq_tags');
        $tableFAQTags->addIndex('id');
        $tableFAQTags->addIndex('tag');
        $tableFAQTags->addIndex('slug', ['limit' => 16]);
        $tableFAQTags->save();

        $tableFAQAnswerTags = $this->table('faq_answer_tags');
        $tableFAQAnswerTags->addIndex('id');
        $tableFAQAnswerTags->addIndex('faq_answer_id');
        $tableFAQAnswerTags->addIndex('faq_tag_id');
        $tableFAQAnswerTags->addIndex(['faq_answer_id', 'faq_tag_id']);
        $tableFAQAnswerTags->save();

        $tableCronjobsCrons = $this->table('cronjobs_crons');
        $tableCronjobsCrons->addIndex('id');
        $tableCronjobsCrons->addIndex('schedule');
        $tableCronjobsCrons->addIndex('locked');
        $tableCronjobsCrons->addIndex('lastrun');
        $tableCronjobsCrons->addIndex('active');
        $tableCronjobsCrons->save();

        $tableCronjobsLogs = $this->table('cronjobs_logs');
        $tableCronjobsLogs->addIndex('id');
        $tableCronjobsLogs->addIndex('cronjobs_cron_id');
        $tableCronjobsLogs->save();

        $tableStatsConfigs = $this->table('stats_configs');
        $tableStatsConfigs->addIndex('id');
        $tableStatsConfigs->addIndex('stats_table');
        $tableStatsConfigs->save();

        $tableNotifications = $this->table('notifications');
        $tableNotifications->addIndex('id');
        $tableNotifications->addIndex('user_id');
        $tableNotifications->addIndex('destination');
        $tableNotifications->addIndex(['destination', 'user_id']);
        $tableNotifications->addIndex(['destination', 'role_id']);
        $tableNotifications->save();

        $tableNotificationLogs = $this->table('admin_l_t_e_notification_logs');
        $tableNotificationLogs->addIndex('id');
        $tableNotificationLogs->addIndex('user_id');
        $tableNotificationLogs->save();

        $tableMessaging = $this->table('messaging');
        $tableMessaging->addIndex('id');
        $tableMessaging->addIndex('user_id');
        $tableMessaging->addIndex('to_user_id');
        $tableMessaging->addIndex(['to_user_id', 'recipient_deleted']);
        $tableMessaging->addIndex(['user_id', 'user_deleted']);
        $tableMessaging->addIndex(['user_id', 'id']);
        $tableMessaging->addIndex(['to_user_id', 'id']);
        $tableMessaging->save();

        $tableUsers = $this->table('users');
        $tableUsers->addIndex('id');
        // $tableUsers->addIndex('first_name');
        // $tableUsers->addIndex('last_name');
        $tableUsers->save();

        $tableMenuNotifications = $this->table('admin_l_t_e_menu_notifications');
        $tableMenuNotifications->addIndex('id');
        $tableMenuNotifications->addIndex('menu_group');
        $tableMenuNotifications->addIndex('menu_title');
        $tableMenuNotifications->addIndex('destination');
        $tableMenuNotifications->addIndex(['menu_group', 'menu_title']);
        $tableMenuNotifications->addIndex(['user_id', 'destination']);
        $tableMenuNotifications->addIndex(['role_id', 'destination']);
        $tableMenuNotifications->save();

        $tableTasks = $this->table('admin_l_t_e_tasks');
        $tableTasks->addIndex('id');
        $tableTasks->addIndex('user_id');
        $tableTasks->addIndex('seen');
        $tableTasks->addIndex('completed');
        $tableTasks->addIndex(['user_id', 'seen']);
        $tableTasks->addIndex(['user_id', 'completed']);
        $tableTasks->addIndex(['user_id', 'seen', 'completed']);
        $tableTasks->save();

    }
}
