<?php

namespace Drupal\workgrid_toolbar_oauth\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Component\Serialization\Json;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\key\KeyRepositoryInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

/**
 * Workgrid toolbar controller.
 */
class WorkgridToolbarOauthController extends ControllerBase {

  /**
   * Stores the authorization token.
   *
   * @var array
   */
  protected $authorizationTokenResponse;

  /**
   * Stores the configuration factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Stores the keyrepository.
   *
   * @var \Drupal\key\KeyRepositoryInterface
   */
  protected $keyrepository;

  /**
   * The HTTP client.
   *
   * @var \GuzzleHttp\Client
   */
  protected $httpClient;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('key.repository'),
      $container->get('http_client')
    );

  }

  /**
   * Constructs a workgridtoolbaroauth instance.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   ConfigFactory Object.
   * @param \Drupal\key\KeyRepositoryInterface $keyrepository
   *   Keyrepository object.
   * @param \GuzzleHttp\ClientInterface $httpClient
   *   The HTTP client.
   */
  public function __construct(ConfigFactoryInterface $configFactory, KeyRepositoryInterface $keyrepository, ClientInterface $httpClient) {
    $this->configFactory = $configFactory;
    $this->keyrepository = $keyrepository;
    $this->httpClient = $httpClient;
  }

  /**
   * Builds the response.
   *
   * @return array
   *   Toolbar response.
   */
  public function build() {
    $config = $this->configFactory->get('workgrid_toolbar_oauth.settings');
    if ($config->get('workgridCredentials') != "") {
      $keyValues = $this->keyrepository->getKey($config->get('workgridCredentials'))->getKeyValue();
      if ($keyValues != "") {
        $workgridCredentials = Json::decode($keyValues, TRUE);
        if (!empty($workgridCredentials)
        && isset($workgridCredentials['client_id'])
        && isset($workgridCredentials['client_secret'])) {
          $this->authorizationTokenResponse = $this->getAuthorization($workgridCredentials);
          if ($this->authorizationTokenResponse != "") {
            $response = $this->getToolbarResponse();
            return new JsonResponse(
              $response
            );
          }
          else {
            return new JsonResponse([
              'message' => $this->t('Authorization Token Response is empty'),
            ]);
          }
        }
      }
    }

    return new JsonResponse([
      'message' => $this->t('Client Id and Client Secret is not set'),
    ]);

  }

  /**
   * Get Authorization Token.
   *
   * @return array
   *   Token response.
   */
  private function getAuthorization($workgridCredentials) {
    try {
      $config = $this->configFactory->get('workgrid_toolbar_oauth.settings');
      $companycode = $config->get('companyCode');
      $tokenUrl = "https://auth." . $companycode . ".workgrid.com/oauth2/token";
      $response = "";
      $data = [
        'client_id' => $workgridCredentials['client_id'],
        'client_secret' => $workgridCredentials['client_secret'],
        'redirect_uri' => '',
        'grant_type' => 'client_credentials',
        'authorization_uri' => $tokenUrl,
        'token_uri' => $tokenUrl,
        'scopes' => "com.workgrid.api/tokens.all",
        'access_token_url' => $tokenUrl,
        'resource_owner_uri' => "",
      ];

      $responsedata = $this->httpClient->post(
        $tokenUrl, [
          'verify' => TRUE,
          'form_params' => $data,
          'headers' => [
            'Content-type' => 'application/x-www-form-urlencoded',
          ],
        ]);

      $body = "";
      if ($responsedata != "") {
        $body = $responsedata->getBody();
      }
      if ($body) {
        $body = $body->getContents();
      }
      return $body;
    }
    catch (ClientException $e) {
      $response = $e->getResponse();
    }
    catch (RequestException $e) {
      if ($e->hasResponse()) {
        $response = $e->getResponse();
      }
      else {
        $response = $e->getHandlerContext();
      }
    }
    return $response;

  }

  /**
   * Get toolbar response from oauth authorisation token.
   *
   * @return array
   *   Toolbar token.
   */
  private function getToolbarResponse() {
    if ($this->authorizationTokenResponse != NULL) {
      $config = $this->configFactory->get('workgrid_toolbar_oauth.settings');
      $companycode = $config->get('companyCode');
      $toolbarUrl = "https://" . $companycode . ".workgrid.com/v2/tokens";
      $tokenExpire = $config->get('tokenExpiration');
      $arr = Json::decode($this->authorizationTokenResponse, TRUE);
      $response = "";
      $currentUser = $this->currentUser();
      try {
        $fields_string = [
          'username' => $currentUser->getEmail(),
          'expiresIn' => $tokenExpire,
        ];

        $responsedata = $this->httpClient->post(
          $toolbarUrl, [
            'json' => $fields_string,
            'http_errors' => FALSE,
            'headers' => [
              'Content-Type' => 'application/json',
              'Authorization' => 'Bearer ' . $arr["access_token"],
            ],
          ]);

        $body = "";
        if ($responsedata != "") {
          $body = $responsedata->getBody();
        }

        $toolbarToken = Json::decode($body->getContents(), TRUE);
        return $toolbarToken;
      }
      catch (ClientException $e) {
        $response = $e->getResponse();
      }
      catch (RequestException $e) {
        if ($e->hasResponse()) {
          $response = $e->getResponse();
        }
        else {
          $response = $e->getHandlerContext();
        }
      }
      return $response;
    }
    else {
      $response = ['message' => 'toolbar response not found'];
      return $response;
    }
  }

}
