<?php
namespace IRPanelGame\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use IRPanelGame\Model\Table\IRCGamePlayerFeaturesTable;

/**
 * IRPanelGame\Model\Table\IRCGamePlayerFeaturesTable Test Case
 */
class IRCGamePlayerFeaturesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \IRPanelGame\Model\Table\IRCGamePlayerFeaturesTable
     */
    public $IRCGamePlayerFeatures;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.IRPanelGame.IRCGamePlayerFeatures',
        'plugin.IRPanelGame.IRCGamePlayers',
        'plugin.IRPanelGame.IRCGameFeatures'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('IRCGamePlayerFeatures') ? [] : ['className' => IRCGamePlayerFeaturesTable::class];
        $this->IRCGamePlayerFeatures = TableRegistry::getTableLocator()->get('IRCGamePlayerFeatures', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->IRCGamePlayerFeatures);

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
