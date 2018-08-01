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
                    <a href="/account/settings" class="list-group-item active">Настройки</a>
                </div>
                <div class="row">
                    <br>
                    <div class="col-md-12">
                        <div class="thumbnail">
                            <div class="caption">
                                <h3>Профиль</h3>
                                <p>Имя: <?= DataManager::getInstance()->getDataByKey('Students')->getFIRSTNAME() ?></p>
                                <p>
                                    Фамилия: <?= DataManager::getInstance()->getDataByKey('Students')->getLASTNAME() ?></p>
                                <p>Почта: <?= DataManager::getInstance()->getDataByKey('Students')->getEMAIL() ?></p>
                                <p>Телефон: <?= DataManager::getInstance()->getDataByKey('Students')->getPHONE() ?></p>
                                <p>Skype: <?= DataManager::getInstance()->getDataByKey('Students')->getSkype() ?></p>
                                <p>Уровень: <?= DataManager::getInstance()->getDataByKey('Students')->getLEVEL() ?></p>
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
            <div class="col-md-3">
                <div class="jumbotron" style="text-align: center;">
                    <h3>Фотография профиля</h3>
                    <img src="<?= DataManager::getInstance()->getDataByKey('Students')->getPHOTO() ?>" class="img-thumbnail" style="">
                    <input type="text" id="name" value="<?= DataManager::getInstance()->getDataByKey('Students')->getID() ?>" hidden>
                    <br>
                    <br>
                    <div class="input-group">
                        <label class="input-group-btn">
                                <span class="btn btn btn-info">
                                    Обзор&hellip; <input type="file" style="display: none;" id="upload-image" name="image">
                                </span>
                        </label>
                    </div>
                    <br>
                    <button class="btn btn-primary" name="submit" type="submit" onclick="changePhoto();">Change</button>
                    <br>
                    <div id="change-photo-message"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="jumbotron" style="text-align: center;">
                    <div id="change-password">
                        <form id="change-password-form" onsubmit="return false" autocomplete="off">
                            <input type="text" name="id" value="<?= DataManager::getInstance()->getDataByKey('Students')->getID() ?>" hidden>
                            <div class="form-group">
                                <label for="">Старый пароль</label>
                                <input type="password" class="form-control" name="old-pass" placeholder="Старый пароль" required >
                            </div>
                            <div class="form-group">
                                <label for="">Новый пароль</label>
                                <input type="password" class="form-control" name="password"
                                       placeholder="Новый пароль">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Подвердите пароль</label>
                                <input type="password" class="form-control" name="conf-password"
                                       placeholder="Новый пароль">
                            </div>
                            <button  class="btn btn-primary" name="submit" type="submit" onclick="changePassword();">Save</button>
                        </form>
                        <br>
                        <div id="change-password-message"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Modal -->
