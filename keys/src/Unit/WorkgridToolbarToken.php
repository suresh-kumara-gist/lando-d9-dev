<?php

namespace Drupal\Tests\workgrid_toolbar\Unit;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Tests\UnitTestCase;
use Drupal\workgrid_toolbar\Controller\WorkgridToolbarController;
// use Drupal\workgrid_toolbar\Controller\WorkgridToolbarController;
// Drupal\Tests\key\Entity\KeyEntityTest

class WorkgridToolbarToken extends UnitTestCase {

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
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = [
    'key',
    'oauth2_client',
    'workgrid_toolbar',
  ];

  public function setUp() : void {
    parent::setUp();

    $config_map = [
      'workgrid_toolbar_settings' => [
        'workgrid_credentials' => 'test',
        'tokenExpiration' => 3600,
        'spaceId' => 'test',
        'companyCode' => 'test',
      ],
    ];

    // Get a stub for the config.factory service.
    $this->config_factory = $this->getConfigFactoryStub($config_map);
    $container = new ContainerBuilder();
    \Drupal::setContainer($container);
    $container->set('config.factory', $this->config_factory);
    $this->keyrepository = \Drupal::service('key.repository');
    $this->http_client = \Drupal::service('http_client');
    $container->set('key.repository', $this->keyrepository);
    $container->set('http_client', $this->http_client);
    $this->workgrid_toolbar = WorkgridToolbarController(
    $this->config_factory, $this->keyrepository, $this->http_client);

    // Set the front page to "node".
    // $this->config_factory = \Drupal::configFactory()
    //   ->getEditable('workgrid_toolbar_settings')
    //   ->set('workgrid_credentials', 'test')
    //   ->set('tokenExpiration', 'test')
    //   ->set('spaceId', 'test')
    //   ->set('companyCode', 'test')
    //   ->save(TRUE);

    // $container = new ContainerBuilder();
    // // Set the config.factory in the container also.
    // $container->set('config.factory', $this->config_factory);
    // Create an article content type that we will use for testing.
    // $type = $this->container->get('entity_type.manager')->getStorage('node_type')
    //   ->create([
    //     'type' => 'article',
    //     'name' => 'Article',
    //   ]);
    // $type->save();
    // $this->container->get('router.builder')->rebuild();

    // $mock = $this->getMockBuilder('class_name')
    // ->disableOriginalConstructor()
    // ->getMock();

    // $this->config_factory = $this->createMock('\Drupal\Core\Config\ConfigFactory');
    // $this->keyrepository = $this->createMock('\Drupal\key\KeyRepository');
    // $this->http_client = $this->createMock('GuzzleHttp\ClientInterface');
    // $this->workgrid_toolbar = $this->createMock(WorkgridToolbarController::class);

    // $this->http_client = new BanMiddleware($this->kernel, $this->banManager);

    // // Create a key entity using Configuration key provider.
    // $values = [
    //   'key_id' => $this->getRandomGenerator()->word(15),
    //   'key_provider' => 'config',
    //   'key_provider_settings' => $this->key_provider_settings,
    // ];
    // $key = new Key($values, 'key');

    // \Drupal::setContainer($container);
    // $this->keyrepository = \Drupal::service('key.repository');

    // // Mock EntityTypeManager service.
    // $this->keyrepository = $this->getMockBuilder('\Drupal\key\KeyRepository')
    //   ->disableOriginalConstructor()
    //   ->getMock();

    // // Mock  service.
    // $this->http_client = $this->getMockBuilder('\Drupal\key\KeyRepository')
    //   ->disableOriginalConstructor()
    //   ->getMock();

    // $feedsTargetPluginManager = $this
    // ->getMockBuilder('Drupal\feeds\Plugin\Type\FeedsPluginManager')
    // ->disableOriginalConstructor()
    // ->getMock();    
  }

  public function testSomething() {
    // $obj = new WorkgridToolbarController($this->config_factory, $this->keyrepository, $this->http_client);
    // $result = $obj->build();
    var_dump($this->workgrid_toolbar);
    $result = $this->workgrid_toolbar->build();
    // var_dump($result); exit;
    // $this->assertSame($result, []);
  }


//   Mock the Config object, but methods will be mocked in the test class.
//   $this->config = $this->getMockBuilder('\Drupal\Core\Config\ImmutableConfig')
//   ->disableOriginalConstructor()
//   ->getMock();


//   // Mock the ConfigFactory service.
//   $this->configFactory = $this->getMockBuilder('\Drupal\Core\Config
//  \ConfigFactory')
//   ->disableOriginalConstructor()
//   ->getMock();

//   $this->configFactory->expects($this->any())
//   ->method('get')
//   ->with('key.default_config')
//   ->willReturn($this->config);


//   // Mock ConfigEntityStorage object, but methods will be mocked in the test
//  class.
//   $this->configStorage = $this->getMockBuilder('\Drupal\Core\Config\Entity
//  \ConfigEntityStorage')
//   ->disableOriginalConstructor()
//   ->getMock();


//   // Mock EntityManager service.
//   $this->entityManager = $this->getMockBuilder('\Drupal\Core\Entity
//  \EntityManager')
//   ->disableOriginalConstructor()
//   ->getMock();


//   $this->entityManager->expects($this->any())
//   ->method('getStorage')
//   ->with('key')
//   ->willReturn($this->configStorage);


//   // Create a dummy container.
//   $this->container = new ContainerBuilder();
//   $this->container->set('entity.manager', $this->entityManager);
//   $this->container->set('config.factory', $this->configFactory);

//   // Each test class should call \Drupal::setContainer() in its own setUp
//   // method so that test classes can add mocked services to the container
//   // without affecting other test classes.

// protected function setUp() {
//   parent::setUp();
//   $definition = [
//   'id' => 'config',
//   'title' => 'Configuration',
//   'storage_method' => 'config'
//   ];
//   $this->key_settings = ['key_value' => $this->createToken()];
//   $plugin = new ConfigKeyProvider($this->key_settings, 'config', $definition);
//   // Mock the KeyProviderPluginManager service.


//   $this->KeyProviderManager = $this->getMockBuilder('\Drupal\key\KeyProviderPluginManager')
//   ->disableOriginalConstructor()
//   ->getMock();
//   $this->KeyProviderManager->expects($this->any())
//   ->method('getDefinitions')
//   ->willReturn([
//   ['id' => 'file', 'title' => 'File', 'storage_method' => 'file'],
//   ['id' => 'config', 'title' => 'Configuration', 'storage_method' => 'config']
//   ]);


//   $this->KeyProviderManager->expects($this->any())
//   ->method('createInstance')
//   ->with('config', $this->key_settings)
//   ->willReturn($plugin);
//   $this->container->set('plugin.manager.key.key_provider', $this->KeyProviderManager);
//   \Drupal::setContainer($this->container);
//  } 


// public function testGetters() {
//   // Create a key entity using Configuration key provider.
//   $values = [
//   'key_id' => $this->getRandomGenerator()->word(15),
//   'key_provider' => 'config',
//   'key_settings' => $this->key_settings,
//   ];
//   $key = new Key($values, 'key');
//   $this->assertEquals($values['key_provider'], $key->getKeyProvider());
//   $this->assertEquals($values['key_settings'], $key->getKeySettings());
//   $this->assertEquals($values['key_settings']['key_value'], $key->getKeyValue());
//   }


  public function defaultKeyContentProvider() {
    $defaults = ['key_value' => $this->createToken()];
    $definition = [
      'id' => 'config',
      'class' => 'Drupal\key\Plugin\KeyProvider\ConfigKeyProvider',
      'title' => 'Configuration',
    ];
    $KeyProvider = new ConfigKeyProvider($defaults, 'config', $definition);
    return [
      [
        $deefaults,
        $KeyProvider
      ]
    ];
  }

}
