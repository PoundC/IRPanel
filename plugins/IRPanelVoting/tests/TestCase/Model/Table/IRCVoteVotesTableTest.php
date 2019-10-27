<?php
namespace IRPanelVoting\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use IRPanelVoting\Model\Table\IRCVoteVotesTable;

/**
 * IRPanelVoting\Model\Table\IRCVoteVotesTable Test Case
 */
class IRCVoteVotesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \IRPanelVoting\Model\Table\IRCVoteVotesTable
     */
    public $IRCVoteVotes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.IRPanelVoting.IRCVoteVotes',
        'plugin.IRPanelVoting.IRCVoteProposals',
        'plugin.IRPanelVoting.IRCUserRegistrations'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('IRCVoteVotes') ? [] : ['className' => IRCVoteVotesTable::class];
        $this->IRCVoteVotes = TableRegistry::getTableLocator()->get('IRCVoteVotes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->IRCVoteVotes);

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
