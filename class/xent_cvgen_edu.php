<?php

require_once XOOPS_ROOT_PATH . '/modules/xentgen/include/xent_gen_tables.php';

$xentCvEdu = new XentCvEdu();

class XentCvEdu extends XoopsObject
{
    public $_extendedInfo = null;

    public $db;

    public $idcv;

    public $idcvEdu;

    public $uid;

    public $date;

    public $edu_name;

    public $institution;

    public $city;

    public $country;

    public $language;

    public $defaultlang = 0;

    public $myts;

    public function __construct()
    {
        $this->db = XoopsDatabaseFactory::getDatabaseConnection();

        $this->myts = MyTextSanitizer::getInstance();
    }

    // setters

    public function setIdCv($idcv)
    {
        $this->idcv = $idcv;
    }

    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    public function setIdCvEdu($idcvedu)
    {
        $this->idcvedu = $idcvedu;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function setEduName($edu_name)
    {
        $edu_name = $this->myts->addSlashes($edu_name);

        $this->edu_name = $edu_name;
    }

    public function setCity($city)
    {
        $city = $this->myts->addSlashes($city);

        $this->city = $city;
    }

    public function setInstitution($institution)
    {
        $institution = $this->myts->addSlashes($institution);

        $this->institution = $institution;
    }

    public function setCountry($country)
    {
        $country = $this->myts->addSlashes($country);

        $this->country = $country;
    }

    public function setLanguage($language)
    {
        $this->language = $language;
    }

    public function setDefaultLang($defaultlang)
    {
        $this->defaultlang = $defaultlang;
    }

    // getters

    public function getIdCv()
    {
        return $this->idcv;
    }

    public function getUid()
    {
        return $this->uid;
    }

    public function getIdCvEdu()
    {
        return $this->idcvedu;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getEduName()
    {
        return $this->edu_name;
    }

    public function getInstitution()
    {
        return $this->institution;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function getDefaultLang()
    {
        return $this->defaultlang;
    }

    public function firstadd()
    {
        $sql1 = 'INSERT INTO ' . $this->db->prefix(XENT_DB_XENT_CVGEN_EDU) . " (
		ID_CVGEN, 
		uid,
		date
		) VALUES('" . $this->getIdCv() . "', '" . $this->getUid() . "', '" . $this->getDate() . "'); ";

        $this->db->query($sql1);

        //echo "<br>".$sql1."<br>";

        //echo $sql1;

        $sql2 = 'INSERT INTO ' . $this->db->prefix(XENT_DB_XENT_CVGEN_EDU_LANG) . " (
		ID_CVEDU, 
		languageid, 
		defaultlang, 
		edu_name, 
		city, 
		institution, 
		country  
		) VALUES('" . $this->db->getInsertId() . "', '" . $this->getLanguage() . "', '" . "1', '" . $this->getEduName() . "', '" . $this->getCity() . "', '" . $this->getInstitution() . "', '" . $this->getCountry() . "')";

        $this->db->query($sql2);

        //echo "<br>".$sql2."<br>";

        //echo $sql2;

        if (0 == $this->db->errno()) {
            //redirect_header("adminjobs.php",1,_AM_DBUPDATED);
        }  

        //redirect_header("adminjobs.php",10,$this->db->error());
    }

    public function selectCvEdu()
    {
        //Take an entry to edit

        if ($this->getIdCvEdu() == !'') {
            $sql = "SELECT distinct
	t1.ID_CVEDU, 
	t1.ID_CVGEN,
	t1.Uid,
	t1.date,
	case t2_eng.languageid when '" . $this->getLanguage() . "' then t2_eng.languageid else t2_def.languageid end as LanguageID,
	case t2_eng.languageid when '" . $this->getLanguage() . "' then t2_eng.edu_name else t2_def.edu_name end as edu_name,
	case t2_eng.languageid when '" . $this->getLanguage() . "' then t2_eng.city else t2_def.city end as city,
	case t2_eng.languageid when '" . $this->getLanguage() . "' then t2_eng.institution else t2_def.institution end as institution,
	case t2_eng.languageid when '" . $this->getLanguage() . "' then t2_eng.country else t2_def.country end as country 
FROM " . $this->db->prefix(XENT_DB_XENT_CVGEN_EDU) . ' AS t1
  left outer join ' . $this->db->prefix(XENT_DB_XENT_CVGEN_EDU_LANG) . " AS t2_eng
   	on t1.ID_CVEDU=t2_eng.ID_CVEDU and t2_eng.languageid='" . $this->getLanguage() . "'
  left outer join " . $this->db->prefix(XENT_DB_XENT_CVGEN_EDU_LANG) . " AS t2_def
   	on t1.ID_CVEDU=t2_def.ID_CVEDU and t2_def.defaultlang='1'
WHERE t1.ID_CVEDU='" . $this->getIdCvEdu() . "'";

            //$sql = "SELECT * FROM ".$this->db->prefix(XENT_DB_XENT_CVGEN_EDU)." AS t1, ".$this->db->prefix(XENT_DB_XENT_CVGEN_EDU_LANG)." AS t2 WHERE t1.ID_CVXP=".$this->getIdCvXp()." AND t1.ID_CVXP=t2.ID_CVXP AND t2.languageid='".$this->getLanguage()."'";

            $result = $this->db->query($sql);

            $selectcvedu = $this->db->fetchArray($result);

            //echo $sql;

            return $selectcvedu;
        }
    }

    public function deletebyeid($id)
    {
        //Delete cv from principal table

        $sql = 'DELETE FROM ' . $this->db->prefix(XENT_DB_XENT_CVGEN_EDU) . " WHERE ID_CVEDU=$id";

        $this->db->queryF($sql);

        //Delete all entry in cvgen_edu

        $sql = 'DELETE FROM ' . $this->db->prefix(XENT_DB_XENT_CVGEN_EDU_LANG) . " WHERE ID_CVEDU=$id";

        $this->db->queryF($sql);

        if (0 == $this->db->errno()) {
            redirect_header('step3.php', 0, _AM_DBUPDATED);
        } else {
            redirect_header('step3.php', 4, $this->db->error());
        }
    }

    public function update()
    {
        //echo "<br>CV_UPDATE<br>";

        $sql = 'SELECT * FROM ' . $this->db->prefix(XENT_DB_XENT_CVGEN_EDU) . ' AS t1, ' . $this->db->prefix(XENT_DB_XENT_CVGEN_EDU_LANG) . ' AS t2 WHERE t1.ID_CVEDU=' . $this->getIdCvEdu() . " AND t1.ID_CVEDU=t2.ID_CVEDU AND t2.languageid='" . $this->getLanguage() . "'";

        $result = $this->db->queryF($sql);

        $checkforupdate = $this->db->fetchArray($result);

        if ('' == $checkforupdate) {
            //ADD ENTRY IF NOT EXIST

            $update_sql1 = 'UPDATE ' . $this->db->prefix(XENT_DB_XENT_CVGEN_EDU) . " SET
					date='" . $this->getDate() . "' 
					WHERE ID_CVEDU='" . $this->getIdCvEdu() . "'";

            $this->db->queryF($update_sql1);

            $update_sql = 'INSERT INTO ' . $this->db->prefix(XENT_DB_XENT_CVGEN_EDU_LANG) . " (
					ID_CVEDU, 
					languageid, 
					defaultlang, 
					edu_name, 
					city, 
					institution, 
					country 
					) VALUES('" . $this->getIdCvEdu() . "', '" . $this->getLanguage() . "', '" . "0', '" . $this->getEduName() . "', '" . $this->getCity() . "', '" . $this->getInstitution() . "', '" . $this->getCountry() . "')";

            $this->db->query($update_sql);

            echo '<br>' . $update_sql . '<br>';

            if (0 == $this->db->errno()) {
                //redirect_header("adminjobs.php",1,_AM_DBUPDATED);
            }  

            //redirect_header("adminjobs.php",10,$this->db->error());
        } else {
            //UDATE ENTRY IF AlREADY EXIST

            //echo $this->getDate();

            $update_sql1 = 'UPDATE ' . $this->db->prefix(XENT_DB_XENT_CVGEN_EDU) . " SET
					date='" . $this->getDate() . "' 
					WHERE ID_CVEDU='" . $this->getIdCvEdu() . "'";

            $this->db->queryF($update_sql1);

            $update_sql2 = 'UPDATE ' . $this->db->prefix(XENT_DB_XENT_CVGEN_EDU_LANG) . " SET
					edu_name='" . $this->getEduName() . "',
					city='" . $this->getCity() . "',
					institution='" . $this->getInstitution() . "',
					country='" . $this->getCountry() . "' 
					WHERE ID_CVEDU=" . $this->getIdCvEdu() . " AND languageid='" . $this->getLanguage() . "'";

            $this->db->queryF($update_sql2);

            /*echo "<br>";
            echo $update_sql1;
            echo "<br>";
            echo $this->getDate();
            echo "<br>";
            echo formatTimeStamp($this->getDate(), 'Y-m');
            echo "<br>";*/

            //echo $sql2;

            if (0 == $this->db->errno()) {
                //redirect_header("adminjobs.php",1,_AM_DBUPDATED);
            }  

            //redirect_header("adminjobs.php",4,$this->db->error());
        }

        //echo $sql;

        if (0 == $this->db->errno()) {
            //redirect_header("adminjobs.php",1,_AM_DBUPDATED);
        }  

        //redirect_header("adminjobs.php",4,$this->db->error());
    }

    public function getAllCvEdu()
    {
        //Return at least one entry for each Education based on current language else defaultlang.

        $sql = "SELECT distinct
	t1.ID_CVEDU, 
	t1.ID_CVGEN,
	t1.Uid,
	t1.date,
	case t2_eng.languageid when '" . $this->getLanguage() . "' then t2_eng.languageid else t2_def.languageid end as LanguageID,
	case t2_eng.languageid when '" . $this->getLanguage() . "' then t2_eng.edu_name else t2_def.edu_name end as edu_name,
	case t2_eng.languageid when '" . $this->getLanguage() . "' then t2_eng.city else t2_def.city end as city,
	case t2_eng.languageid when '" . $this->getLanguage() . "' then t2_eng.institution else t2_def.institution end as institution,
	case t2_eng.languageid when '" . $this->getLanguage() . "' then t2_eng.country else t2_def.country end as country 
FROM " . $this->db->prefix(XENT_DB_XENT_CVGEN_EDU) . ' AS t1
  left outer join ' . $this->db->prefix(XENT_DB_XENT_CVGEN_EDU_LANG) . " AS t2_eng
   	on t1.ID_CVEDU=t2_eng.ID_CVEDU and t2_eng.languageid='" . $this->getLanguage() . "'
  left outer join " . $this->db->prefix(XENT_DB_XENT_CVGEN_EDU_LANG) . " AS t2_def
   	on t1.ID_CVEDU=t2_def.ID_CVEDU and t2_def.defaultlang='1'
WHERE uid='" . $this->getUid() . "' ORDER BY date DESC";

        //echo $sql;

        $result = $this->db->query($sql);

        //$lastcvxp = $this->db->fetchArray($result);

        //print_r ($lastcvxp);

        //echo $sql;

        return $result;
    }

    public function ViewList()
    {
        global $xoopsDB, $xoopsTpl;

        $result = $this->getAllCvEdu();

        //Send list to templates

        while (false !== ($allcv_array = $xoopsDB->fetchArray($result))) {
            //print_r($allcv_array);

            $allcv_array['date'] = formatTimestamp($allcv_array['date'], 'Y-m');

            //$allcv_array['editform'] = $cvedu_editform->render();

            $xoopsTpl->append('listcvedu', $allcv_array);
        }
    }

    public function ViewEditList()
    {
        global $xoopsDB, $xoopsTpl;

        $result = $this->getAllCvEdu();

        //Send list to templates

        while (false !== ($allcv_array = $xoopsDB->fetchArray($result))) {
            //print_r($allcv_array);

            //Choose lang to edit form

            $cvedu_editform = new XoopsThemeForm('', 'editform_' . $allcv_array['ID_CVEDU'], 'step3.php#step3form');

            $cvedu_editform->setExtra("enctype='multipart/form-data'");

            $language = new XoopsFormSelectLang('', 'language', $allcv_array['LanguageID']);

            $edit = new XoopsFormButton('', 'edit', _MA_XENT_CVGEN_FORM_EDIT, 'submit');

            $edit->setExtra("onmouseover='document.editform_" . $allcv_array['ID_CVEDU'] . ".op.value=\"\"'");

            $delete = new xoopsFormButton('', 'edit', _MA_XENT_CVGEN_FORM_DELETE, 'submit');

            $delete->setExtra("onmouseover='document.editform_" . $allcv_array['ID_CVEDU'] . ".op.value=\"delete\"'");

            $options = new XoopsFormElementTray('', '');

            //$options->addElement($language);

            $options->addElement($edit);

            $options->addElement($delete);

            $cvedu_editform->addElement($language);

            $cvedu_editform->addElement($options);

            $cvedu_editform->addElement(new XoopsFormHidden('idcvedu', $allcv_array['ID_CVEDU']));

            $cvedu_editform->addElement(new XoopsFormHidden('op', ''));

            //$cvxp_editform->addElement(new XoopsFormHidden("edit", "1"));

            //Add info the the array

            $allcv_array['date'] = formatTimestamp($allcv_array['date'], 'Y-m');

            $allcv_array['editform'] = $cvedu_editform->render();

            $xoopsTpl->append('listcvedu', $allcv_array);
        }
    }

    public function ShowAddForm()
    {
        global $xoopsDB, $xoopsTpl, $xoopsModuleConfig, $back, $edit, $myts;

        $selectcvedu = $this->selectCvEdu();

        //$idcvxp = $selectcvxp['ID_CVXP'];

        //print_r($selectcvxp);

        //ADD/EDIT EDUCATION FORM

        $cvgenedu = new XoopsThemeForm(_MA_XENT_CVGEN_FORM_STEP3, 'cvgenedu', 'step3.php');

        $cvgenedu->setExtra("enctype='multipart/form-data'");

        $cvgenedu->addElement(new XoopsFormHidden('op', ''));

        if ('' != $selectcvedu['ID_CVEDU']) {
            $cvgenedu->addElement(new XoopsFormHidden('idcvedu', $selectcvedu['ID_CVEDU']));
        }

        $cvgenedu->addElement(new XoopsFormHidden('save', '1'));

        $cvgenedu->addElement(new XoopsFormSelectLang(_MA_XENT_CVGEN_FORM_LANG, 'language', $this->getLanguage()));

        $cvgenedu->addElement(new xoopsFormText($xoopsModuleConfig['requiere'] . _MA_XENT_CVGEN_EDUNAME, 'edu_name', 64, 255, $myts->displayTarea($selectcvedu['edu_name'])), true);

        $cvgenedu->addElement(new xoopsFormText($xoopsModuleConfig['requiere'] . _MA_XENT_CVGEN_CITY, 'city', 64, 255, $myts->displayTarea(htmlspecialchars($selectcvedu['city'], ENT_QUOTES | ENT_HTML5))), true);

        $cvgenedu->addElement(new xoopsFormText($xoopsModuleConfig['requiere'] . _MA_XENT_CVGEN_INSTITUTION, 'institution', 64, 255, $myts->displayTarea($selectcvedu['institution'])), true);

        $cvgenedu->addElement(new xoopsFormText($xoopsModuleConfig['requiere'] . _MA_XENT_CVGEN_COUNTRY, 'country', 64, 255, $myts->displayTarea($selectcvedu['country'])), true);

        $cvgenedu->addElement(new XoopsFormTextDateSelect(_MA_XENT_CVGEN_DATE, 'date', $size = 15, $value = $selectcvedu['date']));

        $editbutton = new XoopsFormButton('', 'edit', _MA_XENT_CVGEN_FORM_SAVE, 'submit');

        $editbutton->setExtra("onmouseover='document.cvgenedu.op.value=\"\"; document.cvgenedu.action=\"step3.php\"; document.cvgenedu.idcvedu.value=\"" . $selectcvedu['ID_CVEDU'] . "\"'");

        $laststep = new XoopsFormButton('', 'laststep', _MA_XENT_CVGEN_FORM_LASTSTEP, 'button');

        $laststep->setExtra("onclick='history.back()'");

        $addmore = new XoopsFormButton('', 'addmore', _MA_XENT_CVGEN_FORM_ADDMORE, 'submit');

        $addmore->setExtra("onmouseover='document.cvgenedu.op.value=\"\"; document.cvgenedu.action=\"step3.php\"; document.cvgenedu.idcvedu.value=\"\"'");

        $nextstep = new XoopsFormButton('', 'nextstep', _MA_XENT_CVGEN_FORM_NEXTSTEP, 'submit');

        $nextstep->setExtra("onmouseover='onmouseover='document.cvgenedu.op.value=\"\"; document.cvgenedu.action=\"step3.php\"; document.cvgenedu.idcvedu.value=\"\"'");

        $button_tray = new XoopsFormElementTray('', '');

        if (1 == $back) {
            $button_tray->addElement($laststep);
        }

        if ('' != $selectcvedu['ID_CVEDU']) {
            $button_tray->addElement($editbutton);
        }

        $button_tray->addElement($addmore);

        //	$button_tray->addElement($nextstep);

        $cvgenedu->addElement($button_tray);

        //$button_tray = new XoopsFormElementTray('' ,'');

        //$button_tray->addElement(new XoopsFormButton('', 'submit', _MA_XENT_CVGEN_NEXTSTEP, 'submit'));

        //$cvgen->addElement($button_tray);

        $cvgenedu->assign($xoopsTpl);
    }
}
