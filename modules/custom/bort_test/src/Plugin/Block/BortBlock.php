<?php

namespace Drupal\bort_test\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;


/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "bort_block",
 *   admin_label = @Translation("Hello block"),
 * )
 */
class BortBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return array(
      '#markup' => $this->t('Hello, World!'),
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account) {
    if (!$account->isAnonymous()) {
      return AccessResult::allowed();
    }
    return AccessResult::forbidden(drupal_set_message(t('access to view this content is denied.')));
  }

}
