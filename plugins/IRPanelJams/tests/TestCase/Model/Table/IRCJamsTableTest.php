<?php
namespace IRPanelJams\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use IRPanelJams\Model\Table\IRCJamsTable;

/**
 * IRPanelJams\Model\Table\IRCJamsTable Test Case
 */
class IRCJamsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \IRPanelJams\Model\Table\IRCJamsTable
     */
    public $IRCJams;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        $config = TableRegistry::getTableLocator()->exists('IRCJams') ? [] : ['className' => IRCJamsTable::class];
        $this->IRCJams = TableRegistry::getTableLocator()->get('IRCJams', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->IRCJams);

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
