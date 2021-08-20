<?php

namespace Drupal\Tests\workgrid_toolbar_oauth\Unit;

use Drupal\Tests\UnitTestCase;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\workgrid_toolbar_oauth\Controller\WorkgridToolbarOauthController;
use Drupal\key\KeyRepositoryInterface;
use Drupal\key\Entity\Key;
use Drupal\Component\Serialization\Json;
use GuzzleHttp\Client;

/**
 * Test description.
 *
 * @group workgrid_toolbar
 * @coversDefaultClass \Drupal\commerce\PurchasableEntityTypeRepository
 * @group commerce
 */
class WorkgridToolbarOauthTokenTest extends UnitTestCase {

  /**
   * Key repository.
   *
   * @var Drupal\key\KeyRepositoryInterface
   */
  private $keyrepository;

  /**
   * Config factory.
   *
   * @var Drupal\Core\Config\ConfigFactoryInterface
   */
  private $configFactory;

  /**
   * Http client.
   *
   * @var GuzzleHttp\Client
   */
  private $client;

  /**
   * Workgrid toolbar.
   *
   * @var Drupal\workgrid_toolbar_oauth\Controller\WorkgridToolbarOauthController
   */
  private $workgridToolbar;

  /**
   * {@inheritdoc}
   */
  protected function setUp() : void {
    parent::setUp();
    $this->keyrepository = $this->prophesize(KeyRepositoryInterface::CLASS);
    $key = $this->prophesize(Key::CLASS);
    $key->getKeyValue()->willReturn(Json::encode([
      "client_id" => "client_id value",
      "client_secret" => "client_secret value",
    ]));
    $this->keyrepository->getKey("test")->willReturn($key->reveal());

    $this->client = $this->prophesize(Client::CLASS);

    \Drupal::unsetContainer();
    $container = new ContainerBuilder();
    $container->set('config.factory', $this->configFactory);
    $container->set('key.repository', $this->keyrepository);
    $container->set('http_client', $this->client);

    \Drupal::setContainer($container);
    $container->set('string_translation', self::getStringTranslationStub());
  }

  /**
   * Test callback.
   */
  public function testAuthorization() : void {
    $this->configFactory = $this->getConfigFactoryStub([
      'workgrid_toolbar_oauth.settings' => [],
    ]);
    $this->client->post("https://test.com", [
      'verify' => TRUE,
      'form_params' => [],
    ])->willReturn("{}");

    $this->workgridToolbarOauth = new WorkgridToolbarOauthController(
      $this->configFactory,
      $this->keyrepository->reveal(),
      $this->client->reveal()
    );
    $result = $this->workgridToolbarOauth->build();
    $this->assertSame($result->getContent(), '{"message":"Client Id and Client Secret is not set"}');
  }

  /**
   * Test callback.
   */
  public function testAuthorizationResponse() : void {
    $this->configFactory = $this->getConfigFactoryStub([
      'workgrid_toolbar_oauth.settings' => [
        'workgridCredentials' => "test",
        'companyCode' => "test",
      ],
    ]);

    $this->client->post("https://auth.test.workgrid.com/oauth2/token", [
      "verify" => TRUE,
      "form_params" => [
        "client_id" => "client_id value",
        "client_secret" => "client_secret value",
        "redirect_uri" => "",
        "grant_type" => "client_credentials",
        "authorization_uri" => "https://auth.test.workgrid.com/oauth2/token",
        "token_uri" => "https://auth.test.workgrid.com/oauth2/token",
        "scopes" => "com.workgrid.api/tokens.all",
        "access_token_url" => "https://auth.test.workgrid.com/oauth2/token",
        "resource_owner_uri" => "",
      ],
      "headers" => [
        "Content-type" => "application/x-www-form-urlencoded",
      ],
    ])->willReturn();

    $this->workgridToolbarOauth = new WorkgridToolbarOauthController(
      $this->configFactory,
      $this->keyrepository->reveal(),
      $this->client->reveal()
    );
    $result = $this->workgridToolbarOauth->build();
    $this->assertSame($result->getContent(), '{"message":"Authorization Token Response is empty"}');
  }

}
