<?php
/**
 * Created by PhpStorm.
 * User: Ro
 * Date: 5/14/2018
 * Time: 17:19
 */

class Teacher
{


    private $teacher_template;
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
    private $ID;
    /**
     * @var
     */
    private $PHONE;
    /**
     * @var
     */
    private $PHOTO;

    /**
     * @return mixed
     */
    public function getPHOTO()
    {
        return $this->PHOTO;
    }

    /**
     * @param mixed $PHOTO
     */
    public function setPHOTO($PHOTO)
    {
        $this->PHOTO = $PHOTO;
    }
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
    private $STATUS;

    /**
     * @var array
     */
    private $LEVEL = [];

    /**
     * @var array
     */
    private $AVAILABLE_TIME;

    /**
     * @return mixed
     */
    public function getAVAILABLETIME()
    {
        return $this->AVAILABLE_TIME;
    }

    public function changeAVAILABLETIME($array, $c_date, $c_time, $new_date, $new_time)
    {

        foreach ($array as $key => $value) {

            if (array_search($c_date, $value) && array_search($c_time, $value)) {
                $array[$key]['start'] = $new_date;
                $array[$key]['title'] = $new_time;
                $array[$key]['in-use'] = 'no';
                $array[$key]['notif'] = 'no';
                break;


            }

        }

        $array_out = json_encode($array);
        DataBase::getInstance()->getDB()->query('UPDATE c_teacher SET AvailableTime=?s WHERE id=?i AND Email=?s',$array_out, $this->getID(), $this->getEMAIL());
        $this->setAVAILIBLETIME($array_out);
    }

    public function addAVAILABLETIME($array, $date, $time)
    {

        $array_inc = $array;
        try {

            if(!empty($array_inc)){

                foreach ($array_inc as $key => $value) {

                    if (array_search($date, $value) and array_search($time, $value)) {

                        return false;
                    }

                }

                array_push($array_inc, array('start' => $date,'title' => $time,'in-use'=> 'no','notif'=>'no'));
                $array_out = json_encode($array_inc);
                DataBase::getInstance()->getDB()->query('UPDATE c_teacher SET AvailableTime=?s WHERE id=?i AND Email=?s', $array_out, $this->getID(),$this->getEMAIL());
                //$this->setAVAILIBLETIME($array_out);

                return true;

            }else{

                $array_inc =[];
                array_push($array_inc, array('start' => $date, 'title' => $time,'in-use'=> 'no','notif'=>'no'));
                $array_out = json_encode($array_inc);
                DataBase::getInstance()->getDB()->query('UPDATE c_teacher SET AvailableTime=?s WHERE id=?i AND Email=?s', $array_out, $this->getID(),$this->getEMAIL());
                //$this->setAVAILIBLETIME($array_out);

                return true;
            }


            return false;

        }catch (Error $e){

            echo $e->getMessage();
        }

    }


    public function deleteAVAILABLETIME($array, $date, $time)
    {
        foreach ($array as $key => $value) {

            if (array_search($date, $value) && array_search($time, $value) && array_search('no', $value)) {
                unset($array[$key]);

                $array_out = json_encode($array);
                DataBase::getInstance()->getDB()->query('UPDATE c_teacher SET AvailableTime=?s WHERE id=?i AND Email=?s', $array_out,$this->getID(),$this->getEMAIL());
                return true;
            }

        }

      return false;

    }


    public function setLesson($array, $date, $time, $id, $inuse, $s_ref){

        foreach ($array as $key => $value) {

            if (array_search($date, $value) && array_search($time, $value) && array_search('no', $value)) {
                $array[$key]['start'] = $date;
                $array[$key]['title'] = $time;
                $array[$key]['in-use'] = $inuse;
                $array[$key]['url'] = '/teacher/lessons/lesson/?date='.$date.'&time='.$time.'&token='.$s_ref;
                $array[$key]['notif'] = 'yes';

                $array_out = json_encode($array);

                try{

                    DataBase::getInstance()->getDB()->query('UPDATE c_teacher SET AvailableTime=?s WHERE id=?i',$array_out,  $id);


                }catch (Exception $e){

                    echo $e->getMessage();
                }


                return true;
                break;

            }


        }

      return false;
    }

    public function unsetLesson($array, $date, $time, $t_id){

        foreach ($array as $key => $value) {

            if (array_search($date, $value) && array_search($time, $value) && array_search('yes', $value)) {
                $array[$key]['in-use'] = 'no';
                $array[$key]['notif'] = 'yes';
                unset($array[$key]['url']);

                $array_out = json_encode($array);

                try{

                    DataBase::getInstance()->getDB()->query('UPDATE c_teacher SET AvailableTime=?s WHERE id=?i',$array_out,  $t_id);

                }catch (Exception $e){

                    echo $e->getMessage();
                }

                return true;
                break;

            }


        }

        return false;
    }

    public function notification_update($array, $date, $time, $id, $notif){

        foreach ($array as $key => $value) {

            if (array_search($date, $value) && array_search($time, $value)) {
                $array[$key]['notif'] = $notif;

                $array_out = json_encode($array);

                try{

                    DataBase::getInstance()->getDB()->query('UPDATE c_teacher SET AvailableTime=?s WHERE id=?i',$array_out, $id);

                }catch (Exception $e){

                    echo $e->getMessage();
                }

                return true;
                break;

            }


        }

        return false;
    }
    /**
     * @param  $AVAILABLE_TIME
     */
    public function setAVAILIBLETIME($AVAILABLE_TIME)
    {
        $this->AVAILABLE_TIME = $AVAILABLE_TIME;
    }


    /**
     * Teacher constructor.
     */
    public function __construct()
    {

    }


    public function isLogin()
    {


        /**
         * If cookies isset
         */
        if (isset($_COOKIE['t-id']) && isset($_COOKIE['t-hash'])) {

            /**
             * If cookie is wrong
             */

            $this->teacher_template = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_teacher WHERE id=?s AND Hash=?s', $_COOKIE['t-id'], $_COOKIE['t-hash']);

            if ($this->teacher_template) {


                $this->ID = $this->teacher_template[0]['id'];
                $this->HASH = $this->teacher_template[0]['Hash'];
                $this->LAST_LOGIN = $this->teacher_template[0]['LastLogin'];

                $this->FIRST_NAME = $this->teacher_template[0]['FirstName'];
                $this->LAST_NAME = $this->teacher_template[0]['LastName'];
                $this->EMAIL = $this->teacher_template[0]['Email'];
                $this->PHONE = $this->teacher_template[0]['Phone'];
                $this->PASSWORD = $this->teacher_template[0]['Password'];
                $this->SKYPE = $this->teacher_template[0]['Skype'];
                $this->STATUS = $this->teacher_template[0]['Status'];
                $this->IP = $this->teacher_template[0]['Ip'];
                $this->ADD_INFO = $this->teacher_template[0]['AddInfo'];
                $this->LEVEL = $this->teacher_template[0]['Level'];
                $this->AVAILABLE_TIME = $this->teacher_template[0]['AvailableTime'];
                $this->PHOTO = $this->teacher_template[0]['Photo'];

                unset($this->teacher_template);
                /**
                 * Was login
                 */

                /**
                 * If account aren't active then disable authorization
                 */
                if ($this->STATUS == 'not-active') {
                    return false;
                } else {
                    return true;
                }


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

    /**
     * @return array
     */
    public function getLEVEL()
    {
        return $this->LEVEL;
    }

    /**
     * @param array $LEVEL
     */
    public function setLEVEL($LEVEL)
    {
        $this->LEVEL = $LEVEL;
    }

}