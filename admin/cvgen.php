<?php

include 'admin_header.php';
require XOOPS_ROOT_PATH . '/header.php';

header('Content-type: text/xml');
header('Content-Disposition: attachment; filename="test.xml"');
$xoopsTpl->display('db:xent_cvgen_docexport.html');
