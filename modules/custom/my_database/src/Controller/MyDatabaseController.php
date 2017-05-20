<?php

namespace Drupal\my_database\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;

/**
 * Controller for my_database.
 */
class MyDatabaseController extends ControllerBase {

  /**
   * Render a list of entries in the database.
   */
  public function entryList() {
    $content = array();

    $connection = Database::getConnection();

    $results = $connection->select('custom_table', 'ct')
      ->fields('ct')
      ->orderBy('id', 'ASC')
      ->execute()->fetchAll();

    $rows = array();
    $headers = array(
      t('Id'),
      t('number'),
      t('teaser'),
      t('text'),
      t('Actions')
    );
    foreach ($results as $result) {
      // Sanitize each entry.
      $row = array_map('Drupal\Component\Utility\SafeMarkup::checkPlain', (array) $result);
      $links = array(
        '#type' => 'operations',
        '#links' => array(
          'edit' => [
            'title' => t('Edit'),
            'url' => Url::fromRoute('my_database.update', array('id' => $result->id)),
          ],
          'delete' => [
            'title' => t('Delete'),
            'url' => Url::fromRoute('my_database.delete', array('id' => $result->id)),
          ],
        ),
      );
      $row['links'] = drupal_render($links);

      $rows[] = $row;
    }
    $content['table'] = array(
      '#type' => 'table',
      '#header' => $headers,
      '#rows' => $rows,
      '#empty' => t('No entries available.'),
    );

    return $content;
  }

}
