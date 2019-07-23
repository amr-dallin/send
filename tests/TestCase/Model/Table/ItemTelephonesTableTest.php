<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ItemTelephonesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ItemTelephonesTable Test Case
 */
class ItemTelephonesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ItemTelephonesTable
     */
    public $ItemTelephones;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ItemTelephones',
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
        $config = TableRegistry::getTableLocator()->exists('ItemTelephones') ? [] : ['className' => ItemTelephonesTable::class];
        $this->ItemTelephones = TableRegistry::getTableLocator()->get('ItemTelephones', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ItemTelephones);

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
