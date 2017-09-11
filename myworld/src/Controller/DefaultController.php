<?php

namespace Drupal\myworld\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class DefaultController.
 *
 * @package Drupal\myworld\Controller
 */
class DefaultController extends ControllerBase {

  /**
   * Hello.
   *
   * @return string
   *   Return Hello string.
   */
  public function hello() {
    // return [
    //   '#type' => 'markup',
    //   '#markup' => $this->t('Implement method: hello with parameter'),
    // ];

$entity_query = \Drupal::entityQuery('node')
            ->condition('type', 'product'); 
        $nids = $entity_query->execute();
        $history_list = \Drupal\node\Entity\Node::loadMultiple($nids);    

        $pro_data = [];   
  foreach ($history_list as $value) {
    //echo '<pre>';print_r($value);   
    $pr[]['nid'] = $value->nid->value;  
    $pr[]['title'] = $value->title->value;
    $pr[]['url'] = $value->field_product_url->uri;  
    $pro_data = $pr;   
  //echo '<pre>';
    //print_r($pro_data);
  }
  //die;
return array(
            '#theme' => 'my_world',
            '#pro_data' => $pro_data, 
        );
  }
}