<div class="thumbnail">
    <div class="caption">
        <h3>Профиль Ученика</h3>
        <hr>
        <img src="/public/IMG_1121.JPG" alt="<?= DataManager::getInstance()->getDataByKey('Student')['FirstName']?>" class="img-thumbnail" style="width: 200px">
        <hr>
        <p>Дата: <?=DataManager::getInstance()->getDataByKey('Lesson')['Date']?> Время: <?=DataManager::getInstance()->getDataByKey('Lesson')['Time']?></p>
        <p>Имя: <?= DataManager::getInstance()->getDataByKey('Student')['FirstName']?></p>
        <p>Фамилия: <?= DataManager::getInstance()->getDataByKey('Student')['LastName']?></p>
        <p>Уровень: <?= DataManager::getInstance()->getDataByKey('Student')['Level']?></p>
        <p>Skype: <?= DataManager::getInstance()->getDataByKey('Student')['Skype']?></p>
        <hr>
        <p>Оценка: <?=DataManager::getInstance()->getDataByKey('Lesson')['Estimation']?></p>
        <hr>
        <p>Коментарий</p>
        <p><?=DataManager::getInstance()->getDataByKey('Lesson')['Comment']?></p>
</div>