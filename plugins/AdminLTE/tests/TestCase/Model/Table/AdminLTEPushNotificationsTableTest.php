<?php
namespace AdminLTE\Test\TestCase\Model\Table;

use AdminLTE\Model\Table\AdminLTEPushNotificationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * AdminLTE\Model\Table\AdminLTEPushNotificationsTable Test Case
 */
class AdminLTEPushNotificationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \AdminLTE\Model\Table\AdminLTEPushNotificationsTable
     */
    public $AdminLTEPushNotifications;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.AdminLTE.AdminLTEPushNotifications',
        'plugin.AdminLTE.Notifications',
        'plugin.AdminLTE.Users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('AdminLTEPushNotifications') ? [] : ['className' => AdminLTEPushNotificationsTable::class];
        $this->AdminLTEPushNotifications = TableRegistry::getTableLocator()->get('AdminLTEPushNotifications', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AdminLTEPushNotifications);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
