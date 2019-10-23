<?php
namespace AdminLTE\Test\TestCase\Model\Table;

use AdminLTE\Model\Table\AdminLTEMenuNotificationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * AdminLTE\Model\Table\AdminLTEMenuNotificationsTable Test Case
 */
class AdminLTEMenuNotificationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \AdminLTE\Model\Table\AdminLTEMenuNotificationsTable
     */
    public $AdminLTEMenuNotifications;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.AdminLTE.AdminLTEMenuNotifications',
        'plugin.AdminLTE.AdminLTEMenuNotificationLogs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('AdminLTEMenuNotifications') ? [] : ['className' => AdminLTEMenuNotificationsTable::class];
        $this->AdminLTEMenuNotifications = TableRegistry::getTableLocator()->get('AdminLTEMenuNotifications', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AdminLTEMenuNotifications);

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
