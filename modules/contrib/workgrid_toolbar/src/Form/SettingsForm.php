<?php

namespace Drupal\workgrid_toolbar\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Workgrid Toolbar settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'workgrid_toolbar_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['workgrid_toolbar.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('workgrid_toolbar.settings');

    $form['authendpoint'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Auth End Point'),
      '#description' => $this->t('Workgrid Auth end point where it makes call to workgrid toolbar authentication'),
      '#requried' => TRUE,
      '#value' => '/workgrid_toolbar/rest_resource?_format=json',
      '#default_value' => $config->get('authendpoint'),
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
    $this->config('workgrid_toolbar.settings')
      ->set('companyCode', $values['companyCode'])
      ->set('spaceId', $values['spaceId'])
      ->set('authendpoint', $values['authendpoint'])
      ->save();
    parent::submitForm($form, $form_state);
  }

}
