<?php
namespace IRPanelJams\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use IRPanelJams\Model\Table\IRCJamsQueueTable;

/**
 * IRPanelJams\Model\Table\IRCJamsQueueTable Test Case
 */
class IRCJamsQueueTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \IRPanelJams\Model\Table\IRCJamsQueueTable
     */
    public $IRCJamsQueue;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.IRPanelJams.IRCJamsQueue',
        'plugin.IRPanelJams.IRCJams',
        'plugin.IRPanelJams.IRCUsers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('IRCJamsQueue') ? [] : ['className' => IRCJamsQueueTable::class];
        $this->IRCJamsQueue = TableRegistry::getTableLocator()->get('IRCJamsQueue', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->IRCJamsQueue);

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
