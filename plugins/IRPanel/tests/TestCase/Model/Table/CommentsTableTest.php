<?php
namespace IRPanel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use IRPanel\Model\Table\CommentsTable;

/**
 * IRPanel\Model\Table\CommentsTable Test Case
 */
class CommentsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \IRPanel\Model\Table\CommentsTable
     */
    public $Comments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.IRPanel.Comments',
        'plugin.IRPanel.IRCUsers',
        'plugin.IRPanel.TableRows'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Comments') ? [] : ['className' => CommentsTable::class];
        $this->Comments = TableRegistry::getTableLocator()->get('Comments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Comments);

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
