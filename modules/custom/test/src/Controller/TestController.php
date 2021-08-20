<?php

namespace Drupal\test\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for test routes.
 */
class TestController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }

}
