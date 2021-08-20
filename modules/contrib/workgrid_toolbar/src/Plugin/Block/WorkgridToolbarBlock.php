<?php

namespace Drupal\workgrid_toolbar\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Provides an Workgrid Toolbar block.
 *
 * @Block(
 *   id = "workgrid_toolbar",
 *   admin_label = @Translation("Workgrid Toolbar"),
 *   category = @Translation("Workgrid Toolbar")
 * )
 */
class WorkgridToolbarBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Stores the configuration factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'marginbottom' => $this->configuration['marginbottom'],
      'margintop' => $this->configuration['margintop'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {

    $form['margintop'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Margin Top'),
      '#description' => $this->t('Margin in pixels - example: 20'),
      '#default_value' => $this->configuration['margintop'],
    ];

    $form['marginbottom'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Margin Bottom'),
      '#description' => $this->t('Margin in pixels - example: 20'),
      '#default_value' => $this->configuration['marginbottom'],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['margintop'] = $form_state->getValue('margintop');
    $this->configuration['marginbottom'] = $form_state->getValue('marginbottom');
  }

  /**
   * Creates a SystemBrandingBlock instance.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The factory for configuration objects.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $config_factory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->configFactory = $config_factory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $workgrid_toolbar_config = $this->configFactory->get('workgrid_toolbar.settings');
    $build['content'] = [
      '#attached' => [
        'drupalSettings' => [
          'workgrid_toolbar' => [
            'authendpoint' => $workgrid_toolbar_config->get('authendpoint'),
            'spaceId' => $workgrid_toolbar_config->get('spaceId'),
            'companyCode' => $workgrid_toolbar_config->get('companyCode'),
            'margintop' => $this->configuration['margintop'],
            'marginbottom' => $this->configuration['marginbottom'],
          ],
        ],
        'library' => [
          'workgrid_toolbar/workgrid_toolbar',
        ],
      ],
    ];
    return $build;
  }

  /**
   * Checks access for the users task page.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The account viewing the page.
   *
   * @return \Drupal\Core\Access\AccessResultInterface
   *   The access result.
   */
  protected function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIf($account->isAuthenticated());
  }

}
