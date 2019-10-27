<?php
namespace AdminLTE\Test\TestCase\Model\Table;

use AdminLTE\Model\Table\MenuNotificationLogsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * AdminLTE\Model\Table\AdminLTEMenuNotificationLogsTable Test Case
 */
class AdminLTEMenuNotificationLogsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \AdminLTE\Model\Table\MenuNotificationLogsTable
     */
    public $AdminLTEMenuNotificationLogs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.AdminLTE.AdminLTEMenuNotificationLogs',
        'plugin.AdminLTE.AdminLTEMenuNotifications',
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
        $config = TableRegistry::getTableLocator()->exists('AdminLTEMenuNotificationLogs') ? [] : ['className' => MenuNotificationLogsTable::class];
        $this->AdminLTEMenuNotificationLogs = TableRegistry::getTableLocator()->get('AdminLTEMenuNotificationLogs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AdminLTEMenuNotificationLogs);

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
