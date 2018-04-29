<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark elegant-color" style="font-size: 85%">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/admin/secure/dashboard/<?= DataManager::getInstance()->getDataByKey('admin-href')?>">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/secure/articles/<?= DataManager::getInstance()->getDataByKey('admin-href')?>">Articles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/secure/employee/<?= DataManager::getInstance()->getDataByKey('admin-href')?>">Employee</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/secure/entrance/<?= DataManager::getInstance()->getDataByKey('admin-href')?>">Entrance</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/secure/settings/<?= DataManager::getInstance()->getDataByKey('admin-href')?>">Settings</a>
                </li>
            </ul>
            <span class="navbar-text white-text">Welcome <span class="text-info"><?= DataManager::getInstance()->getDataByKey('employee-info')['FirstName'] ?>&nbsp;&nbsp;&nbsp;</span>
                <span><a href="/admin/secure/dashboard/<?= DataManager::getInstance()->getDataByKey('admin-href')?>?submit=logout">Logout</a></span>
            </span>
        </div>
    </nav>
</header>
<div class="container-fluid">
    <br>
    <ul class="nav nav-tabs nav-justified">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#panel1" role="tab">Activity</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#panel2" role="tab">Logs</a>
        </li>
    </ul>
    <div class="tab-content card">
        <!--Panel 1-->
        <div class="tab-pane fade in show active" id="panel1" role="tabpanel">
            <br>
            <div class="card">
                <h4 class="card-title" style="text-align: center"><span
                            class="btn btn-outline-dark"><h5>Visitors</h5></span></h4>
                <div class="card-body">
                    <h4 class="card-title"></h4>
                    <p class="card-text"></p>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <?php DataManager::getInstance()->getDataByKey('Day')->draw(); ?><hr>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <?php DataManager::getInstance()->getDataByKey('Week')->draw(); ?><hr>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <?php DataManager::getInstance()->getDataByKey('Month')->draw(); ?><hr>
                        </div>
                        <div class="col-lg-12 col-sm-12">
                          <?php  DataManager::getInstance()->getDataByKey('Year')->draw(); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <hr><h5 style="text-align: center">Daily</h5>
                            <?php DataManager::getInstance()->getDataByKey('DayPage')->draw(); ?>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <hr><h5 style="text-align: center">Weekly</h5>
                            <?php  DataManager::getInstance()->getDataByKey('WeekPage')->draw(); ?>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <hr><h5 style="text-align: center">Monthly</h5>
                            <?php DataManager::getInstance()->getDataByKey('MonthPage')->draw(); ?>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <hr><h5 style="text-align: center">Yearly</h5>
                            <?php  DataManager::getInstance()->getDataByKey('YearPage')->draw(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <form type="get">
                    <button type="submit" name="submit" value="activity-erase" class="btn btn-danger">Erase
                    </button>
                </form>
            </div>
        </div>
        <!--/.Panel 1-->
        <!--Panel 2-->
        <div class="tab-pane fade" id="panel2" role="tabpanel">
            <br>
            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <div class="card">
                        <h4 class="card-title" style="text-align: center"><span
                                    class="btn btn-outline-dark"><h5>Logs</h5></span></h4>
                        <div class="card-body" style="height:507px; overflow-y: auto; display: block">
                            <h4 class="card-title"></h4>
                            <p class="card-text"></p>
                            <table class="table table-bordered">
                                <thead class="elegant-color">
                                <tr style="color:white">
                                    <th>#</th>
                                    <th>Time</th>
                                    <th>File</th>
                                    <th>Line</th>
                                    <th>Message</th>
                                    <th>Ip</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1;
                                foreach (DataManager::getInstance()->getDataByKey('Logs') as $value): ?>
                                    <tr>
                                        <td scope="row"><?= $i ?></td>
                                        <td><?= $value['Time'] ?></td>
                                        <td><?= $value['File'] ?></td>
                                        <td><?= $value['Line'] ?></td>
                                        <td><?= $value['Message'] ?></td>
                                        <td><?= $value['Ip'] ?></td>
                                    </tr>
                                    <?php $i++; ?>
                                <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div>
                        <form type="get">
                            <button type="submit" name="submit" value="logs-erase" class="btn btn-danger">Erase</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--/.Panel 2-->
    </div>
</div>
<?php
/* foreach (array_reverse(UrlsDispatcher::getInstance()->getUrlsDataList()) as $value){

     DataBase::getInstance()->getDB()->query('INSERT INTO c_urls (Pattern, Name, Type, View, Cache, Model, Method) VALUES (?s,?s,?s,?s,?s,?s,?s)',
       $value['pattern'],$value['name'],$value['type'],$value['view'],$value['cache'],$value['model'],$value['method']);


 }*/

?>


