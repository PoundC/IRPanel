<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StatsConfigTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StatsConfigTable Test Case
 */
class StatsConfigTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\StatsConfigTable
     */
    public $StatsConfig;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.stats_config',
        'app.stats_basics',
        'app.stats_values'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('StatsConfig') ? [] : ['className' => StatsConfigTable::class];
        $this->StatsConfig = TableRegistry::get('StatsConfig', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->StatsConfig);

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
