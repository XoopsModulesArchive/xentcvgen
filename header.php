<?php

include '../../mainfile.php';
require XOOPS_ROOT_PATH . '/header.php';
if (!is_object($xoopsUser)) {
    redirect_header(XOOPS_URL, 2, _MA_XENT_CVGEN_ACCESDENIED);
}

require_once 'include/functions.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
require_once XOOPS_ROOT_PATH . '/modules/xentgen/include/xent_gen_tables.php';
require_once XOOPS_ROOT_PATH . '/modules/xentgen/include/xentfunctions.php';
require_once XOOPS_ROOT_PATH . '/modules/xentgen/class/xent_expertise.php';
require_once XOOPS_ROOT_PATH . '/modules/xentgen/class/xent_techskill.php';
require_once XOOPS_ROOT_PATH . '/modules/xentgen/class/xent_users.php';
require_once XOOPS_ROOT_PATH . '/modules/xentcvgen/class/xent_cvgen.php';
require_once XOOPS_ROOT_PATH . '/modules/xentcvgen/class/xent_cvgen_edu.php';
require_once XOOPS_ROOT_PATH . '/modules/xentcvgen/class/xent_cvgen_xp.php';

$myts = MyTextSanitizer::getInstance();
