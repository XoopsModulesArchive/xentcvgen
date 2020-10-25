<?php
// ------------------------------------------------------------------------- //
//                  Module xEntCvGen pour Xoops 2.0.9   	                 //
//                              Version:  1.0                                //
// ------------------------------------------------------------------------- //
// Author: M4d3L	                                       				     //
// Purpose: Give user the posibility to fill his CV on your website		     //
// email: xentproject@site3web.net                                           //
// URLs: http://www.xoops-quebec.net										 //
//---------------------------------------------------------------------------//

$modversion['name'] = _MI_XENT_CVGEN_NAME;
$modversion['version'] = '1.0.1';
$modversion['description'] = _MI_XENT_CVGEN_DESC;
$modversion['credits'] = 'ODESIA Solutions inc, Marcan, Outch, Milhouse';
$modversion['author'] = 'Ecrit pour Xoops2<br>par Mathieu Delisle (M4d3L)';
$modversion['license'] = '';
$modversion['official'] = 1;
$modversion['image'] = 'images/xent_cvgen_logo.png';
$modversion['help'] = '';
$modversion['dirname'] = 'xentcvgen';

// MYSQL FILE
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';

// Tables created by sql file
//If you hack this modules, dont change the order of the table.
//All
$modversion['tables'][0] = 'xent_cvgen';
$modversion['tables'][1] = 'xent_cvgen_lang';
$modversion['tables'][2] = 'xent_cvgen_edu';
$modversion['tables'][3] = 'xent_cvgen_edu_lang';
$modversion['tables'][4] = 'xent_cvgen_xp';
$modversion['tables'][5] = 'xent_cvgen_xp_lang';

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['hasMain'] = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu'] = 'admin/menu.php';

//Themeplates
$modversion['templates'][1]['file'] = 'xent_cvgen_docexport.html';
$modversion['templates'][1]['description'] = '';
$modversion['templates'][2]['file'] = 'xent_cvgen_form_start.html';
$modversion['templates'][2]['description'] = '';
$modversion['templates'][3]['file'] = 'xent_cvgen_form_step1.html';
$modversion['templates'][3]['description'] = '';
$modversion['templates'][4]['file'] = 'xent_cvgen_form_step2.html';
$modversion['templates'][4]['description'] = '';
$modversion['templates'][5]['file'] = 'xent_cvgen_form_step3.html';
$modversion['templates'][5]['description'] = '';
$modversion['templates'][6]['file'] = 'xent_cvgen_form_step4.html';
$modversion['templates'][6]['description'] = '';
$modversion['templates'][7]['file'] = 'xent_cvgen_form_view.html';
$modversion['templates'][7]['description'] = '';
$modversion['templates'][8]['file'] = 'xent_cvgen_form_exporthtml.html';
$modversion['templates'][8]['description'] = '';
$modversion['templates'][9]['file'] = 'xent_cvgen_exportprint.html';
$modversion['templates'][9]['description'] = '';

//Configs
$modversion['config'][1]['name'] = 'page_header';
$modversion['config'][1]['title'] = '_MI_XENT_CVGEN_CONFIG_HEADER';
$modversion['config'][1]['description'] = '_MI_XENT_CVGEN_CONFIG_HEADERDESC';
$modversion['config'][1]['formtype'] = 'textarea';
$modversion['config'][1]['valuetype'] = 'text';
$modversion['config'][1]['default'] = '';

$modversion['config'][2]['name'] = 'page_footer';
$modversion['config'][2]['title'] = '_MI_XENT_CVGEN_CONFIG_FOOTER';
$modversion['config'][2]['description'] = '_MI_XENT_CVGEN_CONFIG_FOOTERDESC';
$modversion['config'][2]['formtype'] = 'textarea';
$modversion['config'][2]['valuetype'] = 'text';
$modversion['config'][2]['default'] = '';

$modversion['config'][3]['name'] = 'logo';
$modversion['config'][3]['title'] = '_MI_XENT_CVGEN_CONFIG_LOGO';
$modversion['config'][3]['description'] = '_MI_XENT_CVGEN_CONFIG_LOGODESC';
$modversion['config'][3]['formtype'] = 'textbox';
$modversion['config'][3]['valuetype'] = 'text';
$modversion['config'][3]['default'] = '';

$modversion['config'][4]['name'] = 'requiere';
$modversion['config'][4]['title'] = '_MI_XENT_CVGEN_CONFIG_REQUIERE';
$modversion['config'][4]['description'] = '_MI_XENT_CVGEN_CONF_REQUIEREDESC';
$modversion['config'][4]['formtype'] = 'textbox';
$modversion['config'][4]['valuetype'] = 'text';
$modversion['config'][4]['default'] = '*';

$modversion['config'][5]['name'] = 'formatdate_education';
$modversion['config'][5]['title'] = '_MI_XENT_CVGEN_CONFIG_FOOTER';
$modversion['config'][5]['description'] = '_MI_XENT_CVGEN_CONFIG_FOOTERDESC';
$modversion['config'][5]['formtype'] = 'textarea';
$modversion['config'][5]['valuetype'] = 'text';
$modversion['config'][5]['default'] = '';

$modversion['config'][6]['name'] = 'formatdate_experience';
$modversion['config'][6]['title'] = '_MI_XENT_CVGEN_CONFIG_FOOTER';
$modversion['config'][6]['description'] = '_MI_XENT_CVGEN_CONFIG_FOOTERDESC';
$modversion['config'][6]['formtype'] = 'textarea';
$modversion['config'][6]['valuetype'] = 'text';
$modversion['config'][6]['default'] = '';
