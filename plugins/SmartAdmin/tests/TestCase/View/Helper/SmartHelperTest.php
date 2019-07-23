<?php
namespace SmartAdmin\Test\TestCase\View\Helper;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use SmartAdmin\View\Helper\SmartHelper;

/**
 * SmartAdmin\View\Helper\SmartHelper Test Case
 */
class SmartHelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \SmartAdmin\View\Helper\SmartHelper
     */
    public $Smart;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->Smart = new SmartHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Smart);

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
