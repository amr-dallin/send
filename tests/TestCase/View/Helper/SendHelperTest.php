<?php
namespace App\Test\TestCase\View\Helper;

use App\View\Helper\SendHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\SendHelper Test Case
 */
class SendHelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\View\Helper\SendHelper
     */
    public $Send;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->Send = new SendHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Send);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
