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
                    <a href="/account/contents" class="list-group-item active">Лекции и аудиозаписи</a>
                    <a href="/account" class="list-group-item">Домашнее задание</a>
                    <a href="/account" class="list-group-item">Дополнительные материалы</a>
                    <a href="/account" class="list-group-item">Мой прогресс</a>
                </div>
                <div class="row">
                    <br>
                    <div class="col-sm-auto col-md-7">
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
                <div class="tabs">
                    <ul class="nav nav-tabs">
                        <li role="presentation" class="active"><a href="#A1" data-toggle="tab">Курс А1</a></li>
                        <li role="presentation"><a href="#A2" data-toggle="tab">Курс А2</a></li>
                        <li role="presentation"><a href="#B1" data-toggle="tab">Курс B1</a></li>
                        <li role="presentation"><a href="#B2" data-toggle="tab">Курс B2</a></li>
                        <li role="presentation"><a href="#C1" data-toggle="tab">Курс C1</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="A1">
                            <br>
                            <?php foreach (DataManager::getInstance()->getDataByKey('Lessons') as $value): ?>
                            <div class="row">
                                <div class="col-sm-6 col-md-4">
                                    <div class="thumbnail">
                                        <img src="https://media.giphy.com/media/TvLuZ00OIADoQ/giphy.gif" alt="">
                                        <div class="caption">
                                            <h3><?= $value['Name'] ?></h3>
                                            <p><?= $value['Description'] ?></p>
                                            <hr>
                                            <p><a href="/lessons-donwload?hash=<?= $value['Url'] ?>" class="btn btn-primary" role="button">Скачать</a> <a href="/lessons-donwload?hash=<?= $value['Url'] ?>" class="btn btn-default" role="button">Открыть</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach ?>
                        </div>
                        <div class="tab-pane fade" id="A2">
                            <br>
                            <?php foreach (DataManager::getInstance()->getDataByKey('Lessons') as $value): ?>
                                <div class="row">
                                    <div class="col-sm-6 col-md-4">
                                        <div class="thumbnail">
                                            <img src="https://media.giphy.com/media/TvLuZ00OIADoQ/giphy.gif" alt="">
                                            <div class="caption">
                                                <h3><?= $value['Name'] ?></h3>
                                                <p><?= $value['Description'] ?></p>
                                                <hr>
                                                <p><a href="/lessons-donwload?hash=<?= $value['Url'] ?>" class="btn btn-primary" role="button">Скачать</a> <a href="/lessons-donwload?hash=<?= $value['Url'] ?>" class="btn btn-default" role="button">Открыть</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                        <div class="tab-pane fade" id="A3">
                            <br>
                            <?php foreach (DataManager::getInstance()->getDataByKey('Lessons') as $value): ?>
                                <div class="row">
                                    <div class="col-sm-6 col-md-4">
                                        <div class="thumbnail">
                                            <img src="https://media.giphy.com/media/TvLuZ00OIADoQ/giphy.gif" alt="">
                                            <div class="caption">
                                                <h3><?= $value['Name'] ?></h3>
                                                <p><?= $value['Description'] ?></p>
                                                <hr>
                                                <p><a href="/lessons-donwload?hash=<?= $value['Url'] ?>" class="btn btn-primary" role="button">Скачать</a> <a href="/lessons-donwload?hash=<?= $value['Url'] ?>" class="btn btn-default" role="button">Открыть</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                        <div class="tab-pane fade" id="B1">
                            <br>
                            <?php foreach (DataManager::getInstance()->getDataByKey('Lessons') as $value): ?>
                                <div class="row">
                                    <div class="col-sm-6 col-md-4">
                                        <div class="thumbnail">
                                            <img src="https://media.giphy.com/media/TvLuZ00OIADoQ/giphy.gif" alt="">
                                            <div class="caption">
                                                <h3><?= $value['Name'] ?></h3>
                                                <p><?= $value['Description'] ?></p>
                                                <hr>
                                                <p><a href="/lessons-donwload?hash=<?= $value['Url'] ?>" class="btn btn-primary" role="button">Скачать</a> <a href="/lessons-donwload?hash=<?= $value['Url'] ?>" class="btn btn-default" role="button">Открыть</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                        <div class="tab-pane fade" id="B2">
                            <br>
                            <?php foreach (DataManager::getInstance()->getDataByKey('Lessons') as $value): ?>
                                <div class="row">
                                    <div class="col-sm-6 col-md-4">
                                        <div class="thumbnail">
                                            <img src="https://media.giphy.com/media/TvLuZ00OIADoQ/giphy.gif" alt="">
                                            <div class="caption">
                                                <h3><?= $value['Name'] ?></h3>
                                                <p><?= $value['Description'] ?></p>
                                                <hr>
                                                <p><a href="/lessons-donwload?hash=<?= $value['Url'] ?>" class="btn btn-primary" role="button">Скачать</a> <a href="/lessons-donwload?hash=<?= $value['Url'] ?>" class="btn btn-default" role="button">Открыть</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                        <div class="tab-pane fade" id="C1">
                            <br>
                            <?php foreach (DataManager::getInstance()->getDataByKey('Lessons') as $value): ?>
                                <div class="row">
                                    <div class="col-sm-6 col-md-4">
                                        <div class="thumbnail">
                                            <img src="https://media.giphy.com/media/TvLuZ00OIADoQ/giphy.gif" alt="">
                                            <div class="caption">
                                                <h3><?= $value['Name'] ?></h3>
                                                <p><?= $value['Description'] ?></p>
                                                <hr>
                                                <p><a href="/lessons-donwload?hash=<?= $value['Url'] ?>" class="btn btn-primary" role="button">Скачать</a> <a href="/lessons-donwload?hash=<?= $value['Url'] ?>" class="btn btn-default" role="button">Открыть</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--
        Уроки:<br>
        <?php foreach (DataManager::getInstance()->getDataByKey('Lessons') as $value): ?>
            <a href="/lessons-donwload?hash=<?= $value['Url'] ?>"><?= $value['Name'] ?></a><br>
        <?php endforeach ?>
    </div>-->
</main>
<!-- Modal -->
