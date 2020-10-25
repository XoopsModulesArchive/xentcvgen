<?php

include 'header.php';

$myts = MyTextSanitizer::getInstance();

function SaveEdit($ID_USER, $selectarray, $type)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $xentUsers, $xentExpertise, $xentTechskill;

    if ('expertise' == $type) {
        $xentUsers->setIdUser($ID_USER);

        $xentExpertise->setIdUser($xentUsers->getIdUser());

        $xentExpertise->setExpertise($selectarray);

        $xentExpertise->update();
    }

    if ('techskill' == $type) {
        $xentUsers->setIdUser($ID_USER);

        $xentTechskill->setIdUser($xentUsers->getIdUser());

        $xentTechskill->setTechskill($selectarray);

        $xentTechskill->update();
    }

    //redirect_header("step4.php",1,_AM_DBUPDATED);

    Showlist();
}

function Showlist()
{
    global $xoopsDB, $xoopsUser, $xoopsConfig, $xentExpertise, $xoopsTpl, $xentTechskill;

    $id = $xoopsUser->getVar('uid');

    $xoopsTpl->assign('lang_or', _MA_XENT_CVGEN_FORM_OR);

    $xoopsTpl->assign('lang_help_ctrlclic', _MA_XENT_CVGEN_FORM_CTRLCLIC);

    $cvexpert = new XoopsThemeForm(_MA_XENT_CVGEN_FORM_EXPERTISE, 'cvexpert', 'step4.php');

    $cvexpert->setExtra('enctype="multipart/form-data"');

    $thearray = getTopic(XENT_DB_XENT_GEN_EXPERTISE_ITEM, 'name', 'ID_EXPERTISEITEM', 'name');

    $cvexpert->addElement(makeSelect('', 'selectarray', $xentExpertise->getArrayUserExpertise($id), $thearray, 8, 0, true));

    $save_button = new XoopsFormButton('', 'add', _MA_XENT_CVGEN_SAVE, 'submit');

    $button_tray = new XoopsFormElementTray('', '');

    $button_tray->addElement($save_button);

    $cvexpert->addElement($button_tray);

    $cvexpert->addElement(new XoopsFormHidden('id', $xoopsUser->getVar('uid')));

    $cvexpert->addElement(new XoopsFormHidden('op', 'SaveEdit'));

    $cvexpert->addElement(new XoopsFormHidden('type', 'expertise'));

    $cvexpert->assign($xoopsTpl);

    $addexpitem = new XoopsThemeForm(_MA_XENT_CVGEN_FORM_EXPERTISE_OTHER, 'addexpitem', 'step4.php');

    $addexpitem->setExtra('enctype="multipart/form-data"');

    $addexpitem->addElement(new XoopsFormText(_MA_XENT_CVGEN_FORM_EXPERTISE_NAME, 'item_name', 30, 255, $xentExpertise->getNameItem()));

    $thearray = getTopic(XENT_DB_XENT_GEN_EXPERTISE_CAT, 'name', 'ID_EXPERTISECAT', 'name');

    $addexpitem->addElement(makeSelect(_MA_XENT_CVGEN_FORM_EXPERTISE_CAT, 'item_select', $xentExpertise->getIdCatItem(), $thearray, 1));

    $save_button = new XoopsFormButton('', 'add', _MA_XENT_CVGEN_SAVE, 'submit');

    $button_tray = new XoopsFormElementTray('', '');

    $button_tray->addElement($save_button);

    $addexpitem->addElement($button_tray);

    $addexpitem->addElement(new XoopsFormHidden('op', 'SaveOther'));

    $addexpitem->addElement(new XoopsFormHidden('type', 'expertise'));

    $addexpitem->assign($xoopsTpl);

    $cvtechskill = new XoopsThemeForm(_MA_XENT_CVGEN_FORM_TECHSKILL, 'cvtechskill', 'step4.php');

    $cvtechskill->setExtra('enctype="multipart/form-data"');

    $thearray = getTopic(XENT_DB_XENT_GEN_TECHSKILL_ITEM, 'name', 'ID_TECHSKILLITEM', 'name');

    $cvtechskill->addElement(makeSelect('', 'selectarray', $xentTechskill->getArrayUserTechskill($id), $thearray, 8, 0, true));

    $save_button = new XoopsFormButton('', 'add', _MA_XENT_CVGEN_SAVE, 'submit');

    $button_tray = new XoopsFormElementTray('', '');

    $button_tray->addElement($save_button);

    $cvtechskill->addElement($button_tray);

    $cvtechskill->addElement(new XoopsFormHidden('id', $xoopsUser->getVar('uid')));

    $cvtechskill->addElement(new XoopsFormHidden('op', 'SaveEdit'));

    $cvtechskill->addElement(new XoopsFormHidden('type', 'techskill'));

    $cvtechskill->assign($xoopsTpl);

    $addtechskillitem = new XoopsThemeForm(_MA_XENT_CVGEN_FORM_TECHSKILL_OTHER, 'addtechskillitem', 'step4.php');

    $addtechskillitem->setExtra('enctype="multipart/form-data"');

    $addtechskillitem->addElement(new XoopsFormText(_MA_XENT_CVGEN_FORM_TECHSKILL_NAME, 'item_name', 30, 255, $xentTechskill->getNameItem()));

    $thearray = getTopic(XENT_DB_XENT_GEN_TECHSKILL_CAT, 'name', 'ID_TECHSKILLCAT', 'name');

    $addtechskillitem->addElement(makeSelect(_MA_XENT_CVGEN_FORM_TECHSKILL_CAT, 'item_select', $xentTechskill->getIdCatItem(), $thearray, 1));

    $save_button = new XoopsFormButton('', 'add', _MA_XENT_CVGEN_SAVE, 'submit');

    $button_tray = new XoopsFormElementTray('', '');

    $button_tray->addElement($save_button);

    $addtechskillitem->addElement($button_tray);

    $addtechskillitem->addElement(new XoopsFormHidden('op', 'SaveOther'));

    $addtechskillitem->addElement(new XoopsFormHidden('type', 'techskill'));

    $addtechskillitem->assign($xoopsTpl);
}

function EXPSaveAddItem($name, $alwaysShown, $display, $id_expertisecat)
{
    global $xoopsDB, $xoopsUser, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $xentExpertise;

    //add expertise in the list

    $xentExpertise->setNameItem($name);

    $xentExpertise->setAlwaysShownItem($alwaysShown);

    $xentExpertise->setDisplayItem($display);

    $xentExpertise->setIdCatItem($id_expertisecat);

    $xentExpertise->addItem();

    //Add this expertise to user

    $id = $xoopsDB->getInsertId();

    $sql = 'INSERT INTO ' . $xoopsDB->prefix(XENT_DB_XENT_GEN_EXPERTISE_USERLINK) . ' (ID_USER, ID_EXPERTISEITEM) VALUES(' . $xoopsUser->getVar('uid') . ', ' . $id . ')';

    $xoopsDB->queryF($sql);

    if (0 == $xoopsDB->errno()) {
        //redirect_header("adminteam.php",1,_AM_DBUPDATED);
    } else {
        redirect_header('step4.php', 20, $xoopsDB->error());
    }

    Showlist();
}

function TechskillSaveAddItem($name, $alwaysShown, $display, $id_techskillcat)
{
    global $xoopsDB, $xoopsUser, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $xentTechskill;

    //add expertise in the list

    $xentTechskill->setNameItem($name);

    $xentTechskill->setAlwaysShownItem($alwaysShown);

    $xentTechskill->setDisplayItem($display);

    $xentTechskill->setIdCatItem($id_techskillcat);

    $xentTechskill->addItem();

    //Add this expertise to user

    $id = $xoopsDB->getInsertId();

    $sql = 'INSERT INTO ' . $xoopsDB->prefix(XENT_DB_XENT_GEN_TECHSKILL_USERLINK) . ' (ID_USER, ID_TECHSKILLITEM) VALUES(' . $xoopsUser->getVar('uid') . ', ' . $id . ')';

    $xoopsDB->queryF($sql);

    if (0 == $xoopsDB->errno()) {
        //redirect_header("adminteam.php",1,_AM_DBUPDATED);
    } else {
        redirect_header('step4.php', 20, $xoopsDB->error());
    }

    Showlist();
}

// ** NTS : À mettre à la fin de chaque fichier nécessitant plusieurs ops **

$op = $_POST['op'] ?? $_GET['op'] ?? 'main';

$GLOBALS['xoopsOption']['template_main'] = 'xent_cvgen_form_step4.html';
switch ($op) {
    case 'SaveEdit':

        if (empty($expertise_select)) {
            $expertise_select = [];
        }

        SaveEdit($id, $selectarray, $type);
        break;
    case 'SaveOther':

        if (empty($_POST['language'])) {
            $language = $xoopsConfig['language'];
        } else {
            $language = $_POST['language'];
        }

        if (empty($_POST['type'])) {
            echo 'marchepo<br>';

            echo $_POST['type'];
        } else {
            $type = $_POST['type'];
        }

        if ('techskill' == $type) {
            TechskillSaveAddItem($_POST['item_name'], 0, 1, $_POST['item_select']);
        }
        if ('expertise' == $type) {
            EXPSaveAddItem($_POST['item_name'], 0, 1, $_POST['item_select']);
        }
        break;
    default:

        Showlist();

        break;
}
include 'footer.php';
// *************************** Fin de NTS **********************************
