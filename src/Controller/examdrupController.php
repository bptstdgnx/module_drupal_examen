<?php
namespace Drupal\examdrup\Controller;
use Drupal\Core\Controller\ControllerBase;
class examdrupController extends ControllerBase {  /**
 * @param string $param
 * @return array
 */
    public function content($param = '') {
        $message = $this->t('You are on the examdrup page. Your name is @username, and the parameter in the URL is @param', [
            '@username' => $this->currentUser()->getAccountName(),
            '@param' => $param,
        ]);
        return ['#markup' => $message];
    }
}