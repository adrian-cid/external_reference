<?php

/**
 * @file
 * Provide views data for our custom module_name.
 */

/**
 * Implements hook_views_data_alter().
 */
function external_reference_views_data_alter(array &$data) {
  $data['node']['external_reference'] = array(
    'title' => t('External Reference'),
    'field' => array(
      'id' => 'external_reference',
      'help' => t('Show the external reference title'),
    ),
  );
}
