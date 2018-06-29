<?php
/**
 * Created by PhpStorm.
 * User: bansc
 * Date: 1/29/2018
 * Time: 10:27 PM
 */

class ajax_model
{

    public function __construct()
    {
        /**
         * If We are trying to open from direct link or from custom link from website
         */
        if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) or $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest' or empty($_SERVER['HTTP_REFERER']) or empty($_SERVER['HTTP_AJAX']) or $_SERVER['HTTP_AJAX'] != 'Ajax') {

            UrlsDispatcher::getInstance()->setCurrentUrlData(UrlsDispatcher::getInstance()->getUrlsDataListByKey('(^)'));
            $controller = new Controller();

            die();
        }

        /**
         * Else, ok
         */

    }

    public function index()
    {

    }



    public function admin_edit_url()
    {


        $page_name = $_POST['data'][0]['value'];
        $page_pattern = $_POST['data'][1]['value'];
        $page_pattern_old = $_POST['data'][2]['value'];
        $page_model = $_POST['data'][3]['value'];
        $page_method = $_POST['data'][4]['value'];
        $page_view = $_POST['data'][5]['value'];
        $page_type = $_POST['data'][6]['value'];
        $page_cache = $_POST['data'][7]['value'];
        $page_status = $_POST['data'][8]['value'];


        if(empty($page_name) or empty($page_pattern) or empty($page_type) or empty($page_model) or empty($page_method) or empty($page_view) or empty($page_cache) or empty($page_status)){

            echo '<div style="text-align: center"><span class="btn btn-danger"><h5>All fields should be filled</h5></span></div>';
            die();
        }

        $page_pattern = trim($page_pattern);
        if(!preg_match('(^\\(\\^.{1,}\\$\\)$)',$page_pattern)){

            echo '<br><br><div style="text-align: center"><span class="btn btn-warning"><h5>Pattern mask is wrong, try to use "(^....$)"</h5></span></div>';
            die();
        }

        try {

            DataBase::getInstance()->getDB()->query("UPDATE c_urls SET Pattern=?s, Name=?s, Type=?s, View=?s, Cache=?s, Model=?s, Method=?s, Status=?s WHERE Pattern=?s",
                $page_pattern, $page_name, $page_type, $page_view, $page_cache, $page_model, $page_method, $page_status, $page_pattern_old);

            $token = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_settings WHERE id=?i',1);

            echo' <form type="Get" action="">';
            echo' <div style="text-align: center"><a href="/admin/secure/settings/'.$token[0]['Token'].'?submit=reset-cache"><span class="btn btn-outline-success"><h6>Done, reset cache to get changes immediately</h6></span></a></div>';
            echo' </form>';
        } catch (Exception $error) {

            echo '<div style="text-align: center"><span class="btn btn-danger">INTERNAL ERROR<br>Line 113: ajax_model: admin_edit_url()<hr>'.$error.'<hr>Contact with developer !</span></div>.';
        }


    }


    public function admin_validate_edit_url()
    {


        $page_status = $_POST['data'][0]['value'];
        $page_name = $_POST['data'][1]['value'];
        $page_pattern = $_POST['data'][2]['value'];
        $page_model = $_POST['data'][3]['value'];
        $page_method = $_POST['data'][4]['value'];
        $page_view = $_POST['data'][5]['value'];
        $page_type = $_POST['data'][6]['value'];
        $page_cache = $_POST['data'][7]['value'];



        //$outgoing = '[{name:'. $page_name.',pattern:'. $page_pattern.',type:'. $page_type.',model:'. $page_model.',method:'. $page_method.',view:'. $page_view.',cache:'. $page_pattern.'}]';
        $outgoing['name'] = $page_name;
        $outgoing['pattern'] = $page_pattern;
        $outgoing['model'] = $page_model;
        $outgoing['method'] = $page_method;
        $outgoing['view'] = $page_view;
        $outgoing['type'] = $page_type;
        $outgoing['cache'] = $page_cache;
        $outgoing['status'] = $page_status;

        //echo '<pre>';
        echo json_encode($outgoing);
        //var_dump($_POST['data']);
        /// echo '</pre>';
    }

    public function admin_validate_delete_url()
    {


        $outgoing['pattern'] = $_POST['data'][2]['value'];

        //echo $_POST['data'][1]['value'];
        echo json_encode($outgoing);
    }

    public function admin_delete_url()
    {


        try {

            DataBase::getInstance()->getDB()->query("DELETE FROM c_urls WHERE Pattern=?s", $_POST['data']);
            $token = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_settings WHERE id=?i',1);

            echo' <form type="Get" action="">';
            echo' <div style="text-align: center"><a href="/admin/secure/settings/'.$token[0]['Token'].'?submit=reset-cache"><span class="btn btn-outline-success"><h6>Done, reset cache to get changes immediately</h6></span></a></div>';
            echo' </form>';

        } catch (Exception $error) {

            echo '<div style="text-align: center"><span class="btn btn-warning">INTERNAL ERROR<br>Line 168: ajax_model: admin_delete_url()<hr>'.$error.'<hr>Contact with developer !</span></div>.';
        }

    }


    public function admin_add_url()
    {



        $page_name = $_POST['data'][0]['value'];
        $page_pattern = $_POST['data'][1]['value'];
        $page_model = $_POST['data'][2]['value'];
        $page_method = $_POST['data'][3]['value'];
        $page_view = $_POST['data'][4]['value'];
        $page_type = $_POST['data'][5]['value'];
        $page_cache = $_POST['data'][6]['value'];
        $page_status = $_POST['data'][7]['value'];



        if(empty($page_name) or empty($page_pattern) or empty($page_type) or empty($page_model) or empty($page_method) or empty($page_view) or empty($page_cache) or empty($page_status)){

            echo '<div style="text-align: center"><span class="btn btn-warning"><h5>All fields should be filled</h5></span></div>';
            die();
        }

        $page_pattern = trim($page_pattern);
        if(!preg_match('(^\\(\\^.{1,}\\$\\)$)',$page_pattern)){

            echo '<br><br><div style="text-align: center"><span class="btn btn-warning"><h5>Pattern mask is wrong, try to use "(^....$)"</h5></span></div>';
            die();
        }

        try {

            if(!DataBase::getInstance()->getDB()->getAll("SELECT * FROM c_urls WHERE Pattern=?s",$page_pattern)){

                DataBase::getInstance()->getDB()->query("INSERT INTO c_urls (Pattern, Name, Type, View, Cache, Model, Method, Status) VALUES (?s, ?s, ?s, ?s, ?s, ?s, ?s, ?s)",
                    $page_pattern, $page_name, $page_type, $page_view, $page_cache, $page_model, $page_method, $page_status);

                $token = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_settings WHERE id=?i',1);

                echo' <form type="Get" action="">';
                echo' <div style="text-align: center"><a href="/admin/secure/settings/'.$token[0]['Token'].'?submit=reset-cache"><span class="btn btn-outline-success"><h6>Done, reset cache to get changes immediately</h6></span></a></div>';
                echo' </form>';

            }else{

                echo '<div style="text-align: center"><span class="btn btn-danger"><h5>Already exist</h5></span></div>';
            }


        } catch (Exception $error) {

            echo '<div style="text-align: center"><span class="btn btn-danger">INTERNAL ERROR<br>Line 218: ajax_model: admin_add_url()<hr>'.$error.'<hr>Contact with developer !</span></div>.';
        }

    }

    public function admin_add_employee(){


        if(empty($_POST['data'][0]['value']) or empty($_POST['data'][1]['value']) or empty($_POST['data'][2]['value']) or empty($_POST['data'][3]['value']) or empty($_POST['data'][4]['value'])){

            echo '<div style="text-align: center"><span class="btn btn-warning"><h5>All fields should be filled</h5></span></div>';

        }else{

            try {

                if(!DataBase::getInstance()->getDB()->getAll("SELECT * FROM c_employee WHERE Email=?s",$_POST['data'][2]['value'])){

                    DataBase::getInstance()->getDB()->query("INSERT INTO c_employee (FirstName, LastName, Email, Password, Role) VALUES (?s, ?s, ?s, ?s, ?s)",$_POST['data'][0]['value'],
                        $_POST['data'][1]['value'],$_POST['data'][2]['value'],$_POST['data'][3]['value'],$_POST['data'][4]['value']);

                    $token = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_settings WHERE id=?i',1);

                    echo' <form type="Get" action="">';
                    echo' <div style="text-align: center"><a href="/admin/secure/settings/'.$token[0]['Token'].'?submit=reset-cache"><span class="btn btn-outline-success"><h6>Done, reset cache to get changes immediately</h6></span></a></div>';
                    echo' </form>';

                }else{

                    echo '<div style="text-align: center"><span class="btn btn-warning"><h5>Already exist</h5></span></div>';
                }


            } catch (Exception $error) {

                echo '<div style="text-align: center"><span class="btn btn-danger">INTERNAL ERROR<br>Line 218: ajax_model: admin_add_url()<hr>'.$error.'<hr>Contact with developer !</span></div>.';
            }
        }

    }

    public function activate_student(){


        $first_name = trim($_POST['first-name'], " \t\n\r \v");
        $surename = trim($_POST['surname'], " \t\n\r \v");
        $email =  trim($_POST['email'], " \t\n\r \v");
        $addinfo = trim($_POST['additionalInfo'], " \t\n\r \v");
        $phone = trim($_POST['phone'], " \t\n\r \v");
        $skype = trim($_POST['skype'], " \t\n\r \v");
        $gender = trim($_POST['gender'], " \t\n\r \v");
        $age = trim($_POST['age'], " \t\n\r \v");
        $level = trim($_POST['level'], " \t\n\r \v");

        try{

            /**
             * ///////////FIRS NAME/////////////////////////////////
             */
            if(empty($first_name)){
                throw new Exception('Name should be filled');
            }

            if(!preg_match('/^[a-zA-Zа-яА-я0-9]{3,}$/u',$first_name)){
                throw new Exception('Name has a wrong format or contain spaces');
            }
            /**
             * //////////////////////////////////////////////////////
             */

            /**
             * ///////////Surname/////////////////////////////////
             */
            if(empty($surename)){
                throw new Exception('Surname should be filled');
            }

            if(!preg_match('/^[a-zA-Zа-яА-я0-9]{3,}$/u',$surename)){
                throw new Exception('Surname has a wrong format or contain spaces');
            }
            /**
             * //////////////////////////////////////////////////////
             */
            if(empty($email)){
                throw new Exception('Student hasn\'t been found');
            }

            if(!preg_match('/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u' ,$email)){
                throw new Exception('Student hasn\'t been found');
            }
            /**
             * ///////////PHONE//////////////////////////////////////
             */
            if(empty($phone) or $phone == '+'){
                throw new Exception('Phone should be filled');
            }

            if(!preg_match('/^\+[0-9]{10,13}$/', $phone)){
                throw new Exception('Phone has a wrong format or contain spaces');
            }

            if(empty($skype)){
                throw new Exception('Skype should be filled');
            }

            if(empty($age)){
                throw new Exception('Age should be filled');
            }

            if(!preg_match('/^[0-9]+$/u',$age)){
                throw new Exception('Age has a wrong format or contain spaces');
            }

            if(empty($gender)){
                throw new Exception('Gender should be filled');
            }

            if(empty($level)){
                throw new Exception('Level should be filled');
            }


            $student = DataBase::getInstance()->getDB()->getRow('SELECT * FROM c_students WHERE Email=?s AND Status=?s', $email, 'not-active');

            if($student){

                $token = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_settings WHERE id=?i',1);


                DataBase::getInstance()->getDB()->query('UPDATE c_students SET LastName=?s, Skype=?s, AddInfo=?s, Gender=?s, Age=?i, Level=?s, Status=?s WHERE Email=?s',
                    $first_name, $skype, $addinfo, $gender, $age, $level, 'active', $email);

                $mail = new EmailSender();
                $message = file_get_contents(URL_ROOT.'/views/email/templates/ActivationCompleteEmail.html');

                $personal_data = array(
                    'FirstName'=> $first_name,
                    'Email'=> $email,
                    'Date'=>date('Y-m-d'),
                    'Time'=>date('H:i'),
                    'WebSite'=> $_SERVER['HTTP_HOST'],
                    'Phone'=> $phone,
                    'Password'=> $student['Password']
                );



                $mail->sendEmail($email,'Активация завершена',$message,  $personal_data);

                echo '<script>document.getElementById(\'activateStudentForm\').reset();</script>';

                echo' <div style="text-align: center"><a href="/admin/secure/students/'.$token[0]['Token'].'"><span class="btn btn-outline-success"><h6>Done, update page to get changes immediately</h6></span></a></div>';
            }




        }catch (Exception $e){

            echo '<div style="text-align: center"><span class="btn btn-warning"><h5>'.$e->getMessage().'</h5></span></div>';
        }

    }

    public function delete_student(){


        try{

            $token = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_settings WHERE id=?i',1);

            DataBase::getInstance()->getDB()->query('DELETE FROM c_students WHERE Email=?s',$_POST['email']);
            echo '<script>document.getElementById(\'deleteStudentForm\').reset();</script>';
            echo' <div style="text-align: center"><a href="/admin/secure/students/'.$token[0]['Token'].'"><span class="btn btn-outline-success"><h6>Done, update page to get changes immediately</h6></span></a></div>';
        }catch (Exception $e){
            $e->getMessage();
        }

    }


    public function edit_student (){

        $data =[];
        $courses =[];

        /**
         * Separate courses and other data
         */
        foreach ($_POST['Data'] as $key=> $value){

            if($key >= 10){
                array_push($courses, array('id'=> $value['value']));
            }else{

                $data[$value['name']]=$value['value'];
            }
        }


        $courses_delete =[];

        $courses_db = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_courses');


        /**
         * Convert courses data by index id=index in the array
         */
        foreach ($courses_db as $key => $value){
            $courses_delete[$value['id']]=$value['id'];
        }

        /**
         * Prepare arr courses for delete
         */
        foreach ($courses as $value){
            unset($courses_delete[$value['id']]);
        }


        $student_func = new Students();
        $student = DataBase::getInstance()->getDB()->getRow('SELECT * FROM c_students WHERE Email=?s',$data['email']);
        $student_func->setCOURSES(json_decode($student['Courses'],true));

        /**
         * Delete courses
         */
        foreach ($courses_delete as $value){
           $student_func->deleteCourse($value, $student['id']);
        }


        $courses_add =[];
        /**
         * Prepare array for adding courses id=index array
         */
        foreach ($courses_db as $value){
            $courses_add[$value['id']]['id']=$value['id'];
            $courses_add[$value['id']]['Name']=$value['Name'];
            $courses_add[$value['id']]['Period']=$value['Period'];
        }

        /**
         * Add new courses
         */
       foreach ($courses as $value){

            $student_func->addCourse($student['id'], $courses_add[$value['id']]['id'], $courses_add[$value['id']]['Name'],'0', $courses_add[$value['id']]['Period']);
       }

        $first_name = trim($data['first-name'], " \t\n\r \v");
        $surename = trim($data['surname'], " \t\n\r \v");
        $email =  trim($data['email'], " \t\n\r \v");
        $addinfo = trim($data['additionalInfo'], " \t\n\r \v");
        $phone = trim($data['phone'], " \t\n\r \v");
        $skype = trim($data['skype'], " \t\n\r \v");
        $gender = trim($data['gender'], " \t\n\r \v");
        $age = trim($data['age'], " \t\n\r \v");
        $level = trim($data['level'], " \t\n\r \v");
        $active_cours = trim($data['activeCourse'], " \t\n\r \v");


        try{


           /**
            * ///////////FIRS NAME/////////////////////////////////
            */
           if(empty($first_name)){
               throw new Exception('Name should be filled');
           }

           if(!preg_match('/^[a-zA-Zа-яА-я0-9]{3,}$/u',$first_name)){
               throw new Exception('Name has a wrong format or contain spaces');
           }
           /**
            * //////////////////////////////////////////////////////
            */

           /**
            * ///////////Surname/////////////////////////////////
            */
           if(empty($surename)){
               throw new Exception('Surname should be filled');
           }

           if(!preg_match('/^[a-zA-Zа-яА-я0-9]{3,}$/u',$surename)){
               throw new Exception('Surname has a wrong format or contain spaces');
           }
           /**
            * //////////////////////////////////////////////////////
            */
           if(empty($email)){
               throw new Exception('Student hasn\'t been found');
           }

           if(!preg_match('/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u' ,$email)){
               throw new Exception('Student hasn\'t been found');
           }
           /**
            * ///////////PHONE//////////////////////////////////////
            */
           if(empty($phone) or $phone == '+'){
               throw new Exception('Phone should be filled');
           }

           if(!preg_match('/^\+[0-9]{10,13}$/', $phone)){
               throw new Exception('Phone has a wrong format or contain spaces');
           }

           if(empty($skype)){
               throw new Exception('Skype should be filled');
           }

           if(empty($age)){
               throw new Exception('Age should be filled');
           }

           if(!preg_match('/^[0-9]+$/u',$age)){
               throw new Exception('Age has a wrong format or contain spaces');
           }

           if(empty($gender)){
               throw new Exception('Gender should be filled');
           }

           if(empty($level)){
               throw new Exception('Level should be filled');
           }


           DataBase::getInstance()->getDB()->query('UPDATE c_students SET FirstName=?s, LastName=?s, Skype=?s, AddInfo=?s, Gender=?s, Age=?i, Level=?s, ActiveCourse=?i WHERE Email=?s',
               $first_name, $surename, $skype, $addinfo, $gender, $age, $level, (int)$active_cours, $email);

           //echo '<script>document.getElementById(\'activateStudentForm\').reset();</script>';

           $token = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_settings WHERE id=?i',1);
            //echo '<script>document.getElementById(\'editStudentForm\').reset();</script>';
           echo' <div style="text-align: center"><a href="/admin/secure/students/'.$token[0]['Token'].'"><span class="btn btn-outline-success"><h6>Done, update page to get changes immediately</h6></span></a></div>';

       }catch (Exception $e){

            echo '<div style="text-align: center"><span class="btn btn-warning"><h5>'.$e->getMessage().'</h5></span></div>';

       }

    }

    public function add_block(){

        if(empty($_POST['data'][0]['value']) or empty($_POST['data'][1]['value'])){

            echo '<div style="text-align: center"><span class="btn btn-warning"><h5>All fields should be filled</h5></span></div>';

        }else{

            try {

                if(!DataBase::getInstance()->getDB()->getAll("SELECT * FROM c_restricted_person WHERE IP=?s",$_POST['data'][0]['value'])){

                    DataBase::getInstance()->getDB()->query("INSERT INTO c_restricted_person (IP, Reason) VALUES (?s, ?s)",$_POST['data'][0]['value'],
                        $_POST['data'][1]['value']);

                    $token = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_settings WHERE id=?i',1);

                    echo' <form type="Get" action="">';
                    echo' <div style="text-align: center"><a href="/admin/secure/entrance/'.$token[0]['Token'].'"><span class="btn btn-outline-success"><h6>Done, update page to get changes immediately</h6></span></a></div>';
                    echo' </form>';

                }else{

                    echo '<div style="text-align: center"><span class="btn btn-warning"><h5>Already exist</h5></span></div>';
                }


            } catch (Exception $error) {

                echo '<div style="text-align: center"><span class="btn btn-danger">INTERNAL ERROR<br>Line 218: ajax_model: admin_add_url()<hr>'.$error.'<hr>Contact with developer !</span></div>.';
            }
        }
    }

    public function delete_block_validate(){

        $outgoing['ip'] = $_POST['data'][0]['value'];
        echo json_encode($outgoing);
    }

    public function delete_block(){

        try {

            DataBase::getInstance()->getDB()->query("DELETE FROM c_restricted_person WHERE IP=?s", $_POST['data']);
            $token = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_settings WHERE id=?i',1);

            echo' <form type="Get" action="">';
            echo' <div style="text-align: center"><a href="/admin/secure/entrance/'.$token[0]['Token'].'"><span class="btn btn-outline-success"><h6>Done, update page to get changes immediately</h6></span></a></div>';
            echo' </form>';

        } catch (Exception $error) {

            echo '<div style="text-align: center"><span class="btn btn-warning">INTERNAL ERROR<br>Line 168: ajax_model: admin_delete_url()<hr>'.$error.'<hr>Contact with developer !</span></div>.';
        }
    }

    public function upload_lesson_material(){


        header('Content-Type: text/plain; charset=utf-8');

        try {

            if(empty($_POST['name']) or empty($_POST['course']) or empty($_POST['description'])){

                throw new RuntimeException('All fields should be filled.');

            }else {

                       require_once URL_ROOT.'/core/Libs/Basic/General/FileUpload.php';

                    /**
                     * PDF Upload
                     */
                       $file_upload = new FileUpload();
                       $file_upload->upload('pdf',URL_ROOT.'/private/content/lessons/pdf/', array('pdf' => 'application/pdf'),10000000);
                       $pdf_file_name = $file_upload->getFILENAME();
                    /**
                     * -------------------
                     */


                    /**
                     * Image Upload
                     */
                    $file_upload->upload('image',
                        URL_ROOT.'/private/content/lessons/images/',
                        array('gif' => 'image/gif','jpeg'=>'image/jpeg',
                            'png'=>'image/png'),
                        10000000);
                    $image_file_name = $file_upload->getFILENAME();
                    $image_url= md5(getenv("REMOTE_ADDR") . "key" . time()). md5(getenv("REMOTE_ADDR") . "key-2" .
                        time()). md5(getenv("REMOTE_ADDR") . "key-3" . time()).  md5($_POST['name'].$_POST['course'].'image');
                    /**
                     * -------------------
                     */



                    $audio_file_name = '';
                    $audio_url = '';
                    if(isset($_FILES['audio'])){
                        /**
                         * Audio Upload
                         */
                        $file_upload->upload('audio',URL_ROOT.'/private/content/lessons/audio/', array('mp3' => 'audio/mpeg'),10000000);
                        $audio_file_name  = $file_upload->getFILENAME();
                        $audio_url = md5(getenv("REMOTE_ADDR") . "key" . time()). md5(getenv("REMOTE_ADDR") . "key-2" .
                                time()). md5(getenv("REMOTE_ADDR") . "key-3" . time()).  md5($_POST['name'].$_POST['course']);
                        /**
                         * -------------------
                         */
                    }


                       $pdf_url= md5(getenv("REMOTE_ADDR") . "key" . time()). md5(getenv("REMOTE_ADDR") . "key-2" .
                            time()). md5(getenv("REMOTE_ADDR") . "key-3" . time()).  md5($_POST['name']);
                       $course = DataBase::getInstance()->getDB()->getRow('SELECT * FROM c_courses WHERE id=?i',$_POST['course']);

                       DataBase::getInstance()->getDB()->query("INSERT INTO c_lessons_pdf (Name, FileName, AudioFileName, ImageFileName, Description, CourseID, CourseName, PdfUrl, AudioUrl, ImageUrl) VALUES (?s, ?s, ?s, ?s, ?s, ?i, ?s, ?s, ?s, ?s)"
                           ,$_POST['name'], $pdf_file_name, $audio_file_name, $image_file_name, $_POST['description'], $_POST['course'] , $course['Name'],
                           $pdf_url, $audio_url, $image_url);


                    $token = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_settings WHERE id=?i',1);


                    echo '<script>document.getElementById(\'add-new-lesson-form\').reset();</script>';


                    echo' <form type="Get" action="">';

                    echo' <div style="text-align: center"><a href="/admin/secure/lessons/'.$token[0]['Token'].'"><span class="btn btn-outline-success"><h6>Done, update page to get changes immediately</h6></span></a></div>';

                    echo' </form>';

            }

        } catch (RuntimeException $e) {

            echo '<div style="text-align: center"><span class="btn btn-warning">'.$e->getMessage().'</span></div>.';


        }
    }

    public function change_lesson_material(){


        header('Content-Type: text/plain; charset=utf-8');


        try {

            if(empty($_POST['name']) or empty($_POST['course']) or empty($_POST['description'])){

                throw new RuntimeException('All fields should be filled.');

            }else {

                require_once URL_ROOT.'/core/Libs/Basic/General/FileUpload.php';
                $file_upload = new FileUpload();

                if($_POST['delete-audio'] == 'delete'){
                    //$audio = DataBase::getInstance()->getDB()->getRow('SELECT * FROM c_lessons_pdf WHERE id=?i',$_POST['id']);
                    DataBase::getInstance()->getDB()->query('UPDATE c_lessons_pdf Set AudioFileName=?s, AudioUrl=?s WHERE id=?i','','',$_POST['id']);
                   /*if (file_exists(URL_ROOT . '/private/content/lessons/audio/'.$audio['AudioFileName'])) {
                            unlink(URL_ROOT . '/private/content/lessons/audio/'.$audio['AudioFileName']);

                    }*/

                }

                if(isset($_FILES['pdf'])){

                    /**
                     * PDF Upload
                     */

                    $file_upload->upload('pdf',
                        URL_ROOT.'/private/content/lessons/pdf/',
                        array('pdf' => 'application/pdf'),
                        1000000);
                    $pdf_file_name = $file_upload->getFILENAME();
                    $pdf_url= md5(getenv("REMOTE_ADDR") . "key" . time()). md5(getenv("REMOTE_ADDR") . "key-2" .
                            time()). md5(getenv("REMOTE_ADDR") . "key-3" . time()).  md5($_POST['name']);

                    DataBase::getInstance()->getDB()->query("UPDATE c_lessons_pdf SET FileName=?s, PdfUrl=?s WHERE id=?i"
                        ,$pdf_file_name,$pdf_url, $_POST['id']);
                    /**
                     * -------------------
                     */
                }

                if(isset($_FILES['image'])){

                    /**
                     * Image Upload
                     */
                    $file_upload->upload('image',
                        URL_ROOT.'/private/content/lessons/images/',
                        array('gif' => 'image/gif','jpeg'=>'image/jpeg',
                            'png'=>'image/png'),
                        10000000);
                    $image_file_name = $file_upload->getFILENAME();
                    $image_url= md5(getenv("REMOTE_ADDR") . "key" . time()). md5(getenv("REMOTE_ADDR") . "key-2" .
                            time()). md5(getenv("REMOTE_ADDR") . "key-3" . time()).  md5($_POST['name'].$_POST['course'].'image');
                    DataBase::getInstance()->getDB()->query("UPDATE c_lessons_pdf SET ImageFileName=?s, ImageUrl=?s WHERE id=?i"
                        ,$image_file_name, $image_url, $_POST['id']);
                    /**
                     * -------------------
                     */
                }


                if(isset($_FILES['audio'])){
                    /**
                     * Audio Upload
                     */
                    $file_upload->upload('audio',
                        URL_ROOT.'/private/content/lessons/audio/',
                        array('mp3' => 'audio/mpeg'),
                        1000000);
                    $audio_file_name  = $file_upload->getFILENAME();
                    $audio_url = md5(getenv("REMOTE_ADDR") . "key" . time()). md5(getenv("REMOTE_ADDR") . "key-2" .
                            time()). md5(getenv("REMOTE_ADDR") . "key-3" . time()).  md5($_POST['name'].$_POST['course']);
                    DataBase::getInstance()->getDB()->query("UPDATE c_lessons_pdf SET AudioFileName=?s, AudioUrl=?s WHERE id=?i"
                        ,$audio_file_name, $audio_url, $_POST['id']);
                    /**
                     * -------------------
                     */
                }



                $course = DataBase::getInstance()->getDB()->getRow('SELECT * FROM c_courses WHERE id=?i',$_POST['course']);


                DataBase::getInstance()->getDB()->query("UPDATE c_lessons_pdf SET Name=?s, Description=?s, CourseID=?i, CourseName=?s WHERE id=?i"
                    ,$_POST['name'], $_POST['description'],$_POST['course'],$course['Name'], $_POST['id']);


                $token = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_settings WHERE id=?i',1);


                echo '<script>document.getElementById(\'add-new-lesson-form\').reset();</script>';

                echo' <form type="Get" action="">';

                echo' <div style="text-align: center"><a href="/admin/secure/lessons/'.$token[0]['Token'].'"><span class="btn btn-outline-success"><h6>Done, update page to get changes immediately</h6></span></a></div>';

                echo' </form>';

            }

        } catch (RuntimeException $e) {

            echo '<div style="text-align: center"><span class="btn btn-warning">'.$e->getMessage().'</span></div>.';


        }


    }

    public function delete_lesson_material(){

        try {

            DataBase::getInstance()->getDB()->query("DELETE FROM c_lessons_pdf WHERE id=?i", $_POST['id']);
            $token = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_settings WHERE id=?i',1);

            echo' <form type="Get" action="">';
            echo' <div style="text-align: center"><a href="/admin/secure/lessons/'.$token[0]['Token'].'"><span class="btn btn-outline-success"><h6>Done, update page to get changes immediately</h6></span></a></div>';
            echo' </form>';

        } catch (Exception $e) {

            echo '<div style="text-align: center"><span class="btn btn-warning">'.$e->getMessage().'</span></div>.';
        }
    }

    public function register_new_user(){

       $first_name = $_POST['name'];
       $email= $_POST['email'];
       $phone = $_POST['phone'];
        try{
            /**
             * ///////////FIRS NAME/////////////////////////////////
             */
            if(empty($first_name)){
               throw new Exception('Name should be filled');
            }

            if(!preg_match('/^[a-zA-Zа-яА-я0-9]{3,}$/u',$first_name)){
                throw new Exception('Name has a wrong format');
            }
            /**
             * //////////////////////////////////////////////////////
             */

            /**
             * ///////////EMAIL//////////////////////////////////////
             */
            if(empty($email)){
                throw new Exception('Email should be filled');
            }

            if(!preg_match('/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u' ,$email)){
                throw new Exception('Email has a wrong format');
            }
            /**
             * //////////////////////////////////////////////////////
             */
            /**
             * ///////////PHONE//////////////////////////////////////
             */
            if(empty($phone) or $phone == '+'){
                throw new Exception('Phone should be filled');
            }

            if(!preg_match('/^\+[0-9]{10,13}$/',$phone)){
                throw new Exception('Phone has a wrong format');
            }
            /**
             * ////////////////////////////////////////////////////////
             */

            $user =DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_students WHERE Email=?s OR Phone=?s',$email, $phone);

            if($user){
                throw new Exception('Вы уже подали заявку, ожидайте когда с вами свяжется наш преподователь.');
            }else{
                /**
                 * Register new student
                 */

                /**
                 * Generate new random password
                 */
                $chars="qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";
                $max=12;
                $size=StrLen($chars)-1;
                $password=null;
                while($max--){
                    $password.=$chars[rand(0,$size)];
                }

                DataBase::getInstance()->getDB()->query('INSERT INTO c_students (FirstName, Password,  Email, Phone, Ip, Referal) VALUES (?s,?s,?s,?s,?s,?s)',
                    $first_name, $password ,$email, $phone, $_SERVER['REMOTE_ADDR'],  md5(getenv("REMOTE_ADDR") . "key" . time()));

                $mail = new EmailSender();
                $message = file_get_contents(URL_ROOT.'/views/email/templates/WelcomeEmail.html');

                $personal_data = array(
                    'FirstName'=> $first_name,
                    'Email'=> $email,
                    'Date'=>date('Y-m-d'),
                    'Time'=>date('H:i'),
                    'WebSite'=> $_SERVER['HTTP_HOST'],
                    'Phone'=> $phone,
                    'Password'=> $password
                );



                $mail->sendEmail($email,'Добро Пожаловать',$message,  $personal_data);
            }


            echo '<script>$("#name").val(\'\');</script>';
            echo '<script>$("#email").val(\'\');</script>';
            echo '<script>$("#phone").val(\'\');</script>';
            echo '<script>$("#register-new-user-block").remove();</script>';
            echo '<script>$("#register-new-user-message").append(\'Done\');</script>';

        }catch (Exception $e){

            echo $e->getMessage();
        }


    }

    public function login(){

        $email = $_POST['email'];
        $password =$_POST['password'];

        try{
            /**
             * ///////////EMAIL//////////////////////////////////////
             */
            if(empty($email)){
                throw new Exception('Email should be filled');
            }

            if(!preg_match('/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u' ,$email)){
                throw new Exception('Email has a wrong format');
            }
            /**
             * //////////////////////////////////////////////////////
             */
            /**
             * ///////////PASSWORD/////////////////////////////////////
             */
            if(empty($password)){
                throw new Exception('Password should be filled');
            }

            /*if(!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/',$password)){

                throw new Exception('Password has a wrong format<br>The password must contain at least 8 characters including numbers and upper and lower case letters');
            }*/



            $student = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_students WHERE Email=?s AND Password=?s',$email, $password);

            if($student){

                if($student[0]['Status']=='not-active'){
                    throw new Exception('Your account should be active');
                }
                /**
                 * Generate new Hash for cookie
                 */
                $hash = md5(getenv("REMOTE_ADDR"). time()). md5($email.time()).md5($password.time());

                /**
                 * Set new Hash for Student
                 */
                DataBase::getInstance()->getDB()->query('UPDATE c_students SET Hash=?s WHERE id=?s AND Email=?s AND Password=?s',$hash, $student[0]['id'],$email, $password);

                /**
                 * Set Cookie
                 */
                setcookie('s-id', $student[0]['id'],time()+36000,"/");
                setcookie('s-hash', $hash,time()+36000,"/");

                /**
                 * Redirect to dashboard page
                 */
                echo '<script>document.location.replace("/account");</script>';

            }else{

                $teacher = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_teacher WHERE Email=?s AND Password=?s',$email, $password);

                if($teacher){

                    if($teacher[0]['Status']=='not-active'){
                        throw new Exception('Your account should be active');
                    }
                    /**
                     * Generate new Hash for cookie
                     */
                    $hash = md5(getenv("REMOTE_ADDR"). time()). md5($email.time()).md5($password.time());

                    /**
                     * Set new Hash for Teacher
                     */
                    DataBase::getInstance()->getDB()->query('UPDATE c_teacher SET Hash=?s WHERE id=?s AND Email=?s AND Password=?s',$hash, $teacher[0]['id'],$email, $password);

                    /**
                     * Set Cookie
                     */
                    setcookie('t-id', $teacher[0]['id'],time()+36000,"/");
                    setcookie('t-hash', $hash,time()+36000,"/");

                    /**
                     * Redirect to dashboard page
                     */
                    echo '<script>document.location.replace("/teacher/dashboard");</script>';

                }else{

                    throw new Exception('Wrong password or email !');
                }


            }

        }catch (Exception $e){
            echo $e->getMessage();
        }


    }


    public function add_feedback(){


        if(empty($_POST['rating'])){

            echo 'rating empty';
            die;
        }

        if(empty($_POST['feedback-text'])){

            echo 'feedback-text empty';
            die;
        }

        if(!preg_match('/^[1|2|3|4|5]$/', $_POST['rating'], $out)) {

            echo 'rating wrong format';
            die;
        }

        if(!preg_match('/^[0-9]{2,2}[:][0-9]{2,2}$/', $_POST['time'], $out)){
            echo 'time wrong format';
            die;
        }

        if(!preg_match('/^[0-9]{4,4}[-][0-9]{2,2}[-][0-9]{2,2}$/',$_POST['date'], $out)){
            echo 'date wrong format';
            die;
        }


        $student = new Students();

        /**
         * If isn't login then redirect to login page
         */
        if (!$student->isLogin()) {

            header('Location:/login');
            die();
        }

        try{

            //http://127.0.0.1/account/lesson-feedback/?date=2018-05-09&time=00:01
            //http://127.0.0.1/account/lesson-feedback/?date=2018-05-08&time=23:01
            $lesson = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_lessons WHERE Date=?s AND Time=?s AND StudentID=?i  AND Status=?s',
                $_POST['date'], $_POST['time'], $student->getID(), 'completed');

            if($lesson){

                $feedback = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_lessons_feedback WHERE Date=?s AND Time=?s AND StudentID=?i ',
                    $_POST['date'], $_POST['time'], $student->getID());

                if($feedback){
                    echo 'Feedback was already added';
                    die();
                }

                DataBase::getInstance()->getDB()->query('INSERT INTO c_lessons_feedback (Date, Time, StudentID, Text, Evaluation, Status) VALUES (?s,?s,?i,?s,?s,?s)',
                    $_POST['date'],$_POST['time'], $student->getID(), $_POST['feedback-text'], $_POST['rating'], 'closed');

                DataBase::getInstance()->getDB()->query('UPDATE c_lessons SET FeedBack=?s WHERE Date=?s AND Time=?s AND StudentID=?i',
                    'closed', $_POST['date'], $_POST['time'], $student->getID());

                echo '<script>document.getElementById(\'feedback-form\').reset();</script>';
                echo '<script>$("#feedback-form").remove();</script>';
                echo '<script>$("#feedback-message").append(\'Ваш отзыв был успешно добавлен!\');</script>';

            }else{

               echo  'Sorry, but lesson wasn\'t find';
            }


        }catch (Exception $e){

            echo $e->getMessage();
        }



    }

    public function for_lesson_completed(){

        $teacher = new Teacher();
        $student = new Students();
        /**
         * If isn't login then redirect to login page
         */
        if (!$teacher->isLogin()) {

            UrlsDispatcher::getInstance()->setCurrentUrlData(UrlsDispatcher::getInstance()->getUrlsDataListByKey('(^)'));
            $controller = new Controller();
        }



        if(!preg_match('/^[1|2|3|4|5]$/', $_POST['Data'][0]['value'], $out)) {

            echo 'rating wrong format';
            die;
        }

        if(!preg_match('/^[0-9]{4,4}[-][0-9]{2,2}[-][0-9]{2,2}$/', $_POST['Data'][2]['value'], $out)){
            echo 'date wrong format';
            die;
        }

        if(!preg_match('/^[0-9]{2,2}[:][0-9]{2,2}$/', $_POST['Data'][3]['value'], $out)){
            echo 'time wrong format';
            die;
        }

        if(!preg_match('/^[0-9a-zA-Z]+$/', $_POST['Data'][4]['value'], $out)){
            echo 'token wrong format';
            die;
        }


         $studentID =  DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_lessons WHERE Date=?s AND Time=?s AND Token=?s',
             $_POST['Data'][2]['value'], $_POST['Data'][3]['value'], $_POST['Data'][4]['value']);



         DataBase::getInstance()->getDB()->query('UPDATE c_lessons SET Status=?s, Estimation=?s, Comment=?s WHERE Date=?s AND Time=?s AND Token=?s',
                'completed', $_POST['Data'][0]['value'], $_POST['Data'][1]['value'], $_POST['Data'][2]['value'], $_POST['Data'][3]['value'], $_POST['Data'][4]['value']);

        $student->updateCourseLessonCount(1, $studentID[0]['StudentID']);


        echo '<script>document.getElementById(\'completeLessonForm\').reset();</script>';
        echo '<script>$("#completeLessonForm").remove();</script>';
        echo '<script>$("#lesson-complete-message").append(\'Информация сохранена!\');</script>';


    }


    public function add_course(){
        try{
            if(empty($_POST['name']) or
                empty($_POST['course-description']) or
                empty($_POST['level']) or
                empty($_POST['price']) or
                empty($_POST['duration'])){
                throw new ErrorException('All fields should be filled ');

            }

            if(!preg_match('/^[0-9]*[.]?[0-9]+(?:[eE][-+]?[0-9]+)?$/',$_POST['price'], $out)) {

                throw new ErrorException('Price has wrong format');
            }

            if(!preg_match('/^[0-9]+$/',$_POST['duration'], $out)) {

                throw new ErrorException('Duration has wrong format');
            }

            if(!preg_match('/^[0-9]+$/',$_POST['score'], $out)) {

                throw new ErrorException('Score has wrong format');
            }

            DataBase::getInstance()->getDB()->query('INSERT INTO c_courses (Name, Level, Description, Price, Period, Score) VALUES (?s,?s,?s,?i,?i,?i)',
                $_POST['name'], $_POST['level'], $_POST['course-description'], $_POST['price'],$_POST['duration'],$_POST['score']);


            $token = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_settings WHERE id=?i',1);

            echo '<script>document.getElementById(\'add-new-course-form\').reset();</script>';

            echo' <form type="Get" action="">';

            echo' <div style="text-align: center"><a href="/admin/secure/courses/'.$token[0]['Token'].'"><span class="btn btn-outline-success"><h6>Done, update page to get changes immediately</h6></span></a></div>';

            echo' </form>';

        }catch (ErrorException $e){

            echo '<div style="text-align: center"><span class="btn btn-warning">'.$e->getMessage().'</span></div>.';
        }


        //
    }

    public function edit_course(){

        try{
            if( empty($_POST['id']) or
                empty($_POST['name']) or
                empty($_POST['description']) or
                empty($_POST['level']) or
                empty($_POST['price']) or
                empty($_POST['duration'])){
                throw new ErrorException('All fields should be filled ');

            }

            if(!preg_match('/^[0-9]*[.]?[0-9]+(?:[eE][-+]?[0-9]+)?$/',$_POST['price'], $out)) {

                throw new ErrorException('Price has wrong format');
            }

            if(!preg_match('/^[0-9]+$/',$_POST['duration'], $out)) {

                throw new ErrorException('Duration has wrong format');
            }

            if(!preg_match('/^[0-9]+$/',$_POST['score'], $out)) {

                throw new ErrorException('Score has wrong format');
            }

            DataBase::getInstance()->getDB()->query('UPDATE c_courses SET Name=?s, Level=?s, Description=?s, Price=?i, Period=?i, Score=?i WHERE id=?i',
                $_POST['name'], $_POST['level'], $_POST['description'], $_POST['price'],$_POST['duration'],$_POST['score'], $_POST['id']);


            $token = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_settings WHERE id=?i',1);

            echo '<script>document.getElementById(\'change-course-form\').reset();</script>';

            echo' <form type="Get" action="">';

            echo' <div style="text-align: center"><a href="/admin/secure/courses/'.$token[0]['Token'].'"><span class="btn btn-outline-success"><h6>Done, update page to get changes immediately</h6></span></a></div>';

            echo' </form>';

        }catch (ErrorException $e){

            echo '<div style="text-align: center"><span class="btn btn-warning">'.$e->getMessage().'</span></div>.';
        }

    }

    public function delete_course(){

        try {

            DataBase::getInstance()->getDB()->query("DELETE FROM c_courses WHERE id=?i", $_POST['id']);
            $token = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_settings WHERE id=?i',1);

            echo' <form type="Get" action="">';
            echo' <div style="text-align: center"><a href="/admin/secure/courses/'.$token[0]['Token'].'"><span class="btn btn-outline-success"><h6>Done, update page to get changes immediately</h6></span></a></div>';
            echo' </form>';

        } catch (Exception $e) {

            echo '<div style="text-align: center"><span class="btn btn-warning">'.$e->getMessage().'</span></div>.';
        }
    }

    public function add_teacher(){

        $first_name = trim($_POST['first-name'], " \t\n\r \v");
        $surename = trim($_POST['surname'], " \t\n\r \v");
        $email =  trim($_POST['email'], " \t\n\r \v");
        $addinfo = trim($_POST['additionalInfo'], " \t\n\r \v");
        $phone = trim($_POST['phone'], " \t\n\r \v");
        $skype = trim($_POST['skype'], " \t\n\r \v");
        $gender = trim($_POST['gender'], " \t\n\r \v");
        $level = trim($_POST['level'], " \t\n\r \v");

        try{

            /**
             * ///////////FIRS NAME/////////////////////////////////
             */
            if(empty($first_name)){
                throw new Exception('Name should be filled');
            }

            if(!preg_match('/^[a-zA-Zа-яА-я0-9]{3,}$/u',$first_name)){
                throw new Exception('Name has a wrong format or contain spaces');
            }
            /**
             * //////////////////////////////////////////////////////
             */

            /**
             * ///////////Surname/////////////////////////////////
             */
            if(empty($surename)){
                throw new Exception('Surname should be filled');
            }

            if(!preg_match('/^[a-zA-Zа-яА-я0-9]{3,}$/u',$surename)){
                throw new Exception('Surname has a wrong format or contain spaces');
            }
            /**
             * //////////////////////////////////////////////////////
             */
            if(empty($email)){
                throw new Exception('Email hasn\'t been found');
            }

            if(!preg_match('/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u' ,$email)){
                throw new Exception('Email hasn\'t been found');
            }
            /**
             * ///////////PHONE//////////////////////////////////////
             */
            if(empty($phone) or $phone == '+'){
                throw new Exception('Phone should be filled');
            }

            if(!preg_match('/^\+[0-9]{10,13}$/', $phone)){
                throw new Exception('Phone has a wrong format or contain spaces');
            }

            if(empty($skype)){
                throw new Exception('Skype should be filled');
            }

            if(empty($gender)){
                throw new Exception('Gender should be filled');
            }

            if(empty($level)){
                throw new Exception('Level should be filled');
            }


            $teacher = DataBase::getInstance()->getDB()->getRow('SELECT * FROM c_teacher WHERE Email=?s AND Status=?s', $email, 'not-active');

            if(!$teacher){

                $token = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_settings WHERE id=?i',1);


                DataBase::getInstance()->getDB()->query('INSERT INTO c_teacher(FirstName, LastName, Skype, Phone, AddInfo, Gender, Level, Status, Email) VALUES (?s,?s,?s,?s,?s,?s,?s,?s,?s)',
                    $first_name, $surename, $skype, $phone, $addinfo, $gender, $level, 'active', $email);

                $mail = new EmailSender();
                $message = file_get_contents(URL_ROOT.'/views/email/templates/ActivationCompleteEmail.html');

                /**
                 * Generate new random password
                 */
                $chars="qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";
                $max=12;
                $size=StrLen($chars)-1;
                $password=null;
                while($max--){
                    $password.=$chars[rand(0,$size)];
                }

                $personal_data = array(
                    'FirstName'=> $first_name,
                    'Email'=> $email,
                    'Date'=>date('Y-m-d'),
                    'Time'=>date('H:i'),
                    'WebSite'=> $_SERVER['HTTP_HOST'],
                    'Phone'=> $phone,
                    'Password'=> $password
                );



                $mail->sendEmail($email,'Активация завершена',$message,  $personal_data);

                echo '<script>document.getElementById(\'add-new-teacher-form\').reset();</script>';

                echo' <div style="text-align: center"><a href="/admin/secure/teachers/'.$token[0]['Token'].'"><span class="btn btn-outline-success"><h6>Done, update page to get changes immediately</h6></span></a></div>';
            }else{

                throw new Exception("Teacher was already added");
            }




        }catch (Exception $e){

            echo '<div style="text-align: center"><span class="btn btn-warning"><h5>'.$e->getMessage().'</h5></span></div>';
        }
    }
  }