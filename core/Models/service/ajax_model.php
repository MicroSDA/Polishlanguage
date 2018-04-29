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

            // UrlsDispatcher::getInstance()->setCurrentUrlData(array_pop(UrlsDispatcher::getInstance()->getUrlsDataList()));
            // $contorller = new Controller();

            foreach (getallheaders() as $name => $value) {
                echo "$name: $value"."<br>";
            }
            //die();
        }

        /**
         * Else, ok
         */

    }

    public function index()
    {

    }


    public function add()
    {

        foreach (getallheaders() as $name => $value) {
            echo "$name: $value"."<br>";
        }

    }




    public function admin_add_newbrand()
    {

        if (!empty($_POST['brand_name']) &&
            !empty($_POST['brand_url']) &&
            !empty($_POST['brand_description'])) {

            $if_exist = DataBase::getInstance()->getDB()->getAll("SELECT * FROM c_brands WHERE Name=?s", $_POST['brand_name']);

            if (!$if_exist) {
                $result = DataBase::getInstance()->getDB()->query("INSERT INTO c_brands (Name, Url, Description, Image) VALUES (?s, ?s, ?s, ?s)",
                    $_POST['brand_name'], $_POST['brand_url'], $_POST['brand_description'], 'image');

                if ($result) {

                    echo 'Added';

                } else {

                    echo '<span class="btn btn-warning">Internal error, wasn\'t added</span>';
                }

            } else {

                echo '<span class="btn btn-warning">This Brand is already exist</span>';
            }


        } else {
            echo '<span class="btn btn-warning">All Fields should be filled</span>';
        }
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

    public function add_article(){


        try{

            if(empty($_POST['data'][0]['value']) or empty($_POST['data'][1]['value']) or empty($_POST['body'])){

                echo '<div style="text-align: center"><span class="btn btn-warning"><h5>All fields should be filled</h5></span></div>';

            }else{

                if(DataBase::getInstance()->getDB()->getAll("SELECT * FROM c_article WHERE Url=?s",$_POST['data'][1]['value'])){

                    echo '<div style="text-align: center"><span class="btn btn-danger"><h5>Already exist</h5></span></div>';

                }else{
                    $description = strip_tags(mb_substr($_POST['body'],0,200));

                    $description.='...';

                    if(DataBase::getInstance()->getDB()->query('INSERT INTO c_article (Url, Title, Description, Body, Writer) VALUES (?s,?s,?s,?s,?s)',$_POST['data'][1]['value'],$_POST['data'][0]['value'],$description, $_POST['body'], 'Ro')){

                        $token = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_settings WHERE id=?i',1);

                        echo' <form type="Get" action="">';
                        echo' <div style="text-align: center"><a href="/admin/secure/settings/'.$token[0]['Token'].'?submit=reset-cache"><span class="btn btn-outline-success"><h6>Done, reset cache to get changes immediately</h6></span></a></div>';
                        echo' </form>';

                    }else{


                    }
                }


            }




        }catch (Exception $error){

            echo '<div style="text-align: center"><span class="btn btn-danger">INTERNAL ERROR<br>Line 242: ajax_model: add_article()<hr>'.$error.'<hr>Contact with developer !</span></div>.';
        }


    }


    public function admin_validate_edit_article(){


        $article_title = $_POST['data'][0]['value'];
        $article_url = $_POST['data'][1]['value'];
        $article_writer = $_POST['data'][2]['value'];
        $article_body = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_article WHERE Url=?s',$article_url);

        $outgoing['title'] = $article_title;
        $outgoing['url'] =  $article_url;
        $outgoing['writer'] = $article_writer;
        $outgoing['body'] = $article_body[0]['Body'];


        echo json_encode($outgoing);
    }

    public function admin_edit_article(){


        $article_title = $_POST['data'][0]['value'];
        $article_url = $_POST['data'][1]['value'];
        $article_url_old = $_POST['data'][2]['value'];
        $article_writer = $_POST['data'][3]['value'];
        $article_body = $_POST['body'];


        if(empty($article_title) or empty($article_url) or empty($article_writer) or empty($article_body) or empty($article_url_old)){

            echo '<div style="text-align: center"><span class="btn btn-warning"><h5>All fields should be filled</h5></span></div>';
            die();

        }else{

            try {


                $description = strip_tags(mb_substr($article_body,0,200));

                $description.='...';

                DataBase::getInstance()->getDB()->query("UPDATE c_article SET Url=?s, Title=?s, Description=?s, Body=?s WHERE Url=?s",
                    $article_url, $article_title, $description, $article_body, $article_url_old);

                $token = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_settings WHERE id=?i',1);

                echo' <form type="Get" action="">';
                echo' <div style="text-align: center"><a href="/admin/secure/settings/'.$token[0]['Token'].'?submit=reset-cache"><span class="btn btn-outline-success"><h6>Done, reset cache to get changes immediately</h6></span></a></div>';
                echo' </form>';

            } catch (Exception $error) {

                echo '<div style="text-align: center"><span class="btn btn-danger">INTERNAL ERROR<br>Line 329: ajax_model: admin_edit_article()<hr>'.$error.'<hr>Contact with developer !</span></div>.';
            }

        }

    }


    public function admin_validate_delete_article()
    {

        $outgoing['url'] = $_POST['data'][1]['value'];
        echo json_encode($outgoing);

    }


    public function admin_delete_article(){
        try {

            DataBase::getInstance()->getDB()->query("DELETE FROM c_article WHERE Url=?s", $_POST['data']);
            $token = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_settings WHERE id=?i',1);

            echo' <form type="Get" action="">';
            echo' <div style="text-align: center"><a href="/admin/secure/settings/'.$token[0]['Token'].'?submit=reset-cache"><span class="btn btn-outline-success"><h6>Done, reset cache to get changes immediately</h6></span></a></div>';
            echo' </form>';

        } catch (Exception $error) {

            echo '<div style="text-align: center"><span class="btn btn-warning">INTERNAL ERROR<br>Line 168: ajax_model: admin_delete_url()<hr>'.$error.'<hr>Contact with developer !</span></div>.';
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
}