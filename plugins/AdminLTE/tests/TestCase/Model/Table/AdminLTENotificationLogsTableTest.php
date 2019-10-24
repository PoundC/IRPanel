<?php
namespace AdminLTE\Test\TestCase\Model\Table;

use AdminLTE\Model\Table\AdminLTENotificationLogsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * AdminLTE\Model\Table\AdminLTENotificationLogsTable Test Case
 */
class AdminLTENotificationLogsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \AdminLTE\Model\Table\AdminLTENotificationLogsTable
     */
    public $AdminLTENotificationLogs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.AdminLTE.AdminLTENotificationLogs',
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
        $config = TableRegistry::getTableLocator()->exists('AdminLTENotificationLogs') ? [] : ['className' => AdminLTENotificationLogsTable::class];
        $this->AdminLTENotificationLogs = TableRegistry::getTableLocator()->get('AdminLTENotificationLogs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AdminLTENotificationLogs);

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
