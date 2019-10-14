<?php
use Migrations\AbstractMigration;

class Billing extends AbstractMigration
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
        $table = $this->table('users_subscriptions');
        $table->addColumn('ref_id', 'string', [
            'default' => null,
            'limit' => 20,
            'null' => false,
        ]);
        $table->addColumn('messages', 'text', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('subscription_id', 'string', [
            'default' => null,
            'limit' => 13,
            'null' => false,
        ]);
        $table->addColumn('customer_profile_id', 'string', [
            'default' => null,
            'limit' => 13,
            'null' => false,
        ]);
        $table->addColumn('customer_payment_profile_id', 'string', [
            'default' => null,
            'limit' => 13,
            'null' => false,
        ]);
        $table->addColumn('customer_address_id', 'string', [
            'default' => null,
            'limit' => 13,
            'null' => false,
        ]);
        $table->create();

        $cronJobTable = \Cake\ORM\TableRegistry::get('cronjobs_crons');
        $cronJobsEntity = $cronJobTable->newEntity([
            'schedule' => '0 4 * * *',
            'name'     => 'Billing Subscription Status Retrieval',
            'command'  => 'billing',
            'locked'   => 0,
            'timeout'  => 30,
            'lastrun'  => new \DateTime('now'),
            'active'  => new \DateTime('now'),
            'created'  => new \DateTime('now'),
            'modified'  => new \DateTime('now'),
        ]);
        $cronJobTable->save($cronJobsEntity);
    }
}
