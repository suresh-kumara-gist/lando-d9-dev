<?php

namespace Drupal\Tests\workgrid_toolbar\Kernel;

// use Drupal\Core\Mail\Plugin\Mail\TestMailCollector;
// use Drupal\devel\Plugin\Mail\DevelMailLog;
use Drupal\KernelTests\KernelTestBase;
use Drupal\Core\DependencyInjection\ContainerBuilder;

use Drupal\workgrid_toolbar\Controller\WorkgridToolbarController;

/**
 * Tests sending mails with debug interface.
 *
 * @group devel
 */
class WorkgridToolbarTest extends KernelTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  protected static $modules = [
    'key',
    'oauth2_client',
    'workgrid_toolbar',
  ];

  /**
   * Container builder.
   *
   * This should be used sparingly by test cases to add to the container as
   * necessary for tests.
   *
   * @var \Drupal\key\KeyRepository
   */  
  private $keyrepository;

  /**
   * Config factory builder.
   *
   * This should be used sparingly by test cases to add to the container as
   * necessary for tests.
   *
   * @var Drupal\Core\Config\ConfigFactory
   */
  private $config_factory;

  /**
   * ClientInterface builder.
   *
   * This should be used sparingly by test cases to add to the ClientInterface as
   * necessary for tests.
   *
   * @var GuzzleHttp\ClientInterface
   */
  private $http_client;

  /**
   *
   * This should be used sparingly by test cases to add to the as
   * necessary for tests.
   *
   * @var Drupal\workgrid_toolbar\Controller\WorkgridToolbarController
   */
  private $workgrid_toolbar;

  /**
   * {@inheritdoc}
   */
  protected function setUp() : void {
    parent::setUp();

    $this->installConfig([
      'key',
      'oauth2_client',
      'workgrid_toolbar',      
    ]);

    $config_map = [
      'workgrid_toolbar_settings' => [
        'workgrid_credentials' => 'test',
        'tokenExpiration' => 3600,
        'spaceId' => 'test',
        'companyCode' => 'test',
      ],
    ];

    // Get a stub for the config.factory service.
    $this->config_factory = \Drupal::service('config.factory');
    $container = new ContainerBuilder();
    \Drupal::setContainer($container);
    $container->set('config.factory', $this->config_factory);
    $this->keyrepository = \Drupal::service('key.repository');
    $this->http_client = \Drupal::service('http_client');
    $container->set('key.repository', $this->keyrepository);
    $container->set('http_client', $this->http_client);
    $this->workgrid_toolbar = WorkgridToolbarController(
    $this->config_factory, $this->keyrepository, $this->http_client);

  }

  public function testWorkgridToolbar() : void {
    $this->workgrid_toolbar->build();    
    // $this->getMockBuilder('\Drupal\workgrid_toolbar\Controller\WorkgridToolbarController')
    //   ->disableOriginalConstructor()
    //   ->setMethods(['build', 'getAuthorization', 'gettoolbarResponse'])
    //   ->getMock();

  }

}
