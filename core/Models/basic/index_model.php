<?php
/**
 * User: Ro Kovalenko
 * Date: 12/30/2017
 * Time: 7:58 PM
 */


class index_model extends Model
{

    /**
     * index_model constructor.
     */
    public function __construct()
    {


        parent::__construct();

    }

    /**
     *
     */
    public function index()
    {

        //phpinfo();


        require_once URL_ROOT.'/core/Libs/Config/Mail/EmailSender.php';

        $mail = new EmailSender();
        $mail->setHOST('ssl://smtp.gmail.com');
        $mail->setUSERNAME('banschey');
        $mail->setPASSWORD('Getthereamazinglyfast0911');
        $mail->setPORT('465');
        $mail->setTHIRDEMAILBOX('<banschey@gmail.com>');


        $message = file_get_contents(URL_ROOT.'/core/Libs/Config/Mail/Template.php');
        //$mail->sendViaSMTP('banschey@gmail.com','Привет',$message);

       /* function mail_utf8($to, $subject ='(No Subject)', $message='', $header_inc)
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
        }*/

        $this->render();

    }

}