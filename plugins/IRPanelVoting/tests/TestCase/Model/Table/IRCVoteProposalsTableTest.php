<?php
namespace IRPanelVoting\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use IRPanelVoting\Model\Table\IRCVoteProposalsTable;

/**
 * IRPanelVoting\Model\Table\IRCVoteProposalsTable Test Case
 */
class IRCVoteProposalsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \IRPanelVoting\Model\Table\IRCVoteProposalsTable
     */
    public $IRCVoteProposals;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.IRPanelVoting.IRCVoteProposals',
        'plugin.IRPanelVoting.IRCUserRegistrations',
        'plugin.IRPanelVoting.IRCVoteVotes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('IRCVoteProposals') ? [] : ['className' => IRCVoteProposalsTable::class];
        $this->IRCVoteProposals = TableRegistry::getTableLocator()->get('IRCVoteProposals', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->IRCVoteProposals);

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
