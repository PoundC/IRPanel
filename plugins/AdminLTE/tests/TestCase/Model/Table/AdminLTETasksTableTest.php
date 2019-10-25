<?php
namespace AdminLTE\Test\TestCase\Model\Table;

use AdminLTE\Model\Table\AdminLTETasksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * AdminLTE\Model\Table\AdminLTETasksTable Test Case
 */
class AdminLTETasksTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \AdminLTE\Model\Table\AdminLTETasksTable
     */
    public $AdminLTETasks;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.AdminLTE.AdminLTETasks',
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
        $config = TableRegistry::getTableLocator()->exists('AdminLTETasks') ? [] : ['className' => AdminLTETasksTable::class];
        $this->AdminLTETasks = TableRegistry::getTableLocator()->get('AdminLTETasks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AdminLTETasks);

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
