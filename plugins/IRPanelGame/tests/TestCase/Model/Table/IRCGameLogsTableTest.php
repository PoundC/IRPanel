<?php
namespace IRPanelGame\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use IRPanelGame\Model\Table\IRCGameLogsTable;

/**
 * IRPanelGame\Model\Table\IRCGameLogsTable Test Case
 */
class IRCGameLogsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \IRPanelGame\Model\Table\IRCGameLogsTable
     */
    public $IRCGameLogs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.IRPanelGame.IRCGameLogs',
        'plugin.IRPanelGame.IRCGamePlayers',
        'plugin.IRPanelGame.IRCFeatureTexts',
        'plugin.IRPanelGame.IRCGameBets'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('IRCGameLogs') ? [] : ['className' => IRCGameLogsTable::class];
        $this->IRCGameLogs = TableRegistry::getTableLocator()->get('IRCGameLogs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->IRCGameLogs);

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
