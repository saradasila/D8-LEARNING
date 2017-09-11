<?php

namespace Drupal\mymodule\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\mymodule\Entity\NewentityInterface;

/**
 * Class NewentityController.
 *
 *  Returns responses for Newentity routes.
 *
 * @package Drupal\mymodule\Controller
 */
class NewentityController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Newentity  revision.
   *
   * @param int $newentity_revision
   *   The Newentity  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($newentity_revision) {
    $newentity = $this->entityManager()->getStorage('newentity')->loadRevision($newentity_revision);
    $view_builder = $this->entityManager()->getViewBuilder('newentity');

    return $view_builder->view($newentity);
  }

  /**
   * Page title callback for a Newentity  revision.
   *
   * @param int $newentity_revision
   *   The Newentity  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($newentity_revision) {
    $newentity = $this->entityManager()->getStorage('newentity')->loadRevision($newentity_revision);
    return $this->t('Revision of %title from %date', array('%title' => $newentity->label(), '%date' => format_date($newentity->getRevisionCreationTime())));
  }

  /**
   * Generates an overview table of older revisions of a Newentity .
   *
   * @param \Drupal\mymodule\Entity\NewentityInterface $newentity
   *   A Newentity  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(NewentityInterface $newentity) {
    $account = $this->currentUser();
    $langcode = $newentity->language()->getId();
    $langname = $newentity->language()->getName();
    $languages = $newentity->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $newentity_storage = $this->entityManager()->getStorage('newentity');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $newentity->label()]) : $this->t('Revisions for %title', ['%title' => $newentity->label()]);
    $header = array($this->t('Revision'), $this->t('Operations'));

    $revert_permission = (($account->hasPermission("revert all newentity revisions") || $account->hasPermission('administer newentity entities')));
    $delete_permission = (($account->hasPermission("delete all newentity revisions") || $account->hasPermission('administer newentity entities')));

    $rows = array();

    $vids = $newentity_storage->revisionIds($newentity);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\mymodule\NewentityInterface $revision */
      $revision = $newentity_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->revision_timestamp->value, 'short');
        if ($vid != $newentity->getRevisionId()) {
          $link = $this->l($date, new Url('entity.newentity.revision', ['newentity' => $newentity->id(), 'newentity_revision' => $vid]));
        }
        else {
          $link = $newentity->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->revision_log_message->value, '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.newentity.translation_revert', ['newentity' => $newentity->id(), 'newentity_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.newentity.revision_revert', ['newentity' => $newentity->id(), 'newentity_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.newentity.revision_delete', ['newentity' => $newentity->id(), 'newentity_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['newentity_revisions_table'] = array(
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    );

    return $build;
  }

}
