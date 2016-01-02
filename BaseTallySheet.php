<?php

namespace TallySheet;

require_once __DIR__ . '/Tools/View.php';
require_once __DIR__ . '/Tools/Request.php';
require_once __DIR__ . '/Tools/Response.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Base
 *
 * @author pwilvers
 */
class BaseTallySheet {

    protected $view;

    /**
     *
     */
    public function __construct() {
        $this->view = $this->getView();
    }

    public function getRequest() {
        return new Tools\Request();
    }

    public function getView() {
        return new Tools\View();
    }

    public function getResponse() {
        return new Tools\Response();
    }

}
