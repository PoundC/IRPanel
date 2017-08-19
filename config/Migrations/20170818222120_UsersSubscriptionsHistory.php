<?php
use Migrations\AbstractMigration;

class UsersSubscriptionsHistory extends AbstractMigration
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
        $table = $this->table('users_subscriptions_history');
        $table->addColumn('subscription_id', 'string', [
            'default' => null,
            'limit' => 13,
            'null' => false,
        ]);
        $table->addColumn('subscription_status', 'string', [
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
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'limit' => 13,
            'null' => false,
        ]);
        $table->create();
    }
}
