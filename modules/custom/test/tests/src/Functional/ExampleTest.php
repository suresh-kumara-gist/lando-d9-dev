<?php

namespace Drupal\Tests\test\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Test description.
 *
 * @group test
 */
class ExampleTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stable';

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'test',
    'key',
    'block',
    'oauth2_client',
    'workgrid_toolbar',
  ];

  /**
   * {@inheritdoc}
   */
  protected function setUp() : void {
    parent::setUp();
    // Set up the test here.
  }

  /**
   * Test callback.
   */
  public function testSomething() : void {
    $admin_user = $this->drupalCreateUser(['access administration pages']);
    $this->drupalLogin($admin_user);
    $this->drupalGet('admin');
    $page = $this->getSession()->getPage();
    print_r($page->getHtml());
//    $this->htmlOutput($page->getHtml());
    // $this->assertSession()->elementExists('xpath', '//h1[text() = "Administration"]');
   //  $this->createScreenshot(\Drupal::root() . '/sites/default/files/simpletest/screen.png');
  //  $this->assertSame(1,1);
  }

}
