<?php

namespace TallySheet\Service;

require_once __DIR__ . '/../BaseTallySheet.php';

use TallySheet\BaseTallySheet;

//
///**
// * Description of TallySheetAdmin
// *
// * @author pwilvers
// */
class TallySheetAdminService extends BaseTallySheet {

    public function render($param) {
        $this->view->assign("param", $param);
        $this->setView();
        return $this->view->render(__DIR__ . "/../Template/TallySheetAdminTemplate.php");
    }

    protected function setView() {
        $this->view
                ->assign("formUrl", 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'])
                ->assign("jsonData", $this->getData())
        ;
    }

    protected function getData() {
        return file_get_contents(__DIR__ . "/../data/data.json");
    }

}
