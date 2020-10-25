<?php

include 'header.php';

foreach ($_REQUEST as $a => $b) {
    $$a = $b;
}
$op = $_POST['op'] ?? $_GET['op'] ?? 'main';

if (empty($_POST['language'])) {
    $language = $xoopsConfig['language'];
} else {
    $language = $_POST['language'];
}

if (empty($_POST['uid'])) {
    $uid = '';
} else {
    $uid = $_POST['uid'];
}

if (isset($_POST['submit'])) {
    switch ($op) {
        case 'exportXML':
            //Export CV to XML format

            break;
        case 'exportPDF':
            //Export CV to PDF format
            require_once XOOPS_ROOT_PATH . '/modules/xentcvgen/class/fpdf/fpdf.inc.php';

            break;
        case 'exportPrint':
            //Export CV to Print format

            //Thank to Marcan for this code.
            $xoopsTpl = new XoopsTpl();
            global $xoopsConfig, $xoopsDB, $xoopsModule, $myts;
            require_once XOOPS_ROOT_PATH . '/class/template.php';

            if ('' == !$xoopsModuleConfig['page_footer']) {
                $xoopsTpl->assign('page_footer', $myts->displayTarea($xoopsModuleConfig['page_footer']));
            } else {
                $xoopsTpl->assign('page_footer', '');
            }

            if ('' == !$xoopsModuleConfig['page_header']) {
                $xoopsTpl->assign('page_header', $myts->displayTarea($xoopsModuleConfig['page_header']));
            } else {
                $xoopsTpl->assign('page_header', '');
            }

            if ('' == !$xoopsModuleConfig['logo']) {
                $xoopsTpl->assign('logo', '<img src="' . $myts->displayTarea($xoopsModuleConfig['logo']) . '">');
            } else {
                $xoopsTpl->assign('logo', '');
            }

            $xentCv->setLanguage($language);
            $xentCvXp->setLanguage($language);
            if ($xoopsUser->isAdmin()) {
                $xentCv->setUid($uid);

                $xentCvXp->setUid($uid);

                $xentCvEdu->setUid($uid);
            } else {
                $xentCv->setUid($xoopsUser->getVar('uid'));

                $xentCvXp->setUid($xoopsUser->getVar('uid'));

                $xentCvEdu->setUid($xoopsUser->getVar('uid'));
            }

            if ($xentCv->cvExistTest()) {
                //EXISTE

                $xentCv->BuiltCvHTML();

                $printtitle = $xoopsConfig['sitename'];

                $xoopsTpl->assign('printtitle', $printtitle);

                $xoopsTpl->display('db:xent_cvgen_exportprint.html');
            } else {
                redirect_header('index.php', 5, _MA_XENT_CVGEN_CVNOTEXIST);
            }

            break;
        case 'exportHTML':
            //Export CV to HTML format
            $GLOBALS['xoopsOption']['template_main'] = 'xent_cvgen_form_exporthtml.html';

            if ('' == !$xoopsModuleConfig['page_footer']) {
                $xoopsTpl->assign('page_footer', $myts->displayTarea($xoopsModuleConfig['page_footer']));
            } else {
                $xoopsTpl->assign('page_footer', '');
            }

            if ('' == !$xoopsModuleConfig['page_header']) {
                $xoopsTpl->assign('page_header', $myts->displayTarea($xoopsModuleConfig['page_header']));
            } else {
                $xoopsTpl->assign('page_header', '');
            }

            if ('' == !$xoopsModuleConfig['logo']) {
                $xoopsTpl->assign('logo', '<img src="' . $myts->displayTarea($xoopsModuleConfig['logo']) . '">');
            } else {
                $xoopsTpl->assign('logo', '');
            }

            $xentCv->setLanguage($language);
            $xentCvXp->setLanguage($language);

            if ($xoopsUser->isAdmin()) {
                $xentCv->setUid($uid);

                $xentCvXp->setUid($uid);

                $xentCvEdu->setUid($uid);
            } else {
                $xentCv->setUid($xoopsUser->getVar('uid'));

                $xentCvXp->setUid($xoopsUser->getVar('uid'));

                $xentCvEdu->setUid($xoopsUser->getVar('uid'));
            }

            if ($xentCv->cvExistTest()) {
                //EXISTE

                $xentCv->BuiltCvHTML();
            } else {
                redirect_header('index.php', 5, _MA_XENT_CVGEN_CVNOTEXIST);
            }
            include 'footer.php';

            break;
        default:

            require_once XOOPS_ROOT_PATH . '/class/xoopslists.php';
            require_once XOOPS_ROOT_PATH . '/class/pagenav.php';
            $GLOBALS['xoopsOption']['template_main'] = 'xent_cvgen_form_view.html';
            ChooseView();

            include 'footer.php';
            break;
    }
} else {
    require_once XOOPS_ROOT_PATH . '/class/xoopslists.php';

    require_once XOOPS_ROOT_PATH . '/class/pagenav.php';

    $GLOBALS['xoopsOption']['template_main'] = 'xent_cvgen_form_view.html';

    ChooseView();

    include 'footer.php';
}
