<?php
namespace IRPanelGame\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use IRPanelGame\Model\Table\IRCGamePlayersTable;

/**
 * IRPanelGame\Model\Table\IRCGamePlayersTable Test Case
 */
class IRCGamePlayersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \IRPanelGame\Model\Table\IRCGamePlayersTable
     */
    public $IRCGamePlayers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.IRPanelGame.IRCGamePlayers',
        'plugin.IRPanelGame.IRCUserRegistrations',
        'plugin.IRPanelGame.IRCGameBets',
        'plugin.IRPanelGame.IRCGameFeatureTexts',
        'plugin.IRPanelGame.IRCGameLogs',
        'plugin.IRPanelGame.IRCGameLottoWins',
        'plugin.IRPanelGame.IRCGamePlayerFeatures'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('IRCGamePlayers') ? [] : ['className' => IRCGamePlayersTable::class];
        $this->IRCGamePlayers = TableRegistry::getTableLocator()->get('IRCGamePlayers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->IRCGamePlayers);

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
