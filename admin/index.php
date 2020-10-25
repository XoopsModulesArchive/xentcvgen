<?php

include 'admin_header.php';
require XOOPS_ROOT_PATH . '/header.php';
require_once XOOPS_ROOT_PATH . '/class/xoopslists.php';
require_once XOOPS_ROOT_PATH . '/class/pagenav.php';

xoops_cp_header();
echo $oAdminButton->renderButtons('index');

global $xoopsTpl;
//$GLOBALS['xoopsOption']['template_main'] = 'xent_cvgen_form_view.html';
ChooseView($isadmin = 1);
$xoopsTpl->display('db:xent_cvgen_form_view.html');

xoops_cp_footer();
