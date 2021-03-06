<?php

namespace Drupal\Tests\workgrid_toolbar\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Test behaviors when visiting the action listing page.
 *
 * @group action
 */
class WorkGridListTest extends BrowserTestBase {

  /**
   * Modules to install.
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
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * Tests the behavior when there are no actions to list in the admin page.
   */
  public function testEmptyActionList() {
    $html = $this->drupalGet('');
    $this->assertSession()->statusCodeEquals(200);
    $tags = $this->getSession()->getPage()->getHtml();

    // $this->assertRaw('There are no actions yet.');
    // $tags = $this->getSession()->getPage()->getHtml();
    // $this->assertStringContainsString($humanstxt_link, $tags, sprintf('Test link [%s] is shown in the HTML -head- section from [%s].', $humanstxt_link, $tags));

    // Create a user with permission to view the actions administration pages.
    // $this->drupalLogin($this->drupalCreateUser(['administer actions']));

    // // Ensure the empty text appears on the action list page.
    // /** @var $storage \Drupal\Core\Entity\EntityStorageInterface */
    // $storage = $this->container->get('entity_type.manager')->getStorage('action');
    // $actions = $storage->loadMultiple();
    // $storage->delete($actions);
    // $this->drupalGet('/admin/config/system/actions');
    // $this->assertRaw('There are no actions yet.');

  }

}
