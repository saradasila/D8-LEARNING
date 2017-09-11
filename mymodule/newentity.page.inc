<?php

/**
 * @file
 * Contains newentity.page.inc.
 *
 * Page callback for Newentity entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Newentity templates.
 *
 * Default template: newentity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_newentity(array &$variables) {
  // Fetch Newentity Entity Object.
  $newentity = $variables['elements']['#newentity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
