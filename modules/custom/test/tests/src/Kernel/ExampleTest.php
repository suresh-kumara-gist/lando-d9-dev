<?php

namespace Drupal\Tests\test\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * Test description.
 *
 * @group test
 */
class ExampleTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'test',
    'key',
    'oauth2_client',
    'workgrid_toolbar',
  ];

  /**
   * {@inheritdoc}
   */
  protected function setUp() : void {
    parent::setUp();
    // Mock required services here.
  }

  /**
   * Test callback.
   */
  public function testSomething() : void {
    $result = $this->container->get('transliteration')->transliterate('Друпал');
    $this->assertEquals('Drupal', $result);
  }

}
