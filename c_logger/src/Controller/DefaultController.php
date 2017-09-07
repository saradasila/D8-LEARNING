<?php

namespace Drupal\c_logger\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class DefaultController.
 *
 * @package Drupal\c_logger\Controller
 */
class DefaultController extends ControllerBase {

  /**
   * Hello.
   *
   * @return string
   *   Return Hello string.
   */


 public function __construct($factory) {
    $this->loggerFactory = $factory;
  }

   public function logger_messages() {
    // Logs a notice to "my_module" channel.   
   return $this->loggerFactory->get('c_logger')->notice($message);  
     // Logs an error to "my_other_module" channel.
    $this->loggerFactory->get('c_logger')->error($message);
  }
  public function hello() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: hello with parameter234'),
    ];
  }

}
