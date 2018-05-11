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
                    <a href="/account" class="list-group-item">Оплатить курс</a>
                    <a href="/account" class="list-group-item">Назначить/Отменить занятие</a>
                    <a href="/account/contents" class="list-group-item">Лекции и аудиозаписи</a>
                    <a href="/account" class="list-group-item">Домашнее задание</a>
                    <a href="/account" class="list-group-item">Дополнительные материалы</a>
                    <a href="/account" class="list-group-item">Мой прогресс</a>
                </div>
                <div class="row">
                    <br>
                    <div class="col-md-12">
                        <div class="thumbnail">
                            <div class="caption">
                                <h3>Профиль</h3>
                                <p>Имя: <?= DataManager::getInstance()->getDataByKey('Students')->getFIRSTNAME() ?></p>
                                <p>Фамилия: <?= DataManager::getInstance()->getDataByKey('Students')->getLASTNAME() ?></p>
                                <p>Почта: <?= DataManager::getInstance()->getDataByKey('Students')->getEMAIL() ?></p>
                                <p>Телефон: <?= DataManager::getInstance()->getDataByKey('Students')->getPHONE() ?></p>
                                <p>Skype: <?= DataManager::getInstance()->getDataByKey('Students')->getSkype() ?></p>
                                <p>Доступные курсы: <?= DataManager::getInstance()->getDataByKey('Students')->getCOURSES() ?></p>
                                <hr>
                                <p>Дополнительная информация:
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <?= DataManager::getInstance()->getDataByKey('Students')->getADDINFO() ?>
                                    </div>
                                </div>
                                </p>
                                <p><a href="/account/?submit=logout" class="btn btn-default" role="button">Выйти</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <?=DataManager::getInstance()->getDataByKey('FeedBackFile')?>
            </div>
        </div>
    </div>
</main>
