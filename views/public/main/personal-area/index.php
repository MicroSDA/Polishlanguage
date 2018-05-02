<body>
<main>
    <h1>PERSONAL AREA PAGE</h1>
    <div>
        id: <?= DataManager::getInstance()->getDataByKey('Students')->getID() ?><br>
        First Name: <?= DataManager::getInstance()->getDataByKey('Students')->getFIRSTNAME() ?><br>
        Last Name: <?= DataManager::getInstance()->getDataByKey('Students')->getLASTNAME() ?><br>
        Email: <?= DataManager::getInstance()->getDataByKey('Students')->getEMAIL() ?><br>
        Phone: <?= DataManager::getInstance()->getDataByKey('Students')->getPHONE() ?><br>
        Skype: <?= DataManager::getInstance()->getDataByKey('Students')->getSkype() ?><br>
        Password: <?= DataManager::getInstance()->getDataByKey('Students')->getPASSWORD() ?><br>
        Ip: <?= DataManager::getInstance()->getDataByKey('Students')->getIP() ?><br>
        Last Login: <?= DataManager::getInstance()->getDataByKey('Students')->getLASTLOGIN() ?><br>
        Additional Info: <?= DataManager::getInstance()->getDataByKey('Students')->getADDINFO() ?><br>
        Status: <?= DataManager::getInstance()->getDataByKey('Students')->getSTATUS() ?><br>
    </div>
    <hr>
    <div>
        <?php foreach (DataManager::getInstance()->getDataByKey('Lessons') as $value): ?>
            <a href="/lessons-donwload?hash=<?= $value['Url'] ?>"><?= $value['Name'] ?></a><br>
        <?php endforeach ?>
    </div>
</main>