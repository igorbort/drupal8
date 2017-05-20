<?php

namespace Drupal\bort_test\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Controller routines for page example routes.
 */
class BortController extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  protected function getModuleName() {
    return 'bort_test';
  }

  /**
   * Constructs a page.
   *
   * The router _controller callback, maps the path
   * 'drupal8/mypage/page' to this method.
   *
   * _controller callbacks return a renderable array for the content area of the
   * page. The theme system will later render and surround the content with the
   * appropriate blocks, navigation, and styling.
   */
  public function page() {
    return array(
      '#markup' => '<p>' . $this->t('My page: Hello world!') . '</p>',
    );
  }
}
