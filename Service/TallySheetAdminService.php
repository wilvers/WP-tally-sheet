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
        $ajaxUrl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $ajaxUrl = str_replace("admin.php", "admin-ajax.php", $ajaxUrl) . '&action=save_tallysheet';
        $this->view
                //->assign("formUrl", 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'])
                ->assign("formUrlAjax", $ajaxUrl)
                ->assign("jsonData", $this->getData())
        ;
    }

    protected function getData() {
        return file_get_contents(__DIR__ . "/../data/data.json");
    }

    public function saveJson() {
        $data = $_POST;

        file_put_contents(__DIR__ . "/../data/data_" . date("YmdHis") . ".json", json_encode($data));
        file_put_contents(__DIR__ . "/../data/data.json", json_encode($data));

        header('Content-Type: application/json');
        echo json_encode(array("msg" => "saved"));
        die;
        return true;
    }

}
