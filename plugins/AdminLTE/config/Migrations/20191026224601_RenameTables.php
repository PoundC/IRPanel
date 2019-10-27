<?php
use Migrations\AbstractMigration;

class RenameTables extends AbstractMigration
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
        $tabllChatChatrooms = $this->table('chat_chatrooms');
        $tabllChatChatrooms->rename('admin_l_t_e_chat_chatrooms');
        $tabllChatChatrooms->update();

        $tableChatChats = $this->table('chat_chats');
        $tableChatChats->rename('admin_l_t_e_chat_chats');
        $tableChatChats->update();

        $tableChatHelpTabs = $this->table('chat_helptabs');
        $tableChatHelpTabs->rename('admin_l_t_e_chat_helptabs');
        $tableChatHelpTabs->update();

        $tableChatOpenchats = $this->table('chat_openchats');
        $tableChatOpenchats->rename('admin_l_t_e_chat_openchats');
        $tableChatOpenchats->update();

        $tableCronjobsCrons = $this->table('cronjobs_crons');
        $tableCronjobsCrons->rename('admin_l_t_e_cronjobs_crons');
        $tableCronjobsCrons->update();

        $tableCronjobsLogs = $this->table('cronjobs_logs');
        $tableCronjobsLogs->rename('admin_l_t_e_cronjobs_logs');
        $tableCronjobsLogs->update();

        $tableFaqAnswers = $this->table('faq_answers');
        $tableFaqAnswers->rename('admin_l_t_e_faq_answers');
        $tableFaqAnswers->update();

        $tableFaqAnswerTags = $this->table('faq_answer_tags');
        $tableFaqAnswerTags->rename('admin_l_t_e_faq_answer_tags');
        $tableFaqAnswerTags->update();

        $tableFaqQuestions = $this->table('faq_questions');
        $tableFaqQuestions->rename('admin_l_t_e_faq_questions');
        $tableFaqQuestions->update();

        $tableFaqTags = $this->table('faq_tags');
        $tableFaqTags->rename('admin_l_t_e_faq_tags');
        $tableFaqTags->update();

        $tableFaqTopics = $this->table('faq_topics');
        $tableFaqTopics->rename('admin_l_t_e_faq_topics');
        $tableFaqTopics->update();

        $tableMessages = $this->table('messages');
        $tableMessages->rename('admin_l_t_e_messages');
        $tableMessages->update();

        $tableMessaging = $this->table('messaging');
        $tableMessaging->rename('admin_l_t_e_messaging');
        $tableMessaging->update();

        $tableStatsConfigs = $this->table('stats_configs');
        $tableStatsConfigs->rename('admin_l_t_e_stats_config');
        $tableStatsConfigs->update();

        $tableStatsValues = $this->table('stats_values');
        $tableStatsValues->rename('admin_l_t_e_stats_values');
        $tableStatsValues->update();

        $tableUserSubscriptionHistory = $this->table('users_subscriptions_history');
        $tableUserSubscriptionHistory->rename('admin_l_t_e_users_subscriptions_history');
        $tableUserSubscriptionHistory->update();

        $tableUserSubscription = $this->table('users_subscriptions');
        $tableUserSubscription->rename('admin_l_t_e_users_subscriptions');
        $tableUserSubscription->update();

        $tableUsers = $this->table('users');
        $tableUsers->rename('admin_l_t_e_users');
        $tableUsers->update();

        $tableNotifications = $this->table('notifications');
        $tableNotifications->rename('admin_l_t_e_notifications');
        $tableNotifications->update();

        $tableRecipients = $this->table('recipients');
        $tableRecipients->rename('admin_l_t_e_recipients');
        $tableRecipients->update();

        $tableSocialAccounts = $this->table('social_accounts');
        $tableSocialAccounts->rename('admin_l_t_e_social_accounts');
        $tableSocialAccounts->update();

    }
}
