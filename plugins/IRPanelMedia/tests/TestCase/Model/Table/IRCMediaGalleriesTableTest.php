<?php
namespace IRPanelMedia\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use IRPanelMedia\Model\Table\IRCMediaGalleriesTable;

/**
 * IRPanelMedia\Model\Table\IRCMediaGalleriesTable Test Case
 */
class IRCMediaGalleriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \IRPanelMedia\Model\Table\IRCMediaGalleriesTable
     */
    public $IRCMediaGalleries;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.IRPanelMedia.IRCMediaGalleries',
        'plugin.IRPanelMedia.IRCMedia'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('IRCMediaGalleries') ? [] : ['className' => IRCMediaGalleriesTable::class];
        $this->IRCMediaGalleries = TableRegistry::getTableLocator()->get('IRCMediaGalleries', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->IRCMediaGalleries);

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
