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
        <form id="completeLessonForm">
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
                <textarea class="form-control" name="comment-text" rows="3" required></textarea>
            </div>
            <input class="form-check-input" type="text" name="date" value="<?= DataManager::getInstance()->getDataByKey('Lesson')['Date']?>" readonly hidden>
            <input class="form-check-input" type="text" name="time" value="<?= DataManager::getInstance()->getDataByKey('Lesson')['Time']?>" readonly hidden>
            <input class="form-check-input" type="text" name="token" value="<?= DataManager::getInstance()->getDataByKey('Lesson')['Token']?>" readonly hidden>
            <button name="submit" type="button" onclick="completeLesson();" class="btn btn-primary mb-2">Завершить урок</button><br>
        </form>
        <br>
        <div id="lesson-complete-message"></div>
    </div>
</div>