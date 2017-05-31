<?php

namespace Drupal\external_reference\Plugin\views\field;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;

/**
 * Field handler to External Reference.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("external_reference")
 */
class ExternalReference extends FieldPluginBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    // Leave empty to avoid a query on this field.
  }

  /**
   * Define the available options.
   *
   * @return array
   *   Options
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    return $options;
  }

  /**
   * Provide the options form.
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function render(ResultRow $values) {
    $node = $values->_entity;
    // Searching the id.
    $connection = \Drupal::database();
    $info = $connection->select('external_reference', 'er')
      ->fields('er', ['external_id'])
      ->condition('er.nid', $node->id())
      ->execute()
      ->fetchAssoc();

    // Geting the config.
    $config = \Drupal::config('external_reference.settings');
    // Getting the content types to track variable.
    $external_reference_track = $config->get('external_reference_track');
    $endpoint_individual = $external_reference_track[$node->getType()]['endpoint_individual'];

    $json = file_get_contents($endpoint_individual . $info['external_id']);
    $element = json_decode($json);
    $title = $element->title;

    return $title;
  }

}
