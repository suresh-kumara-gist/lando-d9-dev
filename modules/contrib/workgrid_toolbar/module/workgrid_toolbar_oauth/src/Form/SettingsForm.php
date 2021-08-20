<?php

namespace Drupal\workgrid_toolbar_oauth\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Workgrid Toolbar Oauth settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'workgrid_toolbar_oauth_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['workgrid_toolbar_oauth.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('workgrid_toolbar_oauth.settings');

    $form['workgridCredentials'] = [
      '#type' => 'key_select',
      '#title' => $this->t('Select Workgrid Key'),
      '#default_value' => $config->get('workgridCredentials'),
      '#requried' => TRUE,
    ];

    $form['tokenExpiration'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Token Expiration'),
      '#description' => $this->t('Workgrid Toolbar Auth Token Expiration'),
      '#requried' => TRUE,
      '#default_value' => $config->get('tokenExpiration'),
    ];

    $form['spaceId'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Space Id'),
      '#description' => $this->t('Workgrid Space Id'),
      '#requried' => TRUE,
      '#default_value' => $config->get('spaceId'),
    ];

    $form['companyCode'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Company Code'),
      '#description' => $this->t('Workgrid Company Code'),
      '#requried' => TRUE,
      '#default_value' => $config->get('companyCode'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();

    $this->config('workgrid_toolbar_oauth.settings')
      ->set('workgridCredentials', $values['workgridCredentials'])
      ->set('tokenExpiration', $values['tokenExpiration'])
      ->set('companyCode', $values['companyCode'])
      ->set('spaceId', $values['spaceId'])
      ->save();

    parent::submitForm($form, $form_state);
  }

}
