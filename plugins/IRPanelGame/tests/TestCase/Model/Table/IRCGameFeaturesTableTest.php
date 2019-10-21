<?php
namespace IRPanelGame\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use IRPanelGame\Model\Table\IRCGameFeaturesTable;

/**
 * IRPanelGame\Model\Table\IRCGameFeaturesTable Test Case
 */
class IRCGameFeaturesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \IRPanelGame\Model\Table\IRCGameFeaturesTable
     */
    public $IRCGameFeatures;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.IRPanelGame.IRCGameFeatures',
        'plugin.IRPanelGame.IRCGameFeatureTexts',
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
        $config = TableRegistry::getTableLocator()->exists('IRCGameFeatures') ? [] : ['className' => IRCGameFeaturesTable::class];
        $this->IRCGameFeatures = TableRegistry::getTableLocator()->get('IRCGameFeatures', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->IRCGameFeatures);

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
}
