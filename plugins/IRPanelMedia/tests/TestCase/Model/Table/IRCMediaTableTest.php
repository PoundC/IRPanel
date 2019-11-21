<?php
namespace IRPanelMedia\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use IRPanelMedia\Model\Table\IRCMediaTable;

/**
 * IRPanelMedia\Model\Table\IRCMediaTable Test Case
 */
class IRCMediaTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \IRPanelMedia\Model\Table\IRCMediaTable
     */
    public $IRCMedia;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.IRPanelMedia.IRCMedia',
        'plugin.IRPanelMedia.IRCUsers',
        'plugin.IRPanelMedia.IRCMediaGalleries'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('IRCMedia') ? [] : ['className' => IRCMediaTable::class];
        $this->IRCMedia = TableRegistry::getTableLocator()->get('IRCMedia', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->IRCMedia);

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
