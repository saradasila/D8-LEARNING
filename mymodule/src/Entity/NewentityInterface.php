<?php

namespace Drupal\mymodule\Entity;

use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\RevisionableInterface;
use Drupal\Component\Utility\Xss;
use Drupal\Core\Url;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Newentity entities.
 *
 * @ingroup mymodule
 */
interface NewentityInterface extends RevisionableInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Newentity name.
   *
   * @return string
   *   Name of the Newentity.
   */
  public function getName();

  /**
   * Sets the Newentity name.
   *
   * @param string $name
   *   The Newentity name.
   *
   * @return \Drupal\mymodule\Entity\NewentityInterface
   *   The called Newentity entity.
   */
  public function setName($name);

  /**
   * Gets the Newentity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Newentity.
   */
  public function getCreatedTime();

  /**
   * Sets the Newentity creation timestamp.
   *
   * @param int $timestamp
   *   The Newentity creation timestamp.
   *
   * @return \Drupal\mymodule\Entity\NewentityInterface
   *   The called Newentity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Newentity published status indicator.
   *
   * Unpublished Newentity are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Newentity is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Newentity.
   *
   * @param bool $published
   *   TRUE to set this Newentity to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\mymodule\Entity\NewentityInterface
   *   The called Newentity entity.
   */
  public function setPublished($published);

  /**
   * Gets the Newentity revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Newentity revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\mymodule\Entity\NewentityInterface
   *   The called Newentity entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Newentity revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Newentity revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\mymodule\Entity\NewentityInterface
   *   The called Newentity entity.
   */
  public function setRevisionUserId($uid);

}
