<?php

namespace Drupal\esteemed\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Routing\TrustedRedirectResponse;
use Drupal\Core\Url;
use Drupal\encrypt\Entity\EncryptionProfile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class EntityEncryptUrlController.
 */
class EntityEncryptUrlController extends ControllerBase {

  /**
   * Build.
   *
   * @param $encrypt
   *
   * @return string
   */
  public function build($encrypt) {
    if ($encrypt) {
      $encryption_profile = EncryptionProfile::load("default");
      $decryptedString = \Drupal::service('encryption')->decrypt($encrypt, $encryption_profile);
      if ($decryptedString && !empty($decryptedString)) {
        $url = Url::fromUserInput("$decryptedString");

        $response = new RedirectResponse($url->toString());
        $response->send();
      }
    }
    throw new NotFoundHttpException();
  }
}
