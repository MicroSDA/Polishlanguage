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
                    <div class="col-md-12">
                        <div class="thumbnail">
                            <div class="caption">
                                <h3>Профиль</h3>
                                <p>Имя: <?= DataManager::getInstance()->getDataByKey('Students')->getFIRSTNAME() ?></p>
                                <p>Фамилия: <?= DataManager::getInstance()->getDataByKey('Students')->getLASTNAME() ?></p>
                                <p>Почта: <?= DataManager::getInstance()->getDataByKey('Students')->getEMAIL() ?></p>
                                <p>Телефон: <?= DataManager::getInstance()->getDataByKey('Students')->getPHONE() ?></p>
                                <p>Skype: <?= DataManager::getInstance()->getDataByKey('Students')->getSkype() ?></p>
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
                        <?php $active = 'class="active"'; foreach (DataManager::getInstance()->getDataByKey('Lessons') as $key => $value): ?>
                            <li role="presentation" <?=$active?>><a href="#<?=$key?>" data-toggle="tab"><?=$key?></a></li>
                        <?php $active=''; endforeach ?>
                    </ul>
                    <div class="tab-content">
                        <br>
                        <?php $active = 'in active'; foreach (DataManager::getInstance()->getDataByKey('Lessons') as $key => $value): ?>
                            <div class="tab-pane fade <?=$active?>" id="<?=$key?>">
                                <div class="row">
                        <?php foreach ($value as $c_key => $c_value): ?>

                                <div class="col-sm-12 col-lg-4">
                                    <div class="thumbnail">
                                        <img src="/lessons-donwload-logo?hash=<?= $c_value['ImageUrl'] ?>" alt="">
                                        <div class="caption">
                                            <h3><?= $c_value['Name'] ?></h3>
                                            <p><?= $c_value['Description'] ?></p>
                                            <hr>
                                            <p>
                                                <a href="/lessons-donwload-pdf?hash=<?= $c_value['PdfUrl'] ?>" class="btn btn-primary" role="button">
                                                    PDF</a>
                                                <?php if (!empty($c_value['AudioUrl'])): ?>
                                                    <a href="/lessons-donwload-audio?hash=<?= $c_value['AudioUrl'] ?>" class="btn btn-default" role="button">
                                                        Аудио</a>
                                                <?php endif;?>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            <?php endforeach ?>
                                </div>
                            </div>
                        <?php $active=''; endforeach ?>
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