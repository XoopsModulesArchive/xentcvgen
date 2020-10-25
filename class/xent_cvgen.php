<?php

require_once XOOPS_ROOT_PATH . '/modules/xentgen/include/xent_gen_tables.php';

$xentCv = new XentCv();

class XentCv extends XoopsObject
{
    public $_extendedInfo = null;

    public $db;

    public $idcv;

    public $uid;

    public $summary;

    public $specialities;

    public $date_create;

    public $date_modif;

    public $language;

    public $defaultlang = 0;

    public $myts;

    public function __construct()
    {
        $this->db = XoopsDatabaseFactory::getDatabaseConnection();

        $this->myts = MyTextSanitizer::getInstance();

        //$this->initVar("summary", XOBJ_DTYPE_TXTAREA, null, false);
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

    public function setSummary($summary)
    {
        $summary = $this->myts->addSlashes($summary);

        $this->summary = $summary;
    }

    public function setspecialities($specialities)
    {
        $specialities = $this->myts->addSlashes($specialities);

        $this->specialities = $specialities;
    }

    public function setDateCreate($date_create)
    {
        $this->date_create = $date_create;
    }

    public function setDateModif($date_modif)
    {
        $this->date_modif = $date_modif;
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

    public function getSummary()
    {
        return $this->summary;
    }

    public function getSpecialities()
    {
        return $this->specialities;
    }

    public function getDateCreate()
    {
        return $this->date_create;
    }

    public function getDateModif()
    {
        return $this->date_modif;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function getDefaultLang()
    {
        return $this->defaultlang;
    }

    // methods

    public function cvExistTest()
    {
        //var_dump($this);

        $userid = $this->getUid();

        $language = $this->getLanguage();

        //$sql2 = "SELECT * FROM ".$this->db->prefix(XENT_DB_XENT_CVGEN)." AS t1, ".$this->db->prefix(XENT_DB_XENT_CVGEN_LANG)." AS t2 WHERE uid=$userid AND t1.ID_CVGEN=t2.ID_CVGEN AND t2.languageid='$language'";

        $sql2 = 'SELECT * FROM ' . $this->db->prefix(XENT_DB_XENT_CVGEN) . " WHERE uid=$userid";

        //echo $sql2;

        //echo "<br>".$sql. "<br>";

        $result = $this->db->query($sql2);

        $cvlist = $this->db->fetchArray($result);

        if (empty($cvlist['ID_CVGEN'])) {
            return false;
            //echo "Test3";
        }  

        $this->setIdCv($cvlist['ID_CVGEN']);

        return true;
    }

    public function add()
    {
        $sql1 = 'INSERT INTO ' . $this->db->prefix(XENT_DB_XENT_CVGEN) . " (
		uid,
		date_create,
		date_modif
		) VALUES('" . $this->getUid() . "', '" . $this->getDateCreate() . "', '" . $this->getDateModif() . "'); ";

        $this->db->query($sql1);

        $sql2 = 'INSERT INTO ' . $this->db->prefix(XENT_DB_XENT_CVGEN_LANG) . " (
		ID_CVGEN, 
		languageid, 
		defaultlang, 
		summary, 
		specialities
		) VALUES('" . $this->db->getInsertId() . "', '" . $this->getLanguage() . "', '" . "1', '" . $this->getSummary() . "', '" . $this->getSpecialities() . "')";

        $this->db->query($sql2);

        if (0 == $this->db->errno()) {
            //redirect_header("adminjobs.php",1,_AM_DBUPDATED);
        } else {
            redirect_header('adminjobs.php', 10, $this->db->error());
        }
    }

    public function deletebyeid($id, $ok = 0)
    {
        if (1 == $ok) {
            //Delete cv from principal table

            $sql = 'DELETE FROM ' . $this->db->prefix(XENT_DB_XENT_CVGEN) . " WHERE ID_CVGEN=$id";

            $this->db->queryF($sql);

            $sql = 'DELETE FROM ' . $this->db->prefix(XENT_DB_XENT_CVGEN_LANG) . " WHERE ID_CVGEN=$id";

            $this->db->queryF($sql);

            //Delete all entry in cvgen_xp

            $sql = 'DELETE FROM ' . $this->db->prefix(XENT_DB_XENT_CVGEN_XP) . " WHERE ID_CVGEN=$id";

            $this->db->queryF($sql);

            $sql = 'DELETE FROM ' . $this->db->prefix(XENT_DB_XENT_CVGEN_XP_LANG) . " WHERE ID_CVGEN=$id";

            $this->db->queryF($sql);

            //Delete all entry in cvgen_edu

            $sql = 'DELETE FROM ' . $this->db->prefix(XENT_DB_XENT_CVGEN_EDU) . " WHERE ID_CVGEN=$id";

            $this->db->queryF($sql);

            $sql = 'DELETE FROM ' . $this->db->prefix(XENT_DB_XENT_CVGEN_EDU_LANG) . " WHERE ID_CVGEN=$id";

            $this->db->queryF($sql);

            if (0 == $this->db->errno()) {
                redirect_header('adminjobs.php', 1, _AM_DBUPDATED);
            } else {
                redirect_header('adminjobs.php', 4, $this->db->error());
            }
        }  

        //Ask before delete
    }

    /*	function getAllCv(){
    $sql = "SELECT * FROM ".$this->db->prefix(XENT_DB_XENT_CVGEN)." ORDER BY specialities";
    $result = $this->db->query($sql);

    return $result;
    }*/

    public function getLastCv()
    {
        //$sql = "SELECT * FROM ".$this->db->prefix(XENT_DB_XENT_CVGEN)." WHERE uid=".$this->getUid()." AND language='".$this->getLanguage()."'";

        $sql = 'SELECT * FROM ' . $this->db->prefix(XENT_DB_XENT_CVGEN) . ' AS t1, ' . $this->db->prefix(XENT_DB_XENT_CVGEN_LANG) . ' AS t2 WHERE uid=' . $this->getUid() . " AND t1.ID_CVGEN=t2.ID_CVGEN AND t2.languageid='" . $this->getLanguage() . "'";

        $result = $this->db->query($sql);

        $lastcv = $this->db->fetchArray($result);

        if ('' == $lastcv) {
            $sql = 'SELECT * FROM ' . $this->db->prefix(XENT_DB_XENT_CVGEN) . ' AS t1, ' . $this->db->prefix(XENT_DB_XENT_CVGEN_LANG) . ' AS t2 WHERE uid=' . $this->getUid() . " AND t1.ID_CVGEN=t2.ID_CVGEN AND t2.defaultlang='1'";

            $result = $this->db->query($sql);

            $lastcv = $this->db->fetchArray($result);
        }

        //echo $sql;

        return $lastcv;
    }

    /*	function getCv($id){
    $sql = "SELECT * FROM ".$this->db->prefix(XENT_DB_XENT_CVGEN)." WHERE ID_CVEDU=$id";
    $result = $this->db->query($sql);
    $job = $this->db->fetchArray($result);

    return $job;
    }*/

    public function update()
    {
        $sql = 'SELECT * FROM ' . $this->db->prefix(XENT_DB_XENT_CVGEN) . ' AS t1, ' . $this->db->prefix(XENT_DB_XENT_CVGEN_LANG) . ' AS t2 WHERE t1.ID_CVGEN=' . $this->getIdCv() . " AND t1.ID_CVGEN=t2.ID_CVGEN AND t2.languageid='" . $this->getLanguage() . "'";

        $result = $this->db->queryF($sql);

        $checkforupdate = $this->db->fetchArray($result);

        if ('' == $checkforupdate) {
            //ADD ENTRY IF NOT EXIST

            //echo $sql;

            $sql2 = 'INSERT INTO ' . $this->db->prefix(XENT_DB_XENT_CVGEN_LANG) . " (
		ID_CVGEN, 
		languageid, 
		defaultlang, 
		summary, 
		specialities
		) VALUES('" . $this->getIdCv() . "', '" . $this->getLanguage() . "', '" . "0', '" . $this->getSummary() . "', '" . $this->getSpecialities() . "')";

            $this->db->query($sql2);
        } else {
            //echo "<br>CV_UPDATE<br>";

            $sql1 = 'UPDATE ' . $this->db->prefix(XENT_DB_XENT_CVGEN) . " SET
		date_modif='" . $this->getDateModif() . "' 
		WHERE uid=" . $this->getUid();

            $this->db->queryF($sql1);

            $sql2 = 'UPDATE ' . $this->db->prefix(XENT_DB_XENT_CVGEN_LANG) . " SET
		summary='" . $this->getSummary() . "', 
		specialities='" . $this->getSpecialities() . "' 
		WHERE ID_CVGEN=" . $this->getIdCv() . " AND languageid='" . $this->getLanguage() . "'";

            $this->db->queryF($sql2);
        }

        //echo $sql2;

        if (0 == $this->db->errno()) {
            //redirect_header("adminjobs.php",1,_AM_DBUPDATED);
        }  

        //redirect_header("adminjobs.php",4,$this->db->error());
    }

    public function BuiltCvHTML($editmode = 0, $class = '')
    {
        global $xoopsDB, $xoopsTpl, $xoopsUser, $xentCvXp, $xentCvEdu, $xentExpertise, $xentTechskill, $myts;

        $lastcv = $this->getLastCv();

        $memberHandler = xoops_getHandler('member');

        $thisUser = $memberHandler->getUser($lastcv['uid']);

        $name = $thisUser->getVar('name');

        $name = mb_strtoupper($name);

        $xoopsTpl->assign('SUMMARY', $lastcv['summary']);

        $xoopsTpl->assign('SPECIALITIES', $lastcv['specialities']);

        $xoopsTpl->assign('USERID', $lastcv['uid']);

        $xoopsTpl->assign('USERNAME', $name);

        $xoopsTpl->assign('lang_summary', _MA_XENT_CVGEN_SUMMARY);

        if (1 == $editmode && 'cvxp' == $class) {
            //Show Edit Mode

            //echo "test";

            $xentCvXp->ViewEditList();

            $xentCvXp->ShowAddForm();

            $xoopsTpl->assign('lang_helpxp', _MA_XENT_CVGEN_FORM_HELPXP);

            $xoopsTpl->assign('lang_xp_title', _MA_XENT_CVGEN_EXPERIENCE_TITLE);
        } else {
            $xentCvXp->ViewList();

            $xoopsTpl->assign('lang_xp_title', _MA_XENT_CVGEN_EXPERIENCE_TITLE);
        }

        if (1 == $editmode && 'cvedu' == $class) {
            //echo "test";

            $xentCvEdu->ViewEditList();

            $xentCvEdu->ShowAddForm();

            $xoopsTpl->assign('lang_help', _MA_XENT_CVGEN_FORM_HELPEDU);

            $xoopsTpl->assign('lang_edu_title', _MA_XENT_CVGEN_EDUCATION_TITLE);
        } else {
            $xentCvEdu->ViewList();

            $xoopsTpl->assign('lang_edu_title', _MA_XENT_CVGEN_EDUCATION_TITLE);
        }

        //Display Expertise

        $xoopsTpl->assign('lang_exp_title', _MA_XENT_CVGEN_EXPERTISE_TITLE);

        $resultcat = $xentExpertise->getAllCat();

        $display = 0;

        while (false !== ($expcat = $xoopsDB->fetchArray($resultcat))) {
            if (true === $xentExpertise->displayCat($expcat['ID_EXPERTISECAT'])) {
                $expcat['display'] = $display;

                $expcat['name'] = $myts->displayTarea($expcat['name']);

                if (0 == $display) {
                    $display++;
                } else {
                    $display--;
                }

                $itemarr = $xentExpertise->getItemsForCatInArrayForUser($expcat['ID_EXPERTISECAT'], $lastcv['uid']);

                $expcat['item'] = $itemarr;

                if (null === !$expcat['item']) {
                    $xoopsTpl->append('expcat', $expcat);
                }

                //$xoopsTpl->append("expcat", $expcat);
            }
        }

        //Display Technical Skill

        $xoopsTpl->assign('lang_techskill_title', _MA_XENT_CVGEN_TECHSKILL_TITLE);

        $tresultcat = $xentTechskill->getAllCat();

        $tdisplay = 0;

        while (false !== ($techskillcat = $xoopsDB->fetchArray($tresultcat))) {
            if (true === $xentTechskill->displayCat($techskillcat['ID_TECHSKILLCAT'])) {
                //echo "test";

                $techskillcat['display'] = $tdisplay;

                $techskillcat['name'] = $myts->displayTarea($techskillcat['name']);

                //echo $techskillcat['name'];

                if (0 == $tdisplay) {
                    $tdisplay++;
                } else {
                    $tdisplay--;
                }

                $itemarr = $xentTechskill->getItemsForCatInArrayForUser($techskillcat['ID_TECHSKILLCAT'], $lastcv['uid']);

                $techskillcat['item'] = $itemarr;

                if (null === !$techskillcat['item']) {
                    $xoopsTpl->append('techskillcat', $techskillcat);
                }

                //print_r($techskillcat);
                //$xoopsTpl->append("expcat", $expcat);
            }
        }
    }
}
