<?php
/**
 * Created by PhpStorm.
 * User: bansc
 * Date: 1/22/2018
 * Time: 8:57 PM
 */


require_once URL_ROOT . '/core/Libs/Config/SiteMapGenerator.php';

/**
 * Class admin_model
 */
class admin_model extends Model
{

    private $employee;

    /**
     * admin_model constructor.
     */
    public function __construct()
    {

        /**
         * Get admin href token
         */
        $token = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_settings WHERE id=?i', 1);
        //c_employee

        /**
         * If token wrong, redirect ot error
         */
        if ($token[0]['Token'] != UrlsDispatcher::getInstance()->getToken()) {
            UrlsDispatcher::getInstance()->setCurrentUrlData(UrlsDispatcher::getInstance()->getUrlsDataListByKey('(^)'));
            $controller = new Controller();
            die();
        }


        /**
         * If cookies isset
         */
        if (isset($_COOKIE['id-super']) && isset($_COOKIE['hash'])) {

            /**
             * If cookie is wrong
             */

            $this->employee = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_employee WHERE id=?s AND Hash=?s', $_COOKIE['id-super'], $_COOKIE['hash']);

            if ($this->employee) {
                if ((string)$this->employee[0]['id'] != $_COOKIE['id-super'] || (string)$this->employee[0]['Hash'] != (string)$_COOKIE['hash']) {

                    /**
                     * If !Admin Login page, redirect to login page
                     */
                    if (UrlsDispatcher::getInstance()->getCurrentUrlData()['name'] != 'Control Board Login') {
                        header('location:/admin/secure/login/' . $token[0]['Token'] . '');
                    }

                }

            } else {
                /**
                 * If !Admin Login page, redirect to login page
                 */
                if (UrlsDispatcher::getInstance()->getCurrentUrlData()['name'] != 'Control Board Login') {
                    header('location:/admin/secure/login/' . $token[0]['Token'] . '');
                }
            }


        } else {
            /**
             * If cookies !isset and !Admin Login page redirect to login page
             */

            if (UrlsDispatcher::getInstance()->getCurrentUrlData()['name'] != 'Control Board Login') {
                header('location:/admin/secure/login/' . $token[0]['Token'] . '');
            }
        }

        /**
         * Add href link to container
         */
        DataManager::getInstance()->addData('admin-href', $token[0]['Token']);
        DataManager::getInstance()->addData('employee-info', $this->employee[0]);


        parent::__construct();

    }


    /**
     *
     */
    public function login()
    {

        /**
         * If login button was pressed
         */


        if (isset($_POST['login'])) {

            /**
             * If Input forms were filled
             */
            if (isset($_POST['email']) && isset($_POST['password']) && !empty($_POST['email']) &&
                !empty($_POST['password']) && $_POST['email'] != ' ' && $_POST['password'] != ' ') {

                $adminData = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_employee WHERE Email=?s AND Password=?s', $_POST['email'], $_POST['password']);


                if (!$adminData) {
                    /**
                     *If login and Password were wrong
                     */
                    DataManager::getInstance()->addData('error_login', 'Wrong login or password');

                } else {

                    /**
                     * Get admin href token
                     */
                    $token = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_settings WHERE id=?i', 1);
                    /**
                     * Generate new Hash for cookie
                     */
                    $hash = md5(getenv("REMOTE_ADDR") . "key" . time()) . md5(getenv("REMOTE_ADDR") . "key-2" .
                            time()) . md5(getenv("REMOTE_ADDR") . "key-3" . time());

                    /**
                     * Set new Hash for admin
                     */
                    DataBase::getInstance()->getDB()->query('UPDATE c_employee SET Hash=?s WHERE id=?s', $hash, $adminData[0]['id']);

                    /**
                     * Set Cookie
                     */
                    setcookie('id-super', $adminData[0]['id'], time() + 36000, "/");
                    setcookie('hash', $hash, time() + 36000, "/");

                    /**
                     * Redirect to dashboard page
                     */
                    header('Location:/admin/secure/dashboard/' . $token[0]['Token'] . '');
                }

            } else {

            }
        }

        /**
         * Render with admin header and footer
         */
        $this->render('admin/header.php', 'admin/footer.php');
    }


    /**
     *
     */
    public function index()
    {

        /**
         * Case of actions on the dashboard
         */
        if (isset($_GET['submit'])) {

            switch ($_GET['submit']) {

                case 'logs-erase':
                    DataBase::getInstance()->getDB()->query("DELETE FROM c_logs");
                    sleep(0.5);
                    DataBase::getInstance()->getDB()->query("ALTER TABLE c_logs AUTO_INCREMENT = 1");
                    header('Location:' . $_SERVER['HTTP_REFERER']);
                    break;
                case 'activity-erase':
                    DataBase::getInstance()->getDB()->query("DELETE FROM c_visitor");
                    sleep(0.5);
                    DataBase::getInstance()->getDB()->query("ALTER TABLE c_visitor AUTO_INCREMENT = 1");
                    header('Location:' . $_SERVER['HTTP_REFERER']);
                    break;
                case 'logout':
                    setcookie('id-super', '', time() - 100, "/");
                    setcookie('hash', '', time() - 100, "/");
                    header('Location:' . $_SERVER['HTTP_REFERER']);
                    break;
                default:
                    break;

            }
        }


        try {
            $logs = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_logs ORDER BY id DESC');

            if ($logs) {
                DataManager::getInstance()->addData('Logs', $logs);
            }

            /**
             * Charts section
             */
            require_once URL_ROOT . '/core/Libs/Basic/General/Charts.php';

            $charts_daily = new Charts('Day');
            DataManager::getInstance()->addData('Day', $charts_daily);
            $charts_weekly = new Charts('Week');
            DataManager::getInstance()->addData('Week', $charts_weekly);
            $charts_monthly = new Charts('Month');
            DataManager::getInstance()->addData('Month', $charts_monthly);
            $charts_yearly = new Charts('Year');
            DataManager::getInstance()->addData('Year', $charts_yearly);

            $charts_daily_page = new Charts('DayPage');
            DataManager::getInstance()->addData('DayPage', $charts_daily_page);
            $charts_weekly_page = new Charts('WeekPage');
            DataManager::getInstance()->addData('WeekPage', $charts_weekly_page);
            $charts_monthly_page = new Charts('MonthPage');
            DataManager::getInstance()->addData('MonthPage', $charts_monthly_page);
            $charts_yearly_page = new Charts('YearPage');
            DataManager::getInstance()->addData('YearPage', $charts_yearly_page);


        } catch (Exception $error) {

            echo $error->getMessage();
        }


        /**
         * Render with admin header and footer
         */
        $this->render('admin/header.php', 'admin/footer.php');
    }

    public function articles()
    {


        DataManager::getInstance()->addData('Articles', DataBase::getInstance()->getDB()->query('SELECT * FROM c_article ORDER BY id DESC'));

        /**
         * Render with admin header and footer
         */
        $this->render('admin/header.php', 'admin/footer.php');
    }


    public function employee()
    {

        $employee = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_employee');
        DataManager::getInstance()->addData('Employee', $employee);
        /**
         * Render with admin header and footer
         */
        $this->render('admin/header.php', 'admin/footer.php');
    }

    /**
     *
     */


    public function entrance()
    {


        $entrance = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_restricted_person');
        DataManager::getInstance()->addData('Entrance', $entrance);


        /**
         * Render with admin header and footer
         */
        $this->render('admin/header.php', 'admin/footer.php');

    }

    public function lessons()
    {

        $lessons = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_lessons_pdf ORDER BY id DESC ');
        $courses = DataBase::getInstance()->getDB()->getAll('SELECT  * FROM c_courses');
        DataManager::getInstance()->addData('Lessons', $lessons);
        DataManager::getInstance()->addData('Courses', $courses);
        /**
         * Render with admin header and footer
         */
        $this->render('admin/header.php', 'admin/footer.php');
    }

    public function settings()
    {

        if (isset($_GET['submit'])) {

            switch ($_GET['submit']) {
                case 'site-map':

                    /**
                     * Generate SiteMap
                     */

                    set_time_limit(0);
                    $sitemap = new SiteMapGenerator();
                    $sitemap->set_ignore(array("javascript:", ".css", ".js", ".ico", ".jpg", ".png", ".jpeg", ".swf", ".gif", "mailto:"));
                    $sitemap->get_links('http://' . $_SERVER['HTTP_HOST']);
                    $sitemap->save(URL_ROOT . '/public/sitemap.xml');
                    header('Location:' . $_SERVER['HTTP_REFERER']);
                    break;
                case 'reset-cache':
                    /**
                     * Cache reset
                     */

                    /**
                     * Delete All Html files from folder cache
                     */
                    CacheGenerator::deleteCache();

                    /**
                     * Generate new Url Config file from db
                     */
                    UrlsDispatcher::getInstance()->createNewUrlDataListDBtoXML(URLS_CONFIG_FILE_PATH);

                    header('Location:' . $_SERVER['HTTP_REFERER']);
                    break;

            }

        }

        /**
         * Add all url in the container
         */

        if ($this->employee[0]['Role'] == 'developer') {

            $urls = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_urls ORDER BY id DESC');
            DataManager::getInstance()->addData('URLS', $urls);
        } else {

            $urls = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_urls WHERE Type=?s ORDER BY id DESC', 'basic');
            DataManager::getInstance()->addData('URLS', $urls);
        }


        //DataManager::getInstance()->addData('URLS', UrlsDispatcher::getInstance()->getUrlsDataList());


        /**
         * Render with admin header and footer
         */
        $this->render('admin/header.php', 'admin/footer.php');
    }

    public function students()
    {


        $students = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_students ORDER BY id DESC');

        foreach ($students as $key => $value) {
            /**
             * convert to array
             */
            $students[$key]['Courses'] = json_decode($students[$key]['Courses'], true);
        }

        $courses = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_courses');


        foreach ($students as $student_key => $student_value){
            $arr_out = [];
            $i = 0;
            foreach ($courses as $cours_key => $cours_value) {
                array_push($arr_out, array('id'=> $cours_value['id'],'name'=> $cours_value['Name'],'in-use'=>'no'));
                foreach ($student_value['Courses'] as $key => $value) {

                    if ($value['id'] == $cours_value['id']) {
                        $arr_out[$i]['totalLessons'] = $value['totalLessons'];
                        $arr_out[$i]['maxLessons'] = $value['maxLessons'];
                        $arr_out[$i]['activity'] = $value['activity'];
                    }
                }

                $i++;
            }

            $students[$student_key]['Courses']=$arr_out;
            unset($arr_out);
        }


        DataManager::getInstance()->addData('Students', $students);
        DataManager::getInstance()->addData('Courses', $courses);
        //DataManager::getInstance()->addData('Active-Courses', $courses);
        /**
         * Render with admin header and footer
         */
        $this->render('admin/header.php', 'admin/footer.php');
    }
}