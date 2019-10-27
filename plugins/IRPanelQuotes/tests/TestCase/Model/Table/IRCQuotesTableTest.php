<?php
namespace IRPanelQuotes\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use IRPanelQuotes\Model\Table\IRCQuotesTable;

/**
 * IRPanelQuotes\Model\Table\IRCQuotesTable Test Case
 */
class IRCQuotesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \IRPanelQuotes\Model\Table\IRCQuotesTable
     */
    public $IRCQuotes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.IRPanelQuotes.IRCQuotes',
        'plugin.IRPanelQuotes.IRCUsers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('IRCQuotes') ? [] : ['className' => IRCQuotesTable::class];
        $this->IRCQuotes = TableRegistry::getTableLocator()->get('IRCQuotes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->IRCQuotes);

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
