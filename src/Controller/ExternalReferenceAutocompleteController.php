<?php

namespace Drupal\external_reference\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ExternalReferenceAutocompleteController.
 *
 * @package Drupal\external_reference\Controller
 */
class ExternalReferenceAutocompleteController extends ControllerBase {

  /**
   * Delete the content type config variable.
   *
   * @param Symfony\Component\HttpFoundation\Request $request
   *   Page request.
   *
   * @return Symfony\Component\HttpFoundation\JsonResponse
   *   Return the json objects.
   */
  public function lieuxAutocomplete(Request $request) {
    // Geting the config.
    $config = \Drupal::config('external_reference.settings');
    // Getting the content types to track variable.
    $external_reference_track = $config->get('external_reference_track');

    // Getting the actual content type.
    $session = \Drupal::service('user.private_tempstore')->get('external_reference');
    $content_type = $session->get('content_type');

    // Endpoint list.
    $endpoint_list = $external_reference_track[$content_type]['endpoint_list'];
    // @TODO: Add the query at the end.
    $json = file_get_contents($endpoint_list);
    $list = json_decode($json);
    $titles = array_column($list, 'title');

    $string = $request->query->get('q');
    $matches = preg_grep("/$string/i", $titles);
    return new JsonResponse(array_values($matches));
  }

}
