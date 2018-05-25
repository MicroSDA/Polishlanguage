<?php
/**
 * Created by PhpStorm.
 * User: Ro
 * Date: 5/25/2018
 * Time: 22:08
 */
require_once URL_ROOT.'/core/Libs/Config/Mail/Mail.php';
class EmailSender
{

    private $SERVER_EMAIL_BOX;
    private $THIRD_EMAIL_BOX;
    private $MESSAGE;
    private $HOST;
    private $PORT;

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
    private $USERNAME;
    private $PASSWORD;

    public function __construct()
    {
    }



    public function sendViaSMTP($to, $subject, $message){

        $headers = array(
            'From' => $this->THIRD_EMAIL_BOX,
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

        $this->MESSAGE = strtr($message, array('{TO}' => $to));

        $mail = $smtp->send($to, $headers, $this->MESSAGE);

        if (PEAR::isError($mail)) {
            return false;
        } else {
           return true;
        }
    }


    public function sendViaServerProvider(){

        function mail_utf8($to, $subject ='(No Subject)', $message='', $header_inc)
       {
         $header = 'MIME-Version: 1.0'.PHP_EOL.'Content-type: text/plain; charset=UTF-8'.PHP_EOL.'From: '.$header_inc.PHP_EOL;
         mail($to, '=?UTF-8?B?'.base64_encode($subject).'?=',$message, $header);
         return true;
       }

       $email = 'rodion@localhost.com';
       $subj = 'Subj';
       $emess = 'Привет ' . PHP_EOL;
       $emess .= ' Пирвет';
       $headers = 'From: rodion@gmail.com';
       //$mailsend = mail($email, $subj, $emess, $headers);


       if ((mail_utf8($email,$subj,$emess,$headers))) {
           echo 'отправленно';
       } else {
           echo 'ошибка';
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