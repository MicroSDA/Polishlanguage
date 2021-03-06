<body>
<main>
    <div class="container-fluid">
        <body>
        <main>
            <div class="container-fluid">
                <br>
                <br>
                <br>
                <br>
                <div class="row">
                    <div class="col-md-3">
                        <div class="list-group">
                            <a href="/teacher/dashboard" class="list-group-item">Главная</a>
                            <a href="/teacher/lessons" class="list-group-item active">Ваши занятия</a>
                            <a href="/teacher/available-time" class="list-group-item">Доступное время</a>
                        </div>
                        <div class="row">
                            <br>
                            <div class="col-md-12">
                                <div class="thumbnail">
                                    <div class="caption">
                                        <h3>Профиль Учителя</h3>
                                        <p>Имя: <?= DataManager::getInstance()->getDataByKey('Teacher')->getFIRSTNAME() ?></p>
                                        <p>Фамилия: <?= DataManager::getInstance()->getDataByKey('Teacher')->getLASTNAME() ?></p>
                                        <p>Почта: <?= DataManager::getInstance()->getDataByKey('Teacher')->getEMAIL() ?></p>
                                        <p>Телефон: <?= DataManager::getInstance()->getDataByKey('Teacher')->getPHONE() ?></p>
                                        <p>Skype: <?= DataManager::getInstance()->getDataByKey('Teacher')->getSkype() ?></p>
                                        <p>Уровень: <?= DataManager::getInstance()->getDataByKey('Teacher')->getLEVEL() ?></p>
                                        <hr>
                                        <p>Дополнительная информация:
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <?= DataManager::getInstance()->getDataByKey('Teacher')->getADDINFO() ?>
                                            </div>
                                        </div>
                                        </p>
                                        <p><a href="/teacher/dashboard/?submit=logout" class="btn btn-default" role="button">Выйти</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <?php  if(key_exists('Lessons',DataManager::getInstance()->getAllData())){?>
                            <div class="row">
                                <?php foreach (DataManager::getInstance()->getDataByKey('Lessons') as $value): ?>
                                    <div class="col-md-10">
                                        <div class="thumbnail">
                                            <div class="caption">
                                                <p>Дата: <?=$value['Date']?></p>
                                                <p>Время: <?=$value['Time']?></p>
                                                <?php
                                                if($value['Status']== 'completed'){
                                                    echo '<p>Статус: Завершен</p>';
                                                }else{
                                                    echo '<p>Статус: Открыт</p>';
                                                }
                                                ?>
                                                <a class="btn btn-default" href="/teacher/lessons/lesson/?date=<?=$value['Date']?>&time=<?=$value['Time']?>&token=<?=$value['Token']?>">Перейти</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        <?php }else{
                            echo 'У вас еще не было уроков';
                        } ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
</main>
