<?php
/**
 * User: Ro Kovalenko
 * Date: 12/30/2017
 * Time: 7:58 PM
 */

require_once URL_ROOT . '/core/Libs/Basic/General/ContentsDraw.php';

class personal_area_model extends Model
{

    /**
     * index_model constructor.
     */

    private $students;

    public function __construct()
    {
        parent::__construct();

        $this->students = new Students();

    }

    /**
     *
     */
    public function index()
    {
        /**
         * If isn't login then redirect to login page
         */
        if (!$this->students->isLogin()) {

            header('Location:/login');
            die();
        }

        //$array = json_decode($this->students->getCOURSES(),true);
        //$this->students->addCourse($array, '2', 'Kрестьянин','0','21');
        //$this->students->addCourse($array, '2', "0","21");
        //$this->students->setCurrentCourse(1);


        /**
         * If GET action is logout the delete cookie
         */
        if (isset($_GET['submit'])) {

            switch ($_GET['submit']) {
                case 'logout':
                    setcookie('s-id', '', time() - 100, "/");
                    setcookie('s-hash', '', time() - 100, "/");
                    header('Location:' . $_SERVER['HTTP_REFERER']);
                    break;
                default:
                    break;
            }
        }

        /**
         * Main Body Section ///////////////////////////////////////////////////////////////////////////////////////////
         */

        DataManager::getInstance()->addData('Students', $this->students);


        /**
         * Render///////////////////////////////////////////////////////////////////////////////////////////////////////
         */
        $this->render();

    }

    public function login()
    {

        $this->render();
    }

    public function contents()
    {

        /**
         * If isn't login then redirect to login page
         */
        if (!$this->students->isLogin()) {

            header('Location:/login');
            die();
        }


        /**
         * Main Body Section ///////////////////////////////////////////////////////////////////////////////////////////
         */



        $courses = json_decode($this->students->getCOURSES(),true);

        //arrayPrint($courses);
        /**
         *
        $data = $db->getInd('id','SELECT * FROM ?n WHERE id IN (?a)','table', array(1,2));
         */
        $coursese_array=[];
        foreach ($courses as $key => $value){

            if($value['activity']=='active')

            array_push($coursese_array, $value['id']);
        }

        $lessons = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_lessons_pdf WHERE CourseID IN (?a)',$coursese_array);
        $lessons_out=[];
        foreach ($lessons as $key=> $value){
            $lessons_out[$value['CourseName']][]=$value;

        }

        DataManager::getInstance()->addData('Lessons', $lessons_out);
        DataManager::getInstance()->addData('Students', $this->students);


       //arrayPrint($lessons_out);
        /**
         * Render///////////////////////////////////////////////////////////////////////////////////////////////////////
         */
        $this->render();

    }

    public function lesson_feedback()
    {


        /**
         * If isn't login then redirect to login page
         */
        if (!$this->students->isLogin()) {

            header('Location:/login');
            die();
        }

        /**
         * Main Body Section ///////////////////////////////////////////////////////////////////////////////////////////
         */



            $time = $_GET['time'];
            $date = $_GET['date'];

            $lesson = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_lessons WHERE Date=?s AND Time=?s AND StudentID=?i',
                $date ,$time,$this->students->getID());

            if($lesson){

                $feedBack = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_lessons_feedback WHERE Date=?s AND Time=?s AND StudentID=?i',
                    $date ,$time,$this->students->getID());

                if($feedBack){
                    $feedBackFile = '<div>
                                      <div class="thumbnail">
                                          <div class="caption">
                                              <h3>Отзыв об уроке</h3>
                                              <hr>
                                                  <p>Дата: '.$feedBack[0]['Date'].'</p>
                                                  <p>Время: '.$feedBack[0]['Time'].'</p>
                                                  <p>Оценка: '.$feedBack[0]['Evaluation'].'</p>
                                                  <hr>
                                                  <p>Отзыв</p>
                                                  <div class="panel panel-default">
                                                      <div class="panel-body">
                                                      '.$feedBack[0]['Text'].'
                                                      </div>
                                                  </div>
                                          </div>
                                      </div>
                                     </div>';

                    DataManager::getInstance()->addData('FeedBackFile', $feedBackFile);

                }else{

                    $feedBackFile = '
<form id="feedback-form">
  <label>Оценка</label>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="rating" id="inlineRadio1" value="1">
  <label class="form-check-label" for="inlineRadio1">1</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="rating" id="inlineRadio2" value="2">
  <label class="form-check-label" for="inlineRadio2">2</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="rating" id="inlineRadio3" value="3">
  <label class="form-check-label" for="inlineRadio2">3</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="rating" id="inlineRadio4" value="4">
  <label class="form-check-label" for="inlineRadio2">4</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="rating" id="inlineRadio5" value="5">
  <label class="form-check-label" for="inlineRadio2">5</label>
</div>
<div class="form-group">
    <label for="exampleFormControlTextarea1">Ваш отзыв</label>
    <textarea class="form-control" name="feedback-text" rows="3" required></textarea>
  </div>
   <input class="form-check-input" type="text" name="date" value="'.$date.'" readonly hidden>
   <input class="form-check-input" type="text" name="time" value="'.$time.'" readonly hidden>
   <button name="submit" type="button" onclick="addFeedback();" class="btn btn-primary mb-2">Оставить отзыв</button><br>
</form>
<div id="feedback-message"></div>';

                    DataManager::getInstance()->addData('FeedBackFile', $feedBackFile);


                }

            }else{

                DataManager::getInstance()->addData('FeedBackFile', 'Sorry, but lesson wasn\'t find');
            }


        DataManager::getInstance()->addData('Students', $this->students);


        /**
         * Render///////////////////////////////////////////////////////////////////////////////////////////////////////
         */

        $this->render();
    }
}