<?php

include 'header.php';
$myts = MyTextSanitizer::getInstance();

global $xoopsDB, $xoopsTpl, $xoopsUser;
$GLOBALS['xoopsOption']['template_main'] = 'xent_cvgen_form_start.html';
$user_id = $xoopsUser->getVar('uid');

//echo "<br><br><br><br><a href='step1.php'>Debuter l'entrer de votre CV</a>";
$language = new XoopsThemeForm(_MA_XENT_CVGEN_LANGFORM, 'language', 'step1.php');

$language->setExtra("enctype='multipart/form-data'"); //de xoops-doc
//$language->addElement(new XoopsFormSelectLang(_MA_XENT_CVGEN_LANGCHOOSE, "language"));

$button_tray = new XoopsFormElementTray('', '');
$button_tray->addElement(new XoopsFormSelectLang('', 'language'));
$button_tray->addElement(new XoopsFormButton('', 'submit', _MA_XENT_CVGEN_FORM_NEXTSTEP, 'submit'));

$language->addElement($button_tray);
$language->assign($xoopsTpl);

include 'footer.php';
