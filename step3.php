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
    case 'delete':
        $xentCvEdu->deletebyeid($idcvedu);

        break;
    default:

        if (empty($_POST['edu_name'])) {
            $edu_name = '';
        } else {
            $edu_name = $_POST['edu_name'];
        }
        if (empty($_POST['city'])) {
            $city = '';
        } else {
            $city = $_POST['city'];
        }
        if (empty($_POST['institution'])) {
            $institution = '';
        } else {
            $institution = $_POST['institution'];
        }
        if (empty($_POST['country'])) {
            $country = '';
        } else {
            $country = $_POST['country'];
        }
        if (empty($_POST['idcvedu'])) {
            $idcvedu = '';
        } else {
            $idcvedu = $_POST['idcvedu'];
        }
        if (empty($_POST['date'])) {
            $date = '';
        } else {
            $date_start = $_POST['date'];
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

        $GLOBALS['xoopsOption']['template_main'] = 'xent_cvgen_form_step3.html';

        $xentCvEdu->setUid($xoopsUser->getVar('uid'));
        $xentCv->setUid($xoopsUser->getVar('uid'));
        $xentCvEdu->setLanguage($language);
        $xentCv->setLanguage($language);

        if ($xentCv->cvExistTest()) {
            //EXISTE

            $xentCvEdu->setIdCv($xentCv->getIdCv());

            $xentCvEdu->setIdCvEdu($idcvedu);

            $xentCvEdu->setEduName($edu_name);

            $xentCvEdu->setCity($city);

            $xentCvEdu->setInstitution($institution);

            $xentCvEdu->setCountry($country);

            //Recuperer la date:

            //$date2 = formatTimeStamp($jobposteddate, 'Y-m-d');

            //echo $date2;

            if ($date == !'') {
                $xentCvEdu->setDate(strtotime($date));
            }

            if ('1' == $save) {
                //echo "save=1";

                if ('' != $idcvedu) {
                    $xentCvEdu->update();
                } else {
                    //echo "AddForFirstTime";

                    $xentCvEdu->firstadd();
                }
            }

            $xentCv->BuiltCvHTML(1, 'cvedu');
        } else {
            redirect_header('index.php', 5, _MA_XENT_CVGEN_CVNOTEXIST);
        }

        break;
}

include 'footer.php';
