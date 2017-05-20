<?php

namespace Drupal\my_database\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Core\Database\Database;

/**
 * Builds the form to delete a path alias.
 */
class MyDatabaseEntryDeleteForm extends ConfirmFormBase {

  protected $entry_id;

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'my_database_delete_form';
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Are you sure you want to delete this?');
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('my_database.list');
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $id = NULL) {
    $this->entry_id = $id;

    $form = parent::buildForm($form, $form_state);

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $connection = Database::getConnection();
    $connection->delete('custom_table')
      ->condition('id', $this->entry_id)
      ->execute();

    $form_state->setRedirect('my_database.list');
  }

}
