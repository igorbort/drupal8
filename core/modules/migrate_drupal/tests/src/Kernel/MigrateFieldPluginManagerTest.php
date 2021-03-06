<?php

namespace Drupal\Tests\migrate_drupal\Kernel;

use Drupal\Component\Plugin\Exception\PluginNotFoundException;

/**
 * Tests the field plugin manager.
 *
 * @group migrate_drupal
 */
class MigrateFieldPluginManagerTest extends MigrateDrupalTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['system', 'user', 'field', 'migrate_drupal', 'options', 'file', 'text', 'migrate_field_plugin_manager_test'];

  /**
   * Tests that the correct MigrateField plugins are used.
   */
  public function testPluginSelection() {
    $plugin_manager = $this->container->get('plugin.manager.migrate.field');

    try {
      // If this test passes, getPluginIdFromFieldType will raise a
      // PluginNotFoundException and we'll never reach fail().
      $plugin_manager->getPluginIdFromFieldType('filefield', ['core' => 7]);
      $this->fail('Expected Drupal\Component\Plugin\Exception\PluginNotFoundException.');
    }
    catch (PluginNotFoundException $e) {
      $this->assertIdentical($e->getMessage(), "Plugin ID 'filefield' was not found.");
    }

    $this->assertIdentical('d6_file', $plugin_manager->getPluginIdFromFieldType('file', ['core' => 6]));

    // Test fallback when no core version is specified.
    $this->assertIdentical('d6_no_core_version_specified', $plugin_manager->getPluginIdFromFieldType('d6_no_core_version_specified', ['core' => 6]));

    try {
      // If this test passes, getPluginIdFromFieldType will raise a
      // PluginNotFoundException and we'll never reach fail().
      $plugin_manager->getPluginIdFromFieldType('d6_no_core_version_specified', ['core' => 7]);
      $this->fail('Expected Drupal\Component\Plugin\Exception\PluginNotFoundException.');
    }
    catch (PluginNotFoundException $e) {
      $this->assertIdentical($e->getMessage(), "Plugin ID 'd6_no_core_version_specified' was not found.");
    }
  }

}
