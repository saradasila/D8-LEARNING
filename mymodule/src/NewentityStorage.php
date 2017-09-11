<?php

namespace Drupal\mymodule;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\mymodule\Entity\NewentityInterface;

/**
 * Defines the storage handler class for Newentity entities.
 *
 * This extends the base storage class, adding required special handling for
 * Newentity entities.
 *
 * @ingroup mymodule
 */
class NewentityStorage extends SqlContentEntityStorage implements NewentityStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(NewentityInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {newentity_revision} WHERE id=:id ORDER BY vid',
      array(':id' => $entity->id())
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {newentity_field_revision} WHERE uid = :uid ORDER BY vid',
      array(':uid' => $account->id())
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(NewentityInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {newentity_field_revision} WHERE id = :id AND default_langcode = 1', array(':id' => $entity->id()))
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('newentity_revision')
      ->fields(array('langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED))
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
