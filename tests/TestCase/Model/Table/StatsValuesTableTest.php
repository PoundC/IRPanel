<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StatsValuesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StatsValuesTable Test Case
 */
class StatsValuesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\StatsValuesTable
     */
    public $StatsValues;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.stats_values',
        'app.stats_configs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('StatsValues') ? [] : ['className' => StatsValuesTable::class];
        $this->StatsValues = TableRegistry::get('StatsValues', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->StatsValues);

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
