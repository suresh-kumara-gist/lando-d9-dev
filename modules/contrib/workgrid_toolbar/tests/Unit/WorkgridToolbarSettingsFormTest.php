<?php

namespace Drupal\Tests\workgrid_toolbar\Unit;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Config\Config;
use Drupal\Core\Form\FormState;
use Drupal\Core\StringTranslation\TranslationInterface;
use Drupal\workgrid_toolbar\Form\SettingsForm;
use Drupal\Tests\UnitTestCase;

/**
 * Test class for CustomModuleForm.
 *
 * Must extend from UnitTestCase.
 */
class WorkgridToolbarSettingsFormTest extends UnitTestCase {

  /**
   * Traslation interace mock object.
   *
   * @var \Drupal\Core\StringTranslation\TranslationInterface
   */
  private $translationInterfaceMock;

  /**
   * Configuration Interface mock object.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  private $configFactoryMock;

  /**
   * Config mock object.
   *
   * @var \Drupal\Core\Config\Config
   */
  private $configMock;

  /**
   * Workgrid Toolbar settins form mock object.
   *
   * @var \Drupal\workgrid_toolbar\Form\SettingsForm
   */
  private $form;

  /**
   * {@inheritdoc}
   */
  public function setUp() : void {
    // prophesize() is made available via extension from UnitTestCase.
    // Call this method to create a mock based on a class.
    $this->translationInterfaceMock = $this->prophesize(TranslationInterface::class);

    // Create mock to return config that will be used in the code under test.
    $this->configMock = $this->prophesize(Config::class);

    $this->configMock->get('authendpoint')->willReturn([
      'label' => 'Auth End Point',
    ]);

    $this->configMock->get('spaceId')->willReturn([
      'label' => 'Space Id',
    ]);

    $this->configMock->get('companyCode')->willReturn([
      'label' => 'Company Code',
    ]);

    $this->configFactoryMock = $this->prophesize(ConfigFactoryInterface::class);
    $this->configFactoryMock
      ->getEditable('workgrid_toolbar.settings')
      ->willReturn($this->configMock);

    // Instantiate the code under test.
    $this->form = new SettingsForm($this->configFactoryMock->reveal());

    /*
     * Config Base Form has a call to $this->t() which references
     *  the TranslationService Set the translation service mock so
     *  that the program won't throw an error.
     */
    $this->form->setStringTranslation($this->translationInterfaceMock->reveal());
  }

  /**
   * Test that the correct form ID is returned.
   */
  public function testFormId() : void {
    $this->assertEquals('workgrid_toolbar_settings', $this->form->getFormId());
  }

  /**
   * Test that the correct form fields are added.
   */
  public function testBuildForm() : void {
    $form = [];
    $form_state = new FormState();

    // Call the function being tested.
    $retForm = $this->form->buildForm($form, $form_state);
    $this->assertEquals('system_config_form', $retForm['#theme']);
    $this->assertSame('actions', $retForm["actions"]["#type"]);

    /*
     * The code under test retrieves the label from config
     *   check that the label returned by config is given
     *   to the title attribute of the custom field.
     */
    $this->assertSame(
      'textfield',
      $retForm['authendpoint']['#type']
    );

    $this->assertSame(
      'textfield',
      $retForm['spaceId']['#type']
    );

    $this->assertSame(
      'textfield',
      $retForm['companyCode']['#type']
    );

  }

}
