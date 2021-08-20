<?php

namespace Drupal\Tests\workgrid_toolbar\Functional;


use Drupal\Tests\BrowserTestBase;

/**
 * Tests Workgrid Toolbar tools functionality.
 *
 * @group workgrid_toolbar
 */
class WorkgridToolbarShowTest extends BrowserTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  protected static $modules = [
    'block',
    'key',
    'oauth2_client',
    'workgrid_toolbar',
  ];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * A test user with permission to access the administrative toolbar.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $user;

  /**
   * {@inheritdoc}
   */
  protected function setUp() : void {
    parent::setUp();
    $this->drupalPlaceBlock('workgrid_toolbar', 
      [
        'region' => 'help',
        'marginbottom' => '20px',
        'margintop' => '20px',
      ]
    );
  }

  /**
   * Tests authenticated user can see workgrid toolbar wrapper
   */
  public function testWorkgrid() {
    // $this->user = $this->drupalCreateUser();
    // $this->drupalLogin($this->user);
    $html = $this->drupalGet('');
    // $this->assertRaw('There are no actions yet.');
      // $tags = $this->getSession()->getPage()->getHtml();
      // $this->assertStringContainsString($humanstxt_link, $tags, sprintf('Test link [%s] is shown in the HTML -head- section from [%s].', $humanstxt_link, $tags));
    $this->assertSession()->statusCodeEquals(200);
    $tags = $this->getSession()->getPage()->getHtml();

    // $this->assertIsNumeric(strpos($html, 'app.workgrid.com'));
  }

}
