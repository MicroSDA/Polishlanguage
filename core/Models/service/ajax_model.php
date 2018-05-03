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

    public function admin_delete_employee(){


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

    public function upload_pdf(){


        header('Content-Type: text/plain; charset=utf-8');

        try {

            if(empty($_POST['name']) or empty($_POST['level']) ){

                echo '<div style="text-align: center"><span class="btn btn-warning"><h5>All fields should be filled</h5></span></div>';
                die();

            }else{

                if(!DataBase::getInstance()->getDB()->getAll("SELECT * FROM c_lessons_pdf WHERE Name=?s",$_POST['name'])){

                    // Undefined | Multiple Files | $_FILES Corruption Attack
                    // If this request falls under any of them, treat it invalid.
                    if (!isset($_FILES['file']['error']) || is_array($_FILES['file']['error'])) {
                        throw new RuntimeException('Invalid parameters.');
                    }

                    // Check $_FILES['upfile']['error'] value.
                    switch ($_FILES['file']['error']) {
                        case UPLOAD_ERR_OK:
                            break;
                        case UPLOAD_ERR_NO_FILE:
                            throw new RuntimeException('No file sent.');
                        case UPLOAD_ERR_INI_SIZE:
                        case UPLOAD_ERR_FORM_SIZE:
                            throw new RuntimeException('Exceeded filesize limit.');
                        default:
                            throw new RuntimeException('Unknown errors.');
                    }

                    // You should also check filesize here.
                    if ($_FILES['file']['size'] > 100000000) {
                        throw new RuntimeException('Exceeded filesize limit.');

                    }

                    // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
                    // Check MIME Type by yourself.
                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                    if (false === $ext = array_search(
                            $finfo->file($_FILES['file']['tmp_name']),
                            array(
                                'pdf' => 'application/pdf',
                            ),
                            true
                        )) {
                        throw new RuntimeException('Invalid file format.');
                    }

                    // You should name it uniquely.
                    // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
                    // On this example, obtain safe unique name from its binary data.
                    if (!move_uploaded_file($_FILES['file']['tmp_name'], sprintf('./private/content/lessons/%s',$_FILES['file']['name']))) {
                        throw new RuntimeException('Failed to move uploaded file.');
                    }

                    /**
                     * Success
                     */
                    $token = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_settings WHERE id=?i',1);
                    echo' <form type="Get" action="">';
                    echo' <div style="text-align: center"><a href="/admin/secure/lessons/'.$token[0]['Token'].'"><span class="btn btn-outline-success"><h6>Done, update page to get changes immediately</h6></span></a></div>';
                    echo' </form>';



                    $url= md5(getenv("REMOTE_ADDR") . "key" . time()). md5(getenv("REMOTE_ADDR") . "key-2" .
                            time()). md5(getenv("REMOTE_ADDR") . "key-3" . time()).  md5($_POST['name']);
                    DataBase::getInstance()->getDB()->query("INSERT INTO c_lessons_pdf (Name, FileName, Level, Url) VALUES (?s, ?s, ?s, ?s)",$_POST['name'],
                        $_FILES['file']['name'], $_POST['level'],$url);

                }else{

                    echo '<div style="text-align: center"><span class="btn btn-warning"><h5>Name already exist</h5></span></div>';
                    die();
                }

            }


        } catch (RuntimeException $e) {

            echo '<div style="text-align: center"><span class="btn btn-warning">'.$e->getMessage().'</span></div>.';


        }
    }

    public function register_new_user(){

       $first_name = $_POST['first-name'];
       $last_name = $_POST['last-name'];
       $email= $_POST['email'];
       $phone = $_POST['phone'];
       $skype = $_POST['skype'];
       $password = $_POST['password'];
       $confirm_password=$_POST['password-confirm'];

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
             * ///////////LAST NAME/////////////////////////////////
             */
            if(empty($last_name)){
                throw new Exception('Last name should be filled');
            }

            if(!preg_match('/^[a-zA-Zа-яА-я0-9]{3,}$/u',$last_name)){
                throw new Exception('Last has a wrong format');
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
            /**
             * ///////////PASSWORD/////////////////////////////////////
             */
            if(empty($password)){
                throw new Exception('Password should be filled');
            }

            if(!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/',$password)){

                throw new Exception('Password has a wrong format<br>The password must contain at least 8 characters including numbers and upper and lower case letters');
            }

            if(empty($confirm_password)){
                throw new Exception('Confirm password should be filled');
            }


            if($password!= $confirm_password){
                throw new Exception('Passwords mismatched');
            }
            /**
             * //////////////////////////////////////////////////////
             */

            if(empty($skype)){
                $skype = 'NO';
            }


            $user =DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_students WHERE Email=?s OR Phone=?s',$email, $phone);

            if($user){
                throw new Exception('Account with this email or phone already exist');
            }else{
                DataBase::getInstance()->getDB()->query('INSERT INTO c_students (FirstName, LastName, Email, Phone, Skype, Password, Ip) VALUES (?s,?s,?s,?s,?s,?s,?s)',
                    $first_name, $last_name, $email, $phone, $skype, $password, $_SERVER['REMOTE_ADDR']);
            }


            echo '<script>document.getElementById(\'register-new-user-form\').reset();</script>';
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

            if(!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/',$password)){

                throw new Exception('Password has a wrong format<br>The password must contain at least 8 characters including numbers and upper and lower case letters');
            }



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
                setcookie('id', $student[0]['id'],time()+36000,"/");
                setcookie('s-hash', $hash,time()+36000,"/");

                /**
                 * Redirect to dashboard page
                 */
                echo '<script>document.location.replace("/account");</script>';

            }else{

                throw new Exception('Wrong password or email !');
            }

        }catch (Exception $e){
            echo $e->getMessage();
        }


    }
}