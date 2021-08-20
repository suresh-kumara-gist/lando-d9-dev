<?php

namespace Drupal\Tests\workgrid_toolbar_oauth\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Tests Workgrid Toolbar tools functionality.
 *
 * @group workgrid_toolbar_oauth
 */
class WorkgridToolbarOauthVisibilityTest extends BrowserTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  protected static $modules = [
    'block',
    'workgrid_toolbar_oauth',
    'key',
    'oauth2_client',
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
    $this->drupalPlaceBlock(
      'workgrid_toolbar_oauth',
      [
        'region' => 'content',
        'marginbottom' => '20px',
        'margintop' => '20px',
      ]
    );
  }

  /**
   * Tests authenticated user can see workgrid toolbar wrapper.
   */
  public function testWorkgridAuthenticatedUser() {
    $this->user = $this->drupalCreateUser();
    $this->drupalLogin($this->user);
    $this->drupalGet('');
    $this->assertSession()->statusCodeEquals(200);
    $html = $this->getSession()->getPage()->getHtml();
    $this->assertIsInt(strpos($html, 'app.workgrid.com'));
  }

  /**
   * Tests anonymous user cann't see workgrid toolbar wrapper.
   */
  public function testWorkgridAnonymousUser() {
    $this->drupalGet('');
    $this->assertSession()->statusCodeEquals(200);
    $html = $this->getSession()->getPage()->getHtml();
    $this->assertFalse(strpos($html, 'app.workgrid.com'));
  }

}
