<?php

namespace Drupal\gym_connector\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class UserController.
 */
class UserController extends ControllerBase {

  /**
   * Hello.
   *
   * @return array
   *   Return Hello string.
   */
  public function index(): array
  {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: hello with parameter(s)'),
    ];
  }

}
