<?php

namespace TallySheet\Form;

use \TallySheet\Tools\View;

require_once __DIR__ . '/../BaseTallySheet.php';

/**
 * Description of tally_init
 *
 * @author pwilvers
 */
class TallyInitForm extends \TallySheet\BaseTallySheet {

    public function render($param) {
        $this->view->assign("param", $param);
        return $this->view->render(__DIR__ . "/../Template/TallySheetInitFormTemplate.php");
    }

}
