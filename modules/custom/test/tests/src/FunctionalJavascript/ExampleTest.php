<?php

namespace Drupal\Tests\test\FunctionalJavascript;

use Drupal\FunctionalJavascriptTests\WebDriverTestBase;

/**
 * Tests the JavaScript functionality of the Test module.
 *
 * @group test
 */
class ExampleTest extends WebDriverTestBase {

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stable';

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['test'];

  /**
   * {@inheritdoc}
   */
  protected function setUp() : void {
    parent::setUp();
    // Set up the test here.
  }

  /**
   * Test callback.
   */
  public function testSomething() : void {
    // Let's test password strength widget.
    \Drupal::configFactory()->getEditable('user.settings')
      ->set('verify_mail', FALSE)
      ->save();

    $this->drupalGet('user/register');

    $page = $this->getSession()->getPage();

    $password_field = $page->findField('Password');
    $password_strength = $page->find('css', '.js-password-strength__text');

    $this->assertEquals('', $password_strength->getText());

    $password_field->setValue('abc');
    $this->assertEquals('Weak', $password_strength->getText());

    $password_field->setValue('abcABC123!');
    $this->assertEquals('Fair', $password_strength->getText());

    $password_field->setValue('abcABC123!sss');
    $this->assertEquals('Strong', $password_strength->getText());
  }

}
