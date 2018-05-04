<body>
<main>
   <h1>PERSONAL AREA PAGE</h1>
    <div>
        <span><a href="/account/?submit=logout">Logout</a></span><br><br>
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
        Courses: <?= DataManager::getInstance()->getDataByKey('Students')->getCOURSES() ?><br>
    </div>
    <hr>
    <div>
        Lessons:<br>
        <?php foreach (DataManager::getInstance()->getDataByKey('Lessons') as $value): ?>
            <a href="/lessons-donwload?hash=<?= $value['Url'] ?>"><?= $value['Name'] ?></a><br>
        <?php endforeach ?>
    </div>
    <div id='calendar'></div>
</main>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Lesson</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure that this day is preferred for lesson?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>