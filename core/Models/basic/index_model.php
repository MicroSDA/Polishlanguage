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

        $mail = new EmailSender();
        $message = file_get_contents(URL_ROOT.'/core/Libs/Config/Mail/Template.php');

        $personal_data = array(
            'FirstName'=>'Rodion',
            'Surname'=>'Kovalenko',
            'Email'=>'banschey@gmail.com',
            'Date'=>date('Y-m-d'),
            'Time'=>date('H-i'),
            'WebSite'=> $_SERVER['HTTP_HOST'],
            'Phone'=>'+380950087296',
            'Password'=> 'qQ111111',
            'Skype'=>'Skype.s'
        );

        /**
         *   '{FN}'=>$personal_data['FirstName'],
        '{SN}'=>$personal_data['Surname'],
        '{DATE}'=>$personal_data['Date'],
        '{TIME}'=>$personal_data['Time'],
        '{EMAIL}'=>$personal_data['Email']
         */
        $mail->sendEmail('rodion@localhost.com','Привет',$message,  $personal_data);


        $this->render();

    }

}