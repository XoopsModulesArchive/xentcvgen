<?php

include 'header.php';

$myts = MyTextSanitizer::getInstance();

$op = $_POST['op'] ?? $_GET['op'] ?? 'main';

if (empty($_POST['language'])) {
    $language = $xoopsConfig['language'];
} else {
    $language = $_POST['language'];
}

global $xoopsDB, $xoopsUser, $xoopsConfig;

switch ($op) {
    case 'step1':
        $GLOBALS['xoopsOption']['template_main'] = 'xent_cvgen_form_step2.html';
        if (empty($_POST['summary'])) {
            $summary = '';
        }
        if (empty($_POST['specialities'])) {
            $specialities = '';
        }
        if (empty($_POST['back'])) {
            $back = '0';
        }

        $date = date('Y-m-d');
        $xentCv->setUid($xoopsUser->getVar('uid'));
        $xentCv->setLanguage($language);
        $xentCv->setSummary($summary);
        $xentCv->setspecialities($specialities);

        $xentCv->setDateCreate(strtotime($date));
        $xentCv->setDateModif(strtotime($date));

        $xentCvXp->setUid($xoopsUser->getVar('uid'));
        $xentCvXp->setLanguage($xoopsConfig['language']);

        if ($xentCv->cvExistTest()) {
            //UPDATE

            //echo "1";

            //echo "test : ".$idcv = $xentCv->getIdCv();

            $xentCv->update();
        } else {
            //ADD

            //echo "2";

            $xentCv->add();
        }

        $xentCv->BuiltCvHTML(1, 'cvxp');
        /*	Step2Exec();
            $xentCvXp->ViewXpEditList();
            $xentCvXp->ShowXPAddForm();*/

        break;
    case 'delete':
        $xentCvXp->deletebyeid($idcvxp);

        break;
    default:

        if (empty($_POST['client_name'])) {
            $client_name = '';
        } else {
            $client_name = $_POST['client_name'];
        }
        if (empty($_POST['city'])) {
            $city = '';
        } else {
            $city = $_POST['city'];
        }
        if (empty($_POST['region'])) {
            $region = '';
        } else {
            $region = $_POST['region'];
        }
        if (empty($_POST['country'])) {
            $country = '';
        } else {
            $country = $_POST['country'];
        }
        if (empty($_POST['position'])) {
            $position = '';
        } else {
            $position = $_POST['position'];
        }
        if (empty($_POST['description'])) {
            $description = '';
        } else {
            $description = $_POST['description'];
        }
        if (empty($_POST['idcvxp'])) {
            $idcvxp = '';
        } else {
            $idcvxp = $_POST['idcvxp'];
        }
        if (empty($_POST['date_start'])) {
            $date_start = '';
        } else {
            $date_start = $_POST['date_start'];
        }
        if (empty($_POST['date_end'])) {
            $date_end = '';
        } else {
            $date_end = $_POST['date_end'];
        }
        if (empty($_POST['save'])) {
            //echo $_POST['save'];

            $save = '0';
        } else {
            $save = $_POST['save'];
        }
        if (empty($_POST['edit'])) {
            //echo $_POST['save'];

            $edit = '0';
        } else {
            $edit = $_POST['edit'];
        }

        $GLOBALS['xoopsOption']['template_main'] = 'xent_cvgen_form_step2.html';

        $xentCvXp->setUid($xoopsUser->getVar('uid'));
        $xentCv->setUid($xoopsUser->getVar('uid'));
        $xentCvXp->setLanguage($language);
        $xentCv->setLanguage($language);

        if ($xentCv->cvExistTest()) {
            //EXISTE

            $xentCvXp->setIdCv($xentCv->getIdCv());

            $xentCvXp->setIdCvXp($idcvxp);

            $xentCvXp->setClientName($client_name);

            $xentCvXp->setCity($city);

            $xentCvXp->setRegion($region);

            $xentCvXp->setCountry($country);

            $xentCvXp->setPosition($position);

            $xentCvXp->setDescription($description);

            //Recuperer la date:

            //$date2 = formatTimeStamp($jobposteddate, 'Y-m-d');

            //echo $date2;

            if ($date_start == !'') {
                $xentCvXp->setDateStart(strtotime($date_start));
            }

            if ($date_end == !'') {
                $xentCvXp->setDateEnd(strtotime($date_end));
            }

            //echo $save;

            if ('1' == $save) {
                //echo "test";

                if ('' != $idcvxp) {
                    $xentCvXp->update();
                } else {
                    $xentCvXp->firstadd();
                }
            }

            //echo $idcvxp;

            //Step2Exec($idcvxp);

            $xentCv->BuiltCvHTML(1, 'cvxp');
        } else {
            redirect_header('index.php', 5, _MA_XENT_CVGEN_CVNOTEXIST);
        }
        //$GLOBALS['xoopsOption']['template_main'] = 'xent_cvgen_form_start.html';
        //ChooseLang("step2.php", "step2");

        break;
}

include 'footer.php';
