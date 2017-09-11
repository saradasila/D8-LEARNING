<?php

namespace Drupal\mymodule;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Newentity entity.
 *
 * @see \Drupal\mymodule\Entity\Newentity.
 */
class NewentityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\mymodule\Entity\NewentityInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished newentity entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published newentity entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit newentity entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete newentity entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add newentity entities');
  }

}
