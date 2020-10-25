<?php

include 'header.php';

foreach ($_REQUEST as $a => $b) {
    $$a = $b;
}
$op = $_POST['op'] ?? $_GET['op'] ?? 'main';

global $xoopsDB, $xoopsConfig, $xoopsTpl, $xoopsUser, $myts;

if (isset($_POST['submit'])) {
    if (empty($_POST['language'])) {
        $language = $xoopsConfig['language'];
    }

    $user_id = $xoopsUser->getVar('uid');

    $xentCv->setUid($xoopsUser->getVar('uid'));

    $xentCv->setLanguage($language);

    $lastcv = $xentCv->getLastCv();

    $GLOBALS['xoopsOption']['template_main'] = 'xent_cvgen_form_step1.html';

    $xoopsTpl->assign('USERID', $user_id);

    $xoopsTpl->assign('USERNAME', $xoopsUser->getVar('name'));

    $lastcv['specialities'] = htmlspecialchars($lastcv['specialities'], ENT_QUOTES | ENT_HTML5);

    $cvgen = new XoopsThemeForm(_MA_XENT_CVGEN_FORM_STEP1, 'cvgen', 'step2.php');

    $cvgen->setExtra("enctype='multipart/form-data'"); //de xoops-doc

    $cvgen->addElement(new XoopsFormHidden('op', 'step1'));

    $cvgen->addElement(new XoopsFormHidden('back', '1'));

    $cvgen->addElement(new xoopsFormHidden('language', $language));

    $cvgen->addElement(new xoopsFormText('*' . _MA_XENT_CVGEN_SPECIALITIES, 'specialities', 64, 255, $lastcv['specialities']), true);

    $cvgen->addElement(new xoopsFormTextArea('*' . _MA_XENT_CVGEN_SOMMAIRE, 'summary', $lastcv['summary'], 10, 20), true);

    $cvgen->addElement(new xoopsFormLabel('<br><hr><br>', '<br><hr><br>'));

    $button_tray = new XoopsFormElementTray('', '');

    $button_tray->addElement(new XoopsFormButton('', 'submit', _MA_XENT_CVGEN_FORM_NEXTSTEP, 'submit'));

    $cvgen->addElement($button_tray);

    $cvgen->assign($xoopsTpl);
} else {
    $GLOBALS['xoopsOption']['template_main'] = 'xent_cvgen_form_start.html';

    ChooseLang('step1.php', 'step1');
}

include 'footer.php';
