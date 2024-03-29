<?php
namespace IRPanelLinks\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use IRPanelLinks\Model\Table\IRCLinksTable;

/**
 * IRPanelLinks\Model\Table\IRCLinksTable Test Case
 */
class IRCLinksTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \IRPanelLinks\Model\Table\IRCLinksTable
     */
    public $IRCLinks;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.IRPanelLinks.IRCLinks',
        'plugin.IRPanelLinks.IRCUsers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('IRCLinks') ? [] : ['className' => IRCLinksTable::class];
        $this->IRCLinks = TableRegistry::getTableLocator()->get('IRCLinks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->IRCLinks);

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
