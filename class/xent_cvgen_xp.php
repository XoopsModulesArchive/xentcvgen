<?php

require_once XOOPS_ROOT_PATH . '/modules/xentgen/include/xent_gen_tables.php';

$xentCvXp = new XentCvXp();

class XentCvXp extends XoopsObject
{
    public $_extendedInfo = null;

    public $db;

    public $idcv;

    public $idcvxp;

    public $uid;

    public $date_start;

    public $date_end;

    public $client_name;

    public $region;

    public $city;

    public $country;

    public $position;

    public $description;

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

    public function setIdCvXp($idcvxp)
    {
        $this->idcvxp = $idcvxp;
    }

    public function setDateStart($date_start)
    {
        $this->date_start = $date_start;
    }

    public function setDateEnd($date_end)
    {
        $this->date_end = $date_end;
    }

    public function setClientName($client_name)
    {
        $client_name = $this->myts->addSlashes($client_name);

        $this->client_name = $client_name;
    }

    public function setCity($city)
    {
        $city = $this->myts->addSlashes($city);

        $this->city = $city;
    }

    public function setRegion($region)
    {
        $region = $this->myts->addSlashes($region);

        $this->region = $region;
    }

    public function setCountry($country)
    {
        $country = $this->myts->addSlashes($country);

        $this->country = $country;
    }

    public function setPosition($position)
    {
        $position = $this->myts->addSlashes($position);

        $this->position = $position;
    }

    public function setDescription($description)
    {
        $description = $this->myts->addSlashes($description);

        $this->description = $description;
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

    public function getIdCvXp()
    {
        return $this->idcvxp;
    }

    public function getDateStart()
    {
        return $this->date_start;
    }

    public function getDateEnd()
    {
        return $this->date_end;
    }

    public function getClientName()
    {
        return $this->client_name;
    }

    public function getRegion()
    {
        return $this->region;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function getDescription()
    {
        return $this->description;
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
        $sql1 = 'INSERT INTO ' . $this->db->prefix(XENT_DB_XENT_CVGEN_XP) . " (
		ID_CVGEN, 
		uid,
		date_start,
		date_end
		) VALUES('" . $this->getIdCv() . "', '" . $this->getUid() . "', '" . $this->getDateStart() . "', '" . $this->getDateEnd() . "'); ";

        $this->db->query($sql1);

        //echo "<br>".$sql1."<br>";

        $sql2 = 'INSERT INTO ' . $this->db->prefix(XENT_DB_XENT_CVGEN_XP_LANG) . " (
		ID_CVXP, 
		languageid, 
		defaultlang, 
		client_name, 
		city, 
		region, 
		country, 
		position, 
		description
		) VALUES('" . $this->db->getInsertId() . "', '" . $this->getLanguage() . "', '" . "1', '" . $this->getClientName() . "', '" . $this->getCity() . "', '" . $this->getRegion() . "', '" . $this->getCountry() . "', '" . $this->getPosition() . "', '" . $this->getDescription() . "')";

        $this->db->query($sql2);

        //echo "<br>".$sql2."<br>";

        if (0 == $this->db->errno()) {
            //redirect_header("adminjobs.php",1,_AM_DBUPDATED);
        } else {
            redirect_header('step2.php', 10, $this->db->error());
        }
    }

    public function selectCvXp()
    {
        //Take an entry to edit

        if ($this->getIdCvXp() == !'') {
            $sql = "SELECT distinct
	t1.ID_CVXP, 
	t1.ID_CVGEN,
	t1.Uid,
	t1.date_start,
	t1.date_end,
	case t2_eng.languageid when '" . $this->getLanguage() . "' then t2_eng.languageid else t2_def.languageid end as LanguageID,
	case t2_eng.languageid when '" . $this->getLanguage() . "' then t2_eng.client_name else t2_def.client_name end as client_name,
	case t2_eng.languageid when '" . $this->getLanguage() . "' then t2_eng.city else t2_def.city end as city,
	case t2_eng.languageid when '" . $this->getLanguage() . "' then t2_eng.region else t2_def.region end as region,
	case t2_eng.languageid when '" . $this->getLanguage() . "' then t2_eng.country else t2_def.country end as country,
	case t2_eng.languageid when '" . $this->getLanguage() . "' then t2_eng.position else t2_def.position end as position,
	case t2_eng.languageid when '" . $this->getLanguage() . "' then t2_eng.description else t2_def.description end as description
FROM " . $this->db->prefix(XENT_DB_XENT_CVGEN_XP) . ' AS t1
  left outer join ' . $this->db->prefix(XENT_DB_XENT_CVGEN_XP_LANG) . " AS t2_eng
   	on t1.ID_CVXP=t2_eng.ID_CVXP and t2_eng.languageid='" . $this->getLanguage() . "'
  left outer join " . $this->db->prefix(XENT_DB_XENT_CVGEN_XP_LANG) . " AS t2_def
   	on t1.ID_CVXP=t2_def.ID_CVXP and t2_def.defaultlang='1'
WHERE t1.ID_CVXP='" . $this->getIdCvXp() . "'";

            echo $sql;

            //$sql = "SELECT * FROM ".$this->db->prefix(XENT_DB_XENT_CVGEN_XP)." AS t1, ".$this->db->prefix(XENT_DB_XENT_CVGEN_XP_LANG)." AS t2 WHERE t1.ID_CVXP=".$this->getIdCvXp()." AND t1.ID_CVXP=t2.ID_CVXP AND t2.languageid='".$this->getLanguage()."'";

            $result = $this->db->query($sql);

            $selectcvxp = $this->db->fetchArray($result);

            //echo $sql;

            return $selectcvxp;
        }
    }

    public function deletebyeid($id)
    {
        //Delete cv from principal table

        $sql = 'DELETE FROM ' . $this->db->prefix(XENT_DB_XENT_CVGEN_XP) . " WHERE ID_CVXP=$id";

        $this->db->queryF($sql);

        //Delete all entry in cvgen_xp

        $sql = 'DELETE FROM ' . $this->db->prefix(XENT_DB_XENT_CVGEN_XP_LANG) . " WHERE ID_CVXP=$id";

        $this->db->queryF($sql);

        if (0 == $this->db->errno()) {
            redirect_header('step2.php', 0, _AM_DBUPDATED);
        } else {
            redirect_header('step2.php', 4, $this->db->error());
        }
    }

    /*	function getAllCv(){
    $sql = "SELECT * FROM ".$this->db->prefix(XENT_DB_XENT_CVGEN)." ORDER BY specialities";
    $result = $this->db->query($sql);

    return $result;
    }*/

    /*	function getLastCvXp(){
    //$sql = "SELECT * FROM ".$this->db->prefix(XENT_DB_XENT_CVGEN)." WHERE uid=".$this->getUid()." AND language='".$this->getLanguage()."'";
    $sql = "SELECT * FROM ".$this->db->prefix(XENT_DB_XENT_CVGEN)." AS t1, ".$this->db->prefix(XENT_DB_XENT_CVGEN_LANG)." AS t2 WHERE uid=".$this->getUid()." AND t1.ID_CVGEN=t2.ID_CVGEN AND t2.languageid='".$this->getLanguage()."'";
    $result = $this->db->query($sql);
    $lastcv = $this->db->fetchArray($result);
    //echo $sql;
    return $lastcvxp;
    }*/

    /*	function getCv($id){
    $sql = "SELECT * FROM ".$this->db->prefix(XENT_DB_XENT_CVGEN)." WHERE ID_CVEDU=$id";
    $result = $this->db->query($sql);
    $job = $this->db->fetchArray($result);

    return $job;
    }*/

    public function update()
    {
        //echo "<br>CV_UPDATE<br>";

        $sql = 'SELECT * FROM ' . $this->db->prefix(XENT_DB_XENT_CVGEN_XP) . ' AS t1, ' . $this->db->prefix(XENT_DB_XENT_CVGEN_XP_LANG) . ' AS t2 WHERE t1.ID_CVXP=' . $this->getIdCvXp() . " AND t1.ID_CVXP=t2.ID_CVXP AND t2.languageid='" . $this->getLanguage() . "'";

        $result = $this->db->queryF($sql);

        $checkforupdate = $this->db->fetchArray($result);

        if ('' == $checkforupdate) {
            //ADD ENTRY IF NOT EXIST

            $update_sql1 = 'UPDATE ' . $this->db->prefix(XENT_DB_XENT_CVGEN_XP) . " SET
					date_start='" . $this->getDateStart() . "',
					date_end='" . $this->getDateEnd() . "' 
					WHERE ID_CVXP=" . $this->getIdCvXp();

            $this->db->queryF($update_sql1);

            $update_sql = 'INSERT INTO ' . $this->db->prefix(XENT_DB_XENT_CVGEN_XP_LANG) . " (
					ID_CVXP, 
					languageid, 
					defaultlang, 
					client_name, 
					city, 
					region, 
					country, 
					position, 
					description
					) VALUES('" . $this->getIdCvXp() . "', '" . $this->getLanguage() . "', '" . "0', '" . $this->getClientName() . "', '" . $this->getCity() . "', '" . $this->getRegion() . "', '" . $this->getCountry() . "', '" . $this->getPosition() . "', '" . $this->getDescription() . "')";

            $this->db->query($update_sql);

            //echo "<br>".$sql2."<br>";

            if (0 == $this->db->errno()) {
                //redirect_header("adminjobs.php",1,_AM_DBUPDATED);
            } else {
                redirect_header('step2.php', 10, $this->db->error());
            }
        } else {
            //UDATE ENTRY IF AlREADY EXIST

            $update_sql1 = 'UPDATE ' . $this->db->prefix(XENT_DB_XENT_CVGEN_XP) . " SET
					date_start='" . $this->getDateStart() . "',
					date_end='" . $this->getDateEnd() . "' 
					WHERE ID_CVXP=" . $this->getIdCvXp();

            $this->db->queryF($update_sql1);

            $update_sql2 = 'UPDATE ' . $this->db->prefix(XENT_DB_XENT_CVGEN_XP_LANG) . " SET
					client_name='" . $this->getClientName() . "',
					city='" . $this->getCity() . "',
					region='" . $this->getRegion() . "',
					country='" . $this->getCountry() . "',
					position='" . $this->getPosition() . "', 
					description='" . $this->getDescription() . "' 
					WHERE ID_CVXP=" . $this->getIdCvXp() . " AND languageid='" . $this->getLanguage() . "'";

            $this->db->queryF($update_sql2);

            //echo $sql2;

            if (0 == $this->db->errno()) {
                //redirect_header("adminjobs.php",1,_AM_DBUPDATED);
            } else {
                echo 'Erreur SQL! Voila votre requete : <br><br>' . $update_sql1 . '<br><br>' . $update_sql2 . '<br>';
            }
        }

        //echo $sql;

        if (0 == $this->db->errno()) {
            //redirect_header("adminjobs.php",1,_AM_DBUPDATED);
        }  

        //redirect_header("adminjobs.php",4,$this->db->error());
    }

    public function getAllCvXP()
    {
        //Return at least one entry for each Experience based on current language else defaultlang.

        $sql = "SELECT distinct
				t1.ID_CVXP, 
				t1.ID_CVGEN,
				t1.Uid,
				t1.date_start,
				t1.date_end,
				case t2_eng.languageid when '" . $this->getLanguage() . "' then t2_eng.languageid else t2_def.languageid end as LanguageID,
				case t2_eng.languageid when '" . $this->getLanguage() . "' then t2_eng.client_name else t2_def.client_name end as client_name,
				case t2_eng.languageid when '" . $this->getLanguage() . "' then t2_eng.city else t2_def.city end as city,
				case t2_eng.languageid when '" . $this->getLanguage() . "' then t2_eng.region else t2_def.region end as region,
				case t2_eng.languageid when '" . $this->getLanguage() . "' then t2_eng.country else t2_def.country end as country,
				case t2_eng.languageid when '" . $this->getLanguage() . "' then t2_eng.position else t2_def.position end as position,
				case t2_eng.languageid when '" . $this->getLanguage() . "' then t2_eng.description else t2_def.description end as description
			FROM " . $this->db->prefix(XENT_DB_XENT_CVGEN_XP) . ' AS t1
 			 left outer join ' . $this->db->prefix(XENT_DB_XENT_CVGEN_XP_LANG) . " AS t2_eng
 			  	on t1.ID_CVXP=t2_eng.ID_CVXP and t2_eng.languageid='" . $this->getLanguage() . "'
 			 left outer join " . $this->db->prefix(XENT_DB_XENT_CVGEN_XP_LANG) . " AS t2_def
			   	on t1.ID_CVXP=t2_def.ID_CVXP and t2_def.defaultlang='1'
			WHERE uid='" . $this->getUid() . "' ORDER BY date_end DESC";

        $result = $this->db->query($sql);

        //$lastcvxp = $this->db->fetchArray($result);

        //print_r ($lastcvxp);

        //echo $sql;

        return $result;
    }

    public function ViewList()
    {
        global $xoopsDB, $xoopsTpl;

        $result = $this->getAllCvXP();

        //Send list to templates

        while (false !== ($allcv_array = $xoopsDB->fetchArray($result))) {
            //Add info the the array

            //$allcv_array['description'] = ;

            $allcv_array['date_start'] = formatTimestamp($allcv_array['date_start'], 'Y-m');

            $allcv_array['date_end'] = formatTimestamp($allcv_array['date_end'], 'Y-m');

            //$allcv_array['editform'] = $cvxp_editform->render();

            $xoopsTpl->append('listcvxp', $allcv_array);
        }
    }

    public function ViewEditList()
    {
        global $xoopsDB, $xoopsTpl;

        $result = $this->getAllCvXP();

        //Send list to templates

        while (false !== ($allcv_array = $xoopsDB->fetchArray($result))) {
            //Choose lang to edit form

            $cvxp_editform = new XoopsThemeForm('', 'editform_' . $allcv_array['ID_CVXP'], 'step2.php#step2form');

            $cvxp_editform->setExtra("enctype='multipart/form-data'");

            $language = new XoopsFormSelectLang('', 'language', $allcv_array['LanguageID']);

            $edit = new XoopsFormButton('', 'edit', _MA_XENT_CVGEN_FORM_EDIT, 'submit');

            $edit->setExtra("onmouseover='document.editform_" . $allcv_array['ID_CVXP'] . ".op.value=\"\"'");

            $delete = new xoopsFormButton('', 'edit', _MA_XENT_CVGEN_FORM_DELETE, 'submit');

            $delete->setExtra("onmouseover='document.editform_" . $allcv_array['ID_CVXP'] . ".op.value=\"delete\"'");

            $options = new XoopsFormElementTray('', '');

            //$options->addElement($language);

            $options->addElement($edit);

            $options->addElement($delete);

            $cvxp_editform->addElement($language);

            $cvxp_editform->addElement($options);

            $cvxp_editform->addElement(new XoopsFormHidden('idcvxp', $allcv_array['ID_CVXP']));

            $cvxp_editform->addElement(new XoopsFormHidden('op', ''));

            //$cvxp_editform->addElement(new XoopsFormHidden("edit", "1"));

            //Add info the the array

            $allcv_array['date_start'] = formatTimestamp($allcv_array['date_start'], 'Y-m');

            $allcv_array['date_end'] = formatTimestamp($allcv_array['date_end'], 'Y-m');

            $allcv_array['editform'] = $cvxp_editform->render();

            $xoopsTpl->append('listcvxp', $allcv_array);
        }
    }

    public function ShowAddForm()
    {
        global $xoopsDB, $xoopsTpl, $xoopsModuleConfig, $back, $edit, $myts;

        $selectcvxp = $this->selectCvXp();

        //$idcvxp = $selectcvxp['ID_CVXP'];

        //print_r($selectcvxp);

        //ADD/EDIT XP FORM

        $cvgenxp = new XoopsThemeForm(_MA_XENT_CVGEN_FORM_STEP2, 'cvgenxp', 'step2.php');

        $cvgenxp->setExtra("enctype='multipart/form-data'");

        $cvgenxp->addElement(new XoopsFormHidden('op', ''));

        if ('' != $selectcvxp['ID_CVXP']) {
            $cvgenxp->addElement(new XoopsFormHidden('idcvxp', $selectcvxp['ID_CVXP']));
        }

        $cvgenxp->addElement(new XoopsFormHidden('save', '1'));

        $cvgenxp->addElement(new XoopsFormSelectLang(_MA_XENT_CVGEN_FORM_LANG, 'language', $this->getLanguage()));

        $cvgenxp->addElement(new xoopsFormText($xoopsModuleConfig['requiere'] . _MA_XENT_CVGEN_CLIENTNAME, 'client_name', 64, 255, $myts->displayTarea($selectcvxp['client_name'])), true);

        $cvgenxp->addElement(new xoopsFormText($xoopsModuleConfig['requiere'] . _MA_XENT_CVGEN_CITY, 'city', 64, 255, $myts->displayTarea($selectcvxp['city'])), true);

        $cvgenxp->addElement(new xoopsFormText($xoopsModuleConfig['requiere'] . _MA_XENT_CVGEN_REGION, 'region', 64, 255, $myts->displayTarea($selectcvxp['region'])), true);

        $cvgenxp->addElement(new xoopsFormText($xoopsModuleConfig['requiere'] . _MA_XENT_CVGEN_COUNTRY, 'country', 64, 255, $myts->displayTarea($selectcvxp['country'])), true);

        $cvgenxp->addElement(new xoopsFormText($xoopsModuleConfig['requiere'] . _MA_XENT_CVGEN_POSITION, 'position', 64, 255, $myts->displayTarea($selectcvxp['position'])), true);

        $datestart = new XoopsFormTextDateSelect('', 'date_start', $size = 15, $selectcvxp['date_start']);

        $dateend = new XoopsFormTextDateSelect('', 'date_end', $size = 15, $selectcvxp['date_end']);

        $date_tray = new XoopsFormElementTray(_MA_XENT_CVGEN_DATESTARTEND, '');

        $date_tray->addElement($datestart);

        $date_tray->addElement($dateend);

        $cvgenxp->addElement($date_tray);

        $cvgenxp->addElement(new xoopsFormTextArea($xoopsModuleConfig['requiere'] . _MA_XENT_CVGEN_DESCRIPTION, 'description', $myts->displayTarea($selectcvxp['description']), 10, 30), true);

        //$cvgenxp->addElement(new xoopsFormLabel (" ",""));

        $editbutton = new XoopsFormButton('', 'edit', _MA_XENT_CVGEN_FORM_SAVE, 'submit');

        $editbutton->setExtra("onmouseover='document.cvgenxp.op.value=\"\"; document.cvgenxp.action=\"step2.php\"; document.cvgenxp.idcvxp.value=\"" . $selectcvxp['ID_CVXP'] . "\"'");

        $laststep = new XoopsFormButton('', 'laststep', _MA_XENT_CVGEN_FORM_LASTSTEP, 'button');

        $laststep->setExtra("onclick='history.back()'");

        $addmore = new XoopsFormButton('', 'addmore', _MA_XENT_CVGEN_FORM_ADDMORE, 'submit');

        $addmore->setExtra("onmouseover='document.cvgenxp.op.value=\"\"; document.cvgenxp.action=\"step2.php\"; document.cvgenxp.idcvxp.value=\"\"'");

        $nextstep = new XoopsFormButton('', 'nextstep', _MA_XENT_CVGEN_FORM_NEXTSTEP, 'button');

        $nextstep->setExtra("onclick='redirect(step3.php)'");

        $button_tray = new XoopsFormElementTray('', '');

        if (1 == $back) {
            $button_tray->addElement($laststep);
        }

        if ('' != $selectcvxp['ID_CVXP']) {
            $button_tray->addElement($editbutton);
        }

        $button_tray->addElement($addmore);

        //$button_tray->addElement($nextstep);

        $cvgenxp->addElement($button_tray);

        //$button_tray = new XoopsFormElementTray('' ,'');

        //$button_tray->addElement(new XoopsFormButton('', 'submit', _MA_XENT_CVGEN_NEXTSTEP, 'submit'));

        //$cvgen->addElement($button_tray);

        $cvgenxp->assign($xoopsTpl);
    }
}
