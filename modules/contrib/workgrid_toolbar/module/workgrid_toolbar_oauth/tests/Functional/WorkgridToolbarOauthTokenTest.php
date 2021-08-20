<?php

namespace Drupal\Tests\workgrid_toolbar_oauth\Functional;

use Drupal\Tests\BrowserTestBase;
use Drupal\key\Entity\Key;

/**
 * Tests Workgrid Toolbar Oauth tools functionality.
 *
 * @group workgrid_toolbar_Oauth
 */
class WorkgridToolbarOauthTokenTest extends BrowserTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  protected static $modules = [
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
    \Drupal::service('config.factory')
      ->getEditable('workgrid_toolbar_oauth.settings')
      ->set('workgridCredentials', "test")
      ->set('tokenExpiration', 3600)
      ->set('companyCode', "lkjdskdfjg;lksf")
      ->set('spaceId', "afkjahfkljahd")
      ->set('tokenUrl', "khadahfajdflkjad")
      ->save();

    $key = Key::create([
      'id' => 'test',
      'description' => 'test',
      'pluginTypes' => [
        'key_type',
        'key_provider',
        'key_input',
      ],
      'key_type' => 'oauth2_client',
      'key_provider' => 'file',
      'key_input' => "none",
      'key_provider_settings' => [
        "file_location" => "foobar.key",
        "strip_line_breaks" => "",
      ],
    ]);
    $key->save();

  }

  /**
   * Tests.
   */
  public function testWorkgridTokenResponse() : void {
    $assert = $this->assertSession();
    $this->drupalGet('/workgrid-toolbar-oauth/get-toolbar-token');
    $assert->statusCodeEquals(403);
    $this->drupalLogin(
      $this->drupalCreateUser([
        'access content',
      ])
    );
    $this->drupalGet('/workgrid-toolbar-oauth/get-toolbar-token');
    $assert->statusCodeEquals(200);
    $this->assertSession()->responseContains('Client Id and Client Secret is not set');
  }

}
