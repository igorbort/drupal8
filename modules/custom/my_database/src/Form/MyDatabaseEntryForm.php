<?php

namespace Drupal\my_database\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

/**
 * Simple form to add an entry, with all the interesting fields.
 */
class MyDatabaseEntryForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'my_database_add_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $id = NULL) {
    $form = array();
    $connection = Database::getConnection();
    $results = [];
    if (!empty($id)) {
      $results = $connection->select('custom_table', 'ct')
        ->fields('ct')
        ->condition('id', $id)
        ->execute()->fetchAssoc();
    }

    $id = !empty($results) ? $id : NULL;
    $form['entry_id'] = [
      '#type' => 'value',
      '#value' => $id,
    ];
    $form['number'] = array(
      '#type' => 'number',
      '#title' => t('Number'),
      '#default_value' => isset($results['number']) ? $results['number'] : '',
    );
    $form['teaser'] = array(
      '#type' => 'textfield',
      '#title' => t('Teaser'),
      '#default_value' => isset($results['teaser']) ? $results['teaser'] : '',
    );
    $form['text'] = array(
      '#type' => 'textarea',
      '#title' => t('Text'),
      '#default_value' => isset($results['text']) ? $results['text'] : '',
    );
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => isset($id) ? t('Update') : t('Add'),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Save the submitted entry.
    $entry_id = $form_state->getValue('entry_id');
    $entry = array(
      'number' => $form_state->getValue('number'),
      'teaser' => $form_state->getValue('teaser'),
      'text' => $form_state->getValue('text'),
    );

    $connection = Database::getConnection();
    if (empty($entry_id)) {
      $connection->insert('custom_table')->fields($entry)->execute();
    }
    else {
      $connection->update('custom_table')->fields($entry)->execute();
    }
  }

}
