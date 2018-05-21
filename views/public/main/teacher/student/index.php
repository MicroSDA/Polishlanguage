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
                            <a href="/teacher/lessons" class="list-group-item">Ваши занятия</a>
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
                                        <div id="script-warning"></div>
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
                        <div class="thumbnail">
                            <div class="caption">
                                <h3>Профиль Ученика</h3>
                                <hr>
                                <img src="/public/IMG_1121.JPG" alt="<?= DataManager::getInstance()->getDataByKey('Student')['FirstName']?>" class="img-thumbnail" style="width: 200px">
                                <hr>
                                <p>Имя: <?= DataManager::getInstance()->getDataByKey('Student')['FirstName']?></p>
                                <p>Фамилия: <?= DataManager::getInstance()->getDataByKey('Student')['LastName']?></p>
                                <p>Уровень: <?= DataManager::getInstance()->getDataByKey('Student')['Level']?></p>
                                <p>Skype: <?= DataManager::getInstance()->getDataByKey('Student')['Skype']?></p>
                                <hr>
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
                                        <label for="exampleFormControlTextarea1">Коментарий</label>
                                        <textarea class="form-control" name="feedback-text" rows="3" required></textarea>
                                    </div>
                                    <input class="form-check-input" type="text" name="date" value="'.$date.'" readonly hidden>
                                    <input class="form-check-input" type="text" name="time" value="'.$time.'" readonly hidden>
                                    <button name="submit" type="button" onclick="" class="btn btn-primary mb-2">Завершить урок</button><br>
                                </form>
                                <div id="feedback-message"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</main>
