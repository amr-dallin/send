<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CampaignsItemsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CampaignsItemsTable Test Case
 */
class CampaignsItemsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CampaignsItemsTable
     */
    public $CampaignsItems;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CampaignsItems',
        'app.Campaigns',
        'app.Items'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CampaignsItems') ? [] : ['className' => CampaignsItemsTable::class];
        $this->CampaignsItems = TableRegistry::getTableLocator()->get('CampaignsItems', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CampaignsItems);

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
