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
                            <a href="/teacher/dashboard" class="list-group-item active">Главная</a>
                            <a href="/teacher/lessons" class="list-group-item">Ваши занятия</a>
                            <a href="/teacher/available-time" class="list-group-item">Доступное время</a>
                            <a href="/teacher/settings" class="list-group-item">Настройки</a>
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
                </div>
            </div>
        </main>
    </div>
</main>

