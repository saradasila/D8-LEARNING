<?php

namespace Drupal\mymodule;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface NewentityStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Newentity revision IDs for a specific Newentity.
   *
   * @param \Drupal\mymodule\Entity\NewentityInterface $entity
   *   The Newentity entity.
   *
   * @return int[]
   *   Newentity revision IDs (in ascending order).
   */
  public function revisionIds(NewentityInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Newentity author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Newentity revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\mymodule\Entity\NewentityInterface $entity
   *   The Newentity entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(NewentityInterface $entity);

  /**
   * Unsets the language for all Newentity with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
