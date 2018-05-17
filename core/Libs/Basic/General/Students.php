<?php
/**
 * Created by PhpStorm.
 * User: bansc
 * Date: 5/2/2018
 * Time: 9:10 AM
 */

class Students
{
    /**
     * @var
     */
    private $students_tempalte;
    /**
     * @var
     */
    private $ID;
    /**
     * @var
     */
    private $FIRST_NAME;
    /**
     * @var
     */
    private $LAST_NAME;
    /**
     * @var
     */
    private $EMAIL;
    /**
     * @var
     */
    private $PHONE;
    /**
     * @var
     */
    private $SKYPE;
    /**
     * @var
     */
    private $PASSWORD;
    /**
     * @var
     */
    private $ADD_INFO;


    /**
     * @var
     */
    private $HASH;
    /**
     * @var
     */
    private $IP;
    /**
     * @var
     */
    private $LAST_LOGIN;

    /**
     * @var
     */
      private $COURSES = [];

    /**
     * @var
     */
    private $STATUS;

    /**
     * @var
     */
    private $LEVEL;

    /**
     * @return mixed
     */
    public function getLEVEL()
    {
        return $this->LEVEL;
    }

    /**
     * @param mixed $LEVEL
     */
    public function setLEVEL($LEVEL)
    {
        $this->LEVEL = $LEVEL;
    }

    /**
     * Students constructor.
     */
    public function __construct()
    {


    }


    public function isLogin()
    {


        /**
         * If cookies isset
         */
        if (isset($_COOKIE['s-id']) && isset($_COOKIE['s-hash'])) {

            /**
             * If cookie is wrong
             */

            $this->students_tempalte = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_students WHERE id=?s AND Hash=?s', $_COOKIE['s-id'], $_COOKIE['s-hash']);

            if ($this->students_tempalte) {

                    $this->ID = $this->students_tempalte[0]['id'];
                    $this->HASH = $this->students_tempalte[0]['Hash'];
                    $this->LAST_LOGIN = $this->students_tempalte[0]['LastLogin'];

                    $this->FIRST_NAME = $this->students_tempalte[0]['FirstName'];
                    $this->LAST_NAME = $this->students_tempalte[0]['LastName'];
                    $this->EMAIL = $this->students_tempalte[0]['Email'];
                    $this->PHONE = $this->students_tempalte[0]['Phone'];
                    $this->PASSWORD = $this->students_tempalte[0]['Password'];
                    $this->SKYPE = $this->students_tempalte[0]['Skype'];
                    $this->STATUS = $this->students_tempalte[0]['Status'];
                    $this->IP = $this->students_tempalte[0]['Ip'];
                    $this->ADD_INFO = $this->students_tempalte[0]['AddInfo'];
                    $this->COURSES = $this->students_tempalte[0]['Courses'];
                    $this->LEVEL = $this->students_tempalte[0]['Level'];

                    unset($this->students_tempalte);
                    /**
                     * Was login
                     */

                    /**
                     * If account aren't active then disable authorization
                     */
                    if($this->STATUS == 'not-active'){return false;}else{return true;}



            } else {

                return false;

            }

        } else {

            return false;
        }

    }

    /**
     * @return mixed
     */
    public function getID()
    {
        return $this->ID;
    }

    /**
     * @param mixed $ID
     */
    public function setID($ID)
    {
        $this->ID = $ID;
    }

    /**
     * @return mixed
     */
    public function getFIRSTNAME()
    {
        return $this->FIRST_NAME;
    }

    /**
     * @param mixed $FIRST_NAME
     */
    public function setFIRSTNAME($FIRST_NAME)
    {
        $this->FIRST_NAME = $FIRST_NAME;
    }

    /**
     * @return mixed
     */
    public function getLASTNAME()
    {
        return $this->LAST_NAME;
    }

    /**
     * @param mixed $LAST_NAME
     */
    public function setLASTNAME($LAST_NAME)
    {
        $this->LAST_NAME = $LAST_NAME;
    }

    /**
     * @return mixed
     */
    public function getEMAIL()
    {
        return $this->EMAIL;
    }

    /**
     * @param mixed $EMAIL
     */
    public function setEMAIL($EMAIL)
    {
        $this->EMAIL = $EMAIL;
    }

    /**
     * @return mixed
     */
    public function getPHONE()
    {
        return $this->PHONE;
    }

    /**
     * @param mixed $PHONE
     */
    public function setPHONE($PHONE)
    {
        $this->PHONE = $PHONE;
    }

    /**
     * @return mixed
     */
    public function getSKYPE()
    {
        return $this->SKYPE;
    }

    /**
     * @param mixed $SKYPE
     */
    public function setSKYPE($SKYPE)
    {
        $this->SKYPE = $SKYPE;
    }

    /**
     * @return mixed
     */
    public function getPASSWORD()
    {
        return $this->PASSWORD;
    }

    /**
     * @param mixed $PASSWORD
     */
    public function setPASSWORD($PASSWORD)
    {
        $this->PASSWORD = $PASSWORD;
    }

    /**
     * @return mixed
     */
    public function getADDINFO()
    {
        return $this->ADD_INFO;
    }

    /**
     * @param mixed $ADD_INFO
     */
    public function setADDINFO($ADD_INFO)
    {
        $this->ADD_INFO = $ADD_INFO;
    }

    /**
     * @return mixed
     */
    public function getHASH()
    {
        return $this->HASH;
    }

    /**
     * @param mixed $HASH
     */
    public function setHASH($HASH)
    {
        $this->HASH = $HASH;
    }

    /**
     * @return mixed
     */
    public function getIP()
    {
        return $this->IP;
    }

    /**
     * @param mixed $IP
     */
    public function setIP($IP)
    {
        $this->IP = $IP;
    }

    /**
     * @return mixed
     */
    public function getLASTLOGIN()
    {
        return $this->LAST_LOGIN;
    }

    /**
     * @param mixed $LAST_LOGIN
     */
    public function setLASTLOGIN($LAST_LOGIN)
    {
        $this->LAST_LOGIN = $LAST_LOGIN;
    }

    /**
     * @return mixed
     */
    public function getCOURSES()
    {
        return $this->COURSES;
    }

    /**
     * @param mixed $COURSES
     */
    public function setCOURSES($COURSES)
    {
        $this->COURSES = $COURSES;
    }

    /**
     * @return mixed
     */
    public function getSTATUS()
    {
        return $this->STATUS;
    }

    /**
     * @param mixed $STATUS
     */
    public function setSTATUS($STATUS)
    {
        $this->STATUS = $STATUS;
    }
}