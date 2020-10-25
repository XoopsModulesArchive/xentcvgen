<?php

function ChooseLang($load, $op)
{
    $myts = MyTextSanitizer::getInstance();

    global $xoopsDB, $xoopsTpl, $xoopsUser;

    $user_id = $xoopsUser->getVar('uid');

    $language = new XoopsThemeForm(_MA_XENT_CVGEN_LANGFORM, 'language', $load);

    $language->setExtra("enctype='multipart/form-data'");

    $button_tray = new XoopsFormElementTray('', '');

    $button_tray->addElement(new XoopsFormSelectLang('', 'language'));

    $language->addElement(new XoopsFormHidden('op', $op));

    $button_tray->addElement(new XoopsFormButton('', 'submit', _MA_XENT_CVGEN_FORM_NEXTSTEP, 'submit'));

    $language->addElement($button_tray);

    $language->assign($xoopsTpl);
}

function ChooseView($isadmin = 0)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsTpl, $xoopsUser;

    $myts = MyTextSanitizer::getInstance();

    $user_id = $xoopsUser->getVar('uid');

    if (1 == $isadmin) {
        $view = new XoopsThemeForm(_MA_XENT_CVGEN_EXPORTFORM, 'export', '../view.php');
    } else {
        $view = new XoopsThemeForm(_MA_XENT_CVGEN_EXPORTFORM, 'export', 'view.php');
    }

    $view->setExtra("enctype='multipart/form-data'");

    if ($xoopsUser->isAdmin()) {
        $userstart = isset($_GET['userstart']) ? (int)$_GET['userstart'] : 0;

        $memberHandler = xoops_getHandler('member');

        $usercount = $memberHandler->getUserCount();

        $nav = new XoopsPageNav($usercount, 200, $userstart, 'userstart', 'fct=users');

        //$editform = new XoopsThemeForm(_AM_EDEUSER, "edituser", "admin.php");

        $user_select = new XoopsFormSelect('', 'uid');

        $criteria = new CriteriaCompo();

        $criteria->setSort('uname');

        $criteria->setOrder('ASC');

        $criteria->setLimit(200);

        $criteria->setStart($userstart);

        $user_select->addOptionArray($memberHandler->getUserList($criteria));

        $user_select_tray = new XoopsFormElementTray(_MA_XENT_CVGEN_SELECTUSER, '');

        $user_select_tray->addElement($user_select);

        $user_select_nav = new XoopsFormLabel('', $nav->renderNav(4));

        $user_select_tray->addElement($user_select_nav);

        //$op_select = new XoopsFormSelect("", "op");

        //$op_select->addOptionArray(array("modifyUser"=>_AM_MODIFYUSER, "delUser"=>_AM_DELUSER));

        //$submit_button = new XoopsFormButton("", "submit", _AM_GO, "submit");

        $fct_hidden = new XoopsFormHidden('fct', 'users');

        $view->addElement($user_select_tray);

    //$view->addElement($op_select);
        //$view->addElement($submit_button);
        //$view->addElement($fct_hidden);
    } else {
        $view->addElement(new XoopsFormHidden('uid', $op));
    }

    $button_tray = new XoopsFormElementTray('', '');

    $button_tray->addElement(new XoopsFormSelectLang('', 'language'));

    $export = new XoopsFormSelect(_MA_XENT_CVGEN_SELECTEXPORT, 'op', 'exportHTML');

    $options = ['exportPrint' => _MA_XENT_CVGEN_SELECTEXPORTPRINT, 'exportHTML' => _MA_XENT_CVGEN_SELECTEXPORTHTML/*, 'exportXML' => _MA_XENT_CVGEN_SELECTEXPORTPDF, 'exportPDF' => _MA_XENT_CVGEN_SELECTEXPORTXML*/];

    $export->addOptionArray($options);

    $view->addElement($export, true);

    $button_tray->addElement(new XoopsFormButton('', 'submit', _MA_XENT_CVGEN_FORM_NEXTSTEP, 'submit'));

    $view->addElement($button_tray);

    $view->assign($xoopsTpl);
}

/*function makeSelect($caption="", $name, $selected, $arrayOptions, $linesDisplayed=1, $idMatters=0, $multiple=false){

$select = new XoopsFormSelect($caption, $name, $selected, $linesDisplayed, $multiple);

if ($idMatters == 1){
$select->addOption(0, "---");
}

$select->addOptionArray($arrayOptions);


return $select;
}*/
