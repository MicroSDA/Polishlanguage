<?php
/**
 * Created by PhpStorm.
 * User: Ro
 * Date: 5/25/2018
 * Time: 22:08
 */
require_once URL_ROOT.'/core/Libs/Config/Mail/Mail.php';

/**
 * Class EmailSender
 */
class EmailSender
{

    /**
     * @var
     */
    private $SERVER_EMAIL_BOX;
    /**
     * @var
     */
    private $THIRD_EMAIL_BOX;
    /**
     * @var
     */
    private $MESSAGE;
    /**
     * @var
     */
    private $HOST;
    /**
     * @var
     */
    private $PORT;


    /**
     * @var
     */
    private $SENDTYPE = 'Server';

    /**
     * @return mixed
     */
    public function getSENDTYPE()
    {
        return $this->SENDTYPE;
    }

    /**
     * @param mixed $SENDTYPE
     */
    public function setSENDTYPE($SENDTYPE)
    {
        $this->SENDTYPE = $SENDTYPE;
    }

    /**
     * @return mixed
     */
    public function getSERVEREMAILBOX()
    {
        return $this->SERVER_EMAIL_BOX;
    }

    /**
     * @param mixed $SERVER_EMAIL_BOX
     */
    public function setSERVEREMAILBOX($SERVER_EMAIL_BOX)
    {
        $this->SERVER_EMAIL_BOX = $SERVER_EMAIL_BOX;
    }

    /**
     * @return mixed
     */
    public function getTHIRDEMAILBOX()
    {
        return $this->THIRD_EMAIL_BOX;
    }

    /**
     * @param mixed $THIRD_EMAIL_BOX
     */
    public function setTHIRDEMAILBOX($THIRD_EMAIL_BOX)
    {
        $this->THIRD_EMAIL_BOX = $THIRD_EMAIL_BOX;
    }

    /**
     * @return mixed
     */
    public function getHOST()
    {
        return $this->HOST;
    }

    /**
     * @param mixed $HOST
     */
    public function setHOST($HOST)
    {
        $this->HOST = $HOST;
    }

    /**
     * @return mixed
     */
    public function getPORT()
    {
        return $this->PORT;
    }

    /**
     * @param mixed $PORT
     */
    public function setPORT($PORT)
    {
        $this->PORT = $PORT;
    }

    /**
     * @return mixed
     */
    public function getUSERNAME()
    {
        return $this->USERNAME;
    }

    /**
     * @param mixed $USERNAME
     */
    public function setUSERNAME($USERNAME)
    {
        $this->USERNAME = $USERNAME;
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
     * @var
     */
    private $USERNAME;
    /**
     * @var
     */
    private $PASSWORD;

    /**
     * EmailSender constructor.
     */
    public function __construct()
    {
        try{

            $settings = DataBase::getInstance()->getDB()->getRow('SELECT * FROM c_email_settings');

            if($settings){

                $this->setTHIRDEMAILBOX($settings['ThirdPartyEmail']);
                $this->setSERVEREMAILBOX($settings['ServerEmail']);
                $this->setHOST($settings['SMTPHost']);
                $this->setPORT($settings['SMTPPort']);
                $this->setUSERNAME($settings['Username']);
                $this->setPASSWORD($settings['Password']);
                $this->setSENDTYPE($settings['SendType']);

            }

        }catch(Exception $e){

        }

    }



    public function sendEmail($to, $subject, $message, $personal_data){

        switch ($this->getSENDTYPE()){

            case 'SMTP':

                $this->sendViaSMTP($to, $subject, $message, $personal_data);

                break;
            default:
                $this->sendViaServerProvider($to, $subject, $message, $personal_data);
                break;
        }
    }

    /**
     * @param $to
     * @param $subject
     * @param $message
     * @param $personal_data
     * @return bool
     */
    public function sendViaSMTP($to, $subject, $message,  $personal_data){


        $this->MESSAGE = strtr($message, array(
            '{FN}'=> (isset($personal_data['FirstName']) ? $personal_data['FirstName']: 'NULL'),
            '{SN}'=>(isset($personal_data['Surname']) ? $personal_data['Surname']: 'NULL'),
            '{DATE}'=>(isset($personal_data['Date']) ? $personal_data['Date']: 'NULL'),
            '{TIME}'=>(isset($personal_data['Time']) ? $personal_data['Time']: 'NULL'),
            '{EMAIL}'=>(isset($personal_data['Email']) ? $personal_data['Email']: 'NULL'),
            '{WEBSITE}'=>(isset($personal_data['WebSite']) ? $personal_data['WebSite']: 'NULL'),
            '{PHONE}'=>(isset($personal_data['Phone']) ? $personal_data['Phone']: 'NULL'),
            '{SKYPE}'=>(isset($personal_data['Skype']) ? $personal_data['Skype']: 'NULL'),
            '{PASSWORD}'=>(isset($personal_data['Password']) ? $personal_data['Password']: 'NULL'),
            '{S_FN}'=>(isset($personal_data['StudentFirstName']) ? $personal_data['StudentFirstName']: 'NULL'),
            '{S_SN}'=>(isset($personal_data['StudentSurname']) ? $personal_data['StudentSurname']: 'NULL'),
            '{S_SKYPE}'=>(isset($personal_data['StudentSkype']) ? $personal_data['StudentSkype']: 'NULL'),
            '{L_DATE}'=>(isset($personal_data['LessonDate']) ? $personal_data['LessonDate']: 'NULL'),
            '{L_TIME}'=>(isset($personal_data['LessonTime']) ? $personal_data['LessonTime']: 'NULL'),
        ));

        $headers = array(
            'From' => '<'.$this->THIRD_EMAIL_BOX.'>',
            'To' => '<'.$to.'>',
            'Subject' => $subject,
            'MIME-Version' => 1,
            'Content-type' => 'text/html;charset=UTF-8'
        );

        $smtp = Mail::factory('smtp', array(
            'host' => $this->HOST,
            'port' => $this->PORT,
            'auth' => true,
            'username' => $this->USERNAME,
            'password' => $this->PASSWORD
        ));



        $mail = $smtp->send($to, $headers, $this->MESSAGE);

        if (PEAR::isError($mail)) {
            return false;
        } else {
           return true;
        }
    }

    /**
     *   '{FN}'=>$personal_data['FirstName'],
    '{SN}'=>$personal_data['Surname'],
    '{DATE}'=>$personal_data['Date'],
    '{TIME}'=>$personal_data['Time'],
    '{EMAIL}'=>$personal_data['Email']
     */

    /**
     * @param $to
     * @param $subject
     * @param $message
     * @param $personal_data
     * @return bool
     */
    public function sendViaServerProvider($to, $subject, $message, $personal_data){

        $this->MESSAGE = strtr($message, array(
            '{FN}'=> (isset($personal_data['FirstName']) ? $personal_data['FirstName']: 'NULL'),
            '{SN}'=>(isset($personal_data['Surname']) ? $personal_data['Surname']: 'NULL'),
            '{DATE}'=>(isset($personal_data['Date']) ? $personal_data['Date']: 'NULL'),
            '{TIME}'=>(isset($personal_data['Time']) ? $personal_data['Time']: 'NULL'),
            '{EMAIL}'=>(isset($personal_data['Email']) ? $personal_data['Email']: 'NULL'),
            '{WEBSITE}'=>(isset($personal_data['WebSite']) ? $personal_data['WebSite']: 'NULL'),
            '{PHONE}'=>(isset($personal_data['Phone']) ? $personal_data['Phone']: 'NULL'),
            '{SKYPE}'=>(isset($personal_data['Skype']) ? $personal_data['Skype']: 'NULL'),
            '{PASSWORD}'=>(isset($personal_data['Password']) ? $personal_data['Password']: 'NULL'),
            '{S_FN}'=>(isset($personal_data['StudentFirstName']) ? $personal_data['StudentFirstName']: 'NULL'),
            '{S_SN}'=>(isset($personal_data['StudentSurname']) ? $personal_data['StudentSurname']: 'NULL'),
            '{S_SKYPE}'=>(isset($personal_data['StudentSkype']) ? $personal_data['StudentSkype']: 'NULL'),
            '{L_DATE}'=>(isset($personal_data['LessonDate']) ? $personal_data['LessonDate']: 'NULL'),
            '{L_TIME}'=>(isset($personal_data['LessonTime']) ? $personal_data['LessonTime']: 'NULL'),
          ));


        $headers = array(
            'From' => '<'.$this->SERVER_EMAIL_BOX.'>',
            'To' => '<'.$to.'>',
            'Subject' => $subject,
            'MIME-Version' => 1,
            'Content-type' => 'text/html;charset=UTF-8'
        );

        $server_mail = Mail::factory('mail');
        $mail = $server_mail->send($to, $headers, $this->MESSAGE);
        if (PEAR::isError($mail)) {
            return false;
        } else {
            return true;
        }

    }

    public function init(){



        $from = '<banschey@gmail.com>';
        $to = '<banschey@gmail.com>';
        $subject = 'Hi!';
        $body = "Hi,\n\nHow are you?";

        $headers = array(
            'From' => $from,
            'To' => $to,
            'Subject' => $subject
        );

        $smtp = Mail::factory('smtp', array(
            'host' => 'ssl://smtp.gmail.com',
            'port' => '465',
            'auth' => true,
            'username' => 'banschey',
            'password' => 'Getthereamazinglyfast0911'
        ));

        $mail = $smtp->send($to, $headers, $body);

        if (PEAR::isError($mail)) {
            echo('<p>' . $mail->getMessage() . '</p>');
        } else {
            echo('<p>Message successfully sent!</p>');
        }
    }
}