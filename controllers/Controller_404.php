<?php


namespace controllers;

use \core\Controller;

class Controller_404 extends Controller {

    public function action_index($params = [])
    {
        $this->view->generate('404.php', 'layout.php');
    }
}
