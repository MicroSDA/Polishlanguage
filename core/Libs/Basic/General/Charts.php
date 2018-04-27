<?php
/**
 * Created by PhpStorm.
 * User: bansc
 * Date: 2/15/2018
 * Time: 8:11 PM
 */

class Charts
{

    /**
     * @var
     */
    private $type;

    private $unique;

    /**
     * Charts constructor.
     * @param $type
     */
    public function __construct($type)
    {
        $this->type=$type;
    }

    /**
     *
     */
    public function init(){

    }

    /**
     *
     */
    public function draw()
    {

        switch ($this->type) {
            case 'Year':
                $this->yearlyChart();
                break;
            case 'Month':
                $this->monthlyChart();
                break;
            case 'Week':
                $this->weeklyChart();
                break;
            case 'Day':
                $this->dailyChart();
                break;
            case 'DayPage':
                $this->dailyChartPage();
                break;
            case 'WeekPage':
                $this->weeklyChartPage();
                break;
            case 'MonthPage':
                $this->monthlyChartPage();
                break;
            case 'YearPage':
                $this->yearlyChartPage();
                break;


        }
    }

    /**
     *
     */
    private function dailyChart(){

        $day = date('d');
        $month = date('F');
        $year = date('Y');

        try {

            $charts = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_visitor WHERE Day=?s AND Month=?s AND Year=?s',
                $day, $month, $year);


        } catch (Exception $exception) {
           // echo $exception->getMessage();
        }



        $hour['00'] = 0; $hour['01'] = 0; $hour['02'] = 0; $hour['03'] = 0; $hour['04'] = 0; $hour['05'] = 0;
        $hour['06'] = 0; $hour['07'] = 0; $hour['08'] = 0; $hour['09'] = 0; $hour['10'] = 0; $hour['11'] = 0;
        $hour['12'] = 0; $hour['13'] = 0; $hour['14'] = 0; $hour['15'] = 0; $hour['16'] = 0; $hour['17'] = 0;
        $hour['18'] = 0; $hour['19'] = 0; $hour['20'] = 0; $hour['21'] = 0; $hour['22'] = 0; $hour['23'] = 0;


        $unique['00'] = array('count'=>0); $unique['01']= array('count'=>0); $unique['02']= array('count'=>0); $unique['03']= array('count'=>0); $unique['04']= array('count'=>0); $unique['05']= array('count'=>0);
        $unique['06'] = array('count'=>0); $unique['07'] = array('count'=>0); $unique['08'] = array('count'=>0); $unique['09'] = array('count'=>0); $unique['10']= array('count'=>0); $unique['11'] = array('count'=>0);
        $unique['12'] = array('count'=>0); $unique['13'] = array('count'=>0); $unique['14']= array('count'=>0); $unique['15']= array('count'=>0); $unique['16'] = array('count'=>0); $unique['17']= array('count'=>0);
        $unique['18'] = array('count'=>0); $unique['19']= array('count'=>0); $unique['20'] = array('count'=>0); $unique['21']= array('count'=>0); $unique['22'] = array('count'=>0); $unique['23'] =array('count'=>0);




        $all_count = 0;
        $un_count = 0;

        foreach ($charts as $value){

            $hour[$value['Hour']]+= 1;
            $all_count+=1;
            $ip = preg_replace('(\.)', '', $value['Ip']);

            if(empty( $unique[$value['Hour']][$ip])){
                $unique[$value['Hour']]['count'] +=1;
                $un_count+=1;
            }

            $unique[$value['Hour']][$ip]=$ip;

        }



        echo '<div id="daily_chart" style="width: 100%; height: 250px;"></div>';
        echo '<script type="text/javascript">document.addEventListener("DOMContentLoaded", function (){';
        echo ' google.charts.load(\'current\', {\'packages\':[\'corechart\']});
                       google.charts.setOnLoadCallback(drawChart);
                       function drawChart() {
                       var data = google.visualization.arrayToDataTable([
                       [\'Hour\', \'All: '.$all_count.'\',\'Unique\'],';
        foreach ($hour as  $key=> $value){
                echo '[\''.$key.':00\','.$value.','.$unique[$key]['count'].'],';

        }
        echo ' ]);
                        var options = {
                            title: \'Daily\',
                            hAxis: {title: \'Hours\',  titleTextStyle: {color: \'#333\'}},
                            vAxis: {minValue: 0},
                        };
                        var chart = new google.visualization.AreaChart(document.getElementById(\'daily_chart\'));
                        chart.draw(data, options);
                    }';
        echo '});</script>';
    }

    private function weeklyChart(){


        $week_n = date('W');
        $month = date('F');
        $year = date('Y');

        try {

            $charts = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_visitor WHERE WeekN=?s AND Month=?s AND Year=?s',
                $week_n, $month, $year);

        } catch (Exception $exception) {
            echo $exception->getMessage();
        }


        $day['Monday'] = 0; $day['Tuesday'] = 0; $day['Wednesday'] = 0; $day['Thursday'] = 0;
        $day['Friday'] = 0; $day['Saturday'] = 0; $day['Sunday'] = 0;

        $unique['Monday'] = array('count'=>0);$unique['Tuesday'] = array('count'=>0);$unique['Wednesday'] = array('count'=>0);
        $unique['Thursday'] = array('count'=>0);$unique['Friday'] = array('count'=>0);$unique['Saturday'] = array('count'=>0);
        $unique['Sunday'] = array('count'=>0);



        $all_count = 0;
        $un_count = 0;

        foreach ($charts as $value){

            $day[$value['Week']]+= 1;
            $all_count+=1;
            $ip = preg_replace('(\.)', '', $value['Ip']);

            if(empty($unique[$value['Week']][$ip])){
                $unique[$value['Week']]['count'] +=1;
                $un_count+=1;
            }

            $unique[$value['Week']][$ip]=$ip;

        }


        echo '<div id="weekly_chart" style="width: 100%; height: 250px;"></div>';
        echo '<script type="text/javascript">document.addEventListener("DOMContentLoaded", function (){';
        echo ' google.charts.load(\'current\', {\'packages\':[\'corechart\']});
                       google.charts.setOnLoadCallback(drawChart);
                       function drawChart() {
                       var data = google.visualization.arrayToDataTable([
                       [\'Day\', \'All: '.$all_count.'\',\'Unique\'],';
        foreach ($day as  $key=> $value){
            echo '[\''.$key.'\','.$value.','.$unique[$key]['count'].'],';
        }
        echo ' ]);
                        var options = {
                            title: \'Weekly\',
                            hAxis: {title: \'Days\',  titleTextStyle: {color: \'#333\'}},
                            vAxis: {minValue: 0}
                        };
                        var chart = new google.visualization.AreaChart(document.getElementById(\'weekly_chart\'));
                        chart.draw(data, options);
                    }';
        echo '});</script>';
    }


    public function monthlyChart(){

        $month = date('F');
        $year = date('Y');

        try {

            $charts = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_visitor WHERE Month=?s AND Year=?s',$month, $year);

        } catch (Exception $exception) {
            echo $exception->getMessage();
        }


        $week['1']= 0; $week['2']= 0; $week['3']= 0; $week['4']= 0; $week['5']= 0;
        $unique['1'] = array('count'=>0);$unique['2'] = array('count'=>0);$unique['3'] = array('count'=>0);
        $unique['4'] = array('count'=>0);$unique['5'] = array('count'=>0);

        $all_count = 0;
        foreach ($charts as $value){
            $all_count+=1;
            $ip = preg_replace('(\.)', '', $value['Ip']);

            if((int)$value['Day'] <= 7){

                if(empty($unique['1'][$ip])){
                    $unique['1']['count'] +=1;
                }

                $unique['1'][$ip]=$ip;
                $week['1'] +=1;
                continue;
            }

            if((int)$value['Day'] > 7 && (int)$value['Day'] <= 14){
                if(empty($unique['2'][$ip])){
                    $unique['2']['count'] +=1;
                }

                $unique['2'][$ip]=$ip;
                $week['2'] +=1;
                continue;
            }

            if((int)$value['Day'] > 14 && (int)$value['Day'] <= 21){
                if(empty($unique['3'][$ip])){
                    $unique['3']['count'] +=1;
                }

                $unique['3'][$ip]=$ip;
                $week['3'] +=1;
                continue;
            }

            if((int)$value['Day'] > 21 && (int)$value['Day'] <= 28 ){
                if(empty($unique['4'][$ip])){
                    $unique['4']['count'] +=1;
                }

                $unique['4'][$ip]=$ip;
                $week['4'] +=1;
                continue;
            }

            if((int)$value['Day'] > 28 ){
                if(empty($unique['5'][$ip])){
                    $unique['5']['count'] +=1;
                }

                $unique['5'][$ip]=$ip;
                $week['5'] +=1;
                continue;
            }

        }


        echo '<div id="monthly_chart" style="width: 100%; height: 250px;"></div>';
        echo '<script type="text/javascript">document.addEventListener("DOMContentLoaded", function (){';
        echo ' google.charts.load(\'current\', {\'packages\':[\'corechart\']});
                       google.charts.setOnLoadCallback(drawChart);
                       function drawChart() {
                       var data = google.visualization.arrayToDataTable([
                       [\'Week\', \'All: '.$all_count.'\',\'Unique\'],';
        foreach ($week as  $key=> $value){

            echo '[\''.$key.'\','.$value.','.$unique[$key]['count'].'],';
        }
        echo ' ]);
                        var options = {
                            title: \'Monthly\',
                            hAxis: {title: \'Weeks\',  titleTextStyle: {color: \'#333\'}},
                            vAxis: {minValue: 0}
                        };
                        var chart = new google.visualization.AreaChart(document.getElementById(\'monthly_chart\'));
                        chart.draw(data, options);
                    }';
        echo '});</script>';
    }

    public function yearlyChart(){


        $year = date('Y');

        try {

            $charts = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_visitor WHERE Year=?s', $year);

        } catch (Exception $exception) {
            echo $exception->getMessage();
        }


        $month['September']=0;$month['October']=0;$month['November']=0;$month['December']=0;$month['January']=0;
        $month['February']=0;$month['March']=0;$month['April']=0;$month['May']=0;$month['June']=0;
        $month['July']=0;$month['August']=0;

        $unique['September'] = array('count'=>0);$unique['October'] = array('count'=>0);$unique['November'] = array('count'=>0);$unique['December'] = array('count'=>0);
        $unique['January'] = array('count'=>0);$unique['February'] = array('count'=>0);$unique['March'] = array('count'=>0);$unique['April'] = array('count'=>0);
        $unique['May'] = array('count'=>0);$unique['June'] = array('count'=>0);$unique['July'] = array('count'=>0);$unique['August'] = array('count'=>0);


        $all_count = 0;
        foreach ($charts as $value){
            $all_count+=1;
            $month[$value['Month']]+= 1;
            $ip = preg_replace('(\.)', '', $value['Ip']);

            if(empty($unique[$value['Month']][$ip])){
                $unique[$value['Month']]['count'] +=1;
            }

            $unique[$value['Month']][$ip]=$ip;

        }

            echo '<div id="yearly_chart" style="width: 100%; height: 250px;"></div>';
            echo '<script type="text/javascript">document.addEventListener("DOMContentLoaded", function (){';
            echo ' google.charts.load(\'current\', {\'packages\':[\'corechart\']});
                       google.charts.setOnLoadCallback(drawChart);
                       function drawChart() {
                       var data = google.visualization.arrayToDataTable([
                       [\'Month\', \'All: '.$all_count.'\',\'Unique\'],';
            foreach ($month as  $key=> $value){

                echo '[\''.$key.'\','.$value.','.$unique[$key]['count'].'],';
            }
            echo ' ]);
                        var options = {
                            title: \'Yearly\',
                            hAxis: {title: \'Months\',  titleTextStyle: {color: \'#333\'}},
                            vAxis: {minValue: 0}
                        };
                        var chart = new google.visualization.AreaChart(document.getElementById(\'yearly_chart\'));
                        chart.draw(data, options);
                    }';
            echo '});</script>';

    }

    public function dailyChartPage(){

        $day = date('d');
        $month = date('F');
        $year = date('Y');

        try {

            $charts = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_visitor WHERE Day=?s AND Month=?s AND Year=?s',
                $day, $month, $year);

        } catch (Exception $exception) {
            echo $exception->getMessage();
        }


        $day_page = array();
         foreach ($charts as $value){

            $day_page[$value['Name']]=0;

         }


        foreach ($charts as $value){
            $day_page[$value['Name']]+= 1;
        }

        echo '<div id="daily_piechart" style="width: auto; height: 300px"></div>';
        echo '<script type="text/javascript">document.addEventListener("DOMContentLoaded", function (){';
        echo ' google.charts.load(\'current\', {\'packages\':[\'corechart\']});
                       google.charts.setOnLoadCallback(drawChart);
                       function drawChart() {
                       var data = google.visualization.arrayToDataTable([
                       [\'Page\', \'Visitors\']';
        foreach ($day_page as  $key=> $value){

            echo ',[\''.$key.'\','.$value.']';
        }
        echo ' ]);
                        var options = {
                          title: \'Daily\',
                          chartArea:{left:0,top:0,width:\'100%\',height:\'90%\'},
                          legend: { position: \'bottom\', alignment: \'bottom\'}
                        };
                        var chart = new google.visualization.PieChart(document.getElementById(\'daily_piechart\'));
                        chart.draw(data, options);
                    }';
        echo '});</script>';
    }


    public function weeklyChartPage(){

        $week_n = date('W');
        $month = date('F');
        $year = date('Y');

        try {

            $charts = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_visitor WHERE WeekN=?s AND Month=?s AND Year=?s',
                $week_n, $month, $year);

        } catch (Exception $exception) {
            echo $exception->getMessage();
        }


        $week_page = array();
        foreach ($charts as $value){

            $week_page[$value['Name']]=0;

        }


        foreach ($charts as $value){
            $week_page[$value['Name']]+= 1;
        }

        echo '<div id="weekly_piechart" style="width: auto; height: 300px"></div>';
        echo '<script type="text/javascript">document.addEventListener("DOMContentLoaded", function (){';
        echo ' google.charts.load(\'current\', {\'packages\':[\'corechart\']});
                       google.charts.setOnLoadCallback(drawChart);
                       function drawChart() {
                       var data = google.visualization.arrayToDataTable([
                       [\'Page\', \'Visitors\']';
        foreach ($week_page as  $key=> $value){

            echo ',[\''.$key.'\','.$value.']';
        }
        echo ' ]);
                        var options = {
                          title: \'Weekly\',
                          chartArea:{left:0,top:0,width:\'100%\',height:\'90%\'},
                          legend: { position: \'bottom\', alignment: \'bottom\'}
                        };
                        var chart = new google.visualization.PieChart(document.getElementById(\'weekly_piechart\'));
                        chart.draw(data, options);
                    }';
        echo '});</script>';
    }

    public function monthlyChartPage(){

        $month = date('F');
        $year = date('Y');

        try {

            $charts = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_visitor WHERE Month=?s AND Year=?s',$month, $year);

        } catch (Exception $exception) {
            echo $exception->getMessage();
        }

        $month_page = array();
        foreach ($charts as $value){

            $month_page[$value['Name']]=0;

        }


        foreach ($charts as $value){
            $month_page[$value['Name']]+= 1;
        }

        echo '<div id="monthly_piechart" style="width: auto; height: 300px"></div>';
        echo '<script type="text/javascript">document.addEventListener("DOMContentLoaded", function (){';
        echo ' google.charts.load(\'current\', {\'packages\':[\'corechart\']});
                       google.charts.setOnLoadCallback(drawChart);
                       function drawChart() {
                       var data = google.visualization.arrayToDataTable([
                       [\'Page\', \'Visitors\']';
        foreach ($month_page as  $key=> $value){

            echo ',[\''.$key.'\','.$value.']';
        }
        echo ' ]);
                        var options = {
                          title: \'Monthly\',
                            chartArea:{left:0,top:0,width:\'100%\',height:\'90%\'},
                            legend:{ position: \'bottom\', alignment: \'bottom\'}
                        };
                        var chart = new google.visualization.PieChart(document.getElementById(\'monthly_piechart\'));
                        chart.draw(data, options);
                    }';
        echo '});</script>';
    }

    public function yearlyChartPage(){


        $year = date('Y');

        try {

            $charts = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_visitor WHERE Year=?s', $year);

        } catch (Exception $exception) {
            echo $exception->getMessage();
        }

        $year_page = array();
        foreach ($charts as $value){

            $year_page[$value['Name']]=0;

        }


        foreach ($charts as $value){
            $year_page[$value['Name']]+= 1;
        }

        echo '<div id="yearly_piechart" style="width: auto; height: 300px"></div>';
        echo '<script type="text/javascript">document.addEventListener("DOMContentLoaded", function (){';
        echo ' google.charts.load(\'current\', {\'packages\':[\'corechart\']});
                       google.charts.setOnLoadCallback(drawChart);
                       function drawChart() {
                       var data = google.visualization.arrayToDataTable([
                       [\'Page\', \'Visitors\']';
        foreach ($year_page as  $key=> $value){

            echo ',[\''.$key.'\','.$value.']';
        }
        echo ' ]);
                        var options = {
                          title: \'Yearly\',
                          chartArea:{left:0,top:0,width:\'100%\',height:\'90%\'},
                          legend: { position: \'bottom\', alignment: \'bottom\'}
                         
                        };
                        var chart = new google.visualization.PieChart(document.getElementById(\'yearly_piechart\'));
                        chart.draw(data, options);
                    }';
        echo '});</script>';
    }
}