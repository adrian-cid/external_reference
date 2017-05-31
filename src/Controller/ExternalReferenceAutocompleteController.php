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
    $string = $request->query->get('q');
    $users = ['admin', 'foo', 'foobar', 'foobaz'];
    $matches = preg_grep("/$string/i", $users);
    return new JsonResponse(array_values($matches));
  }

}
