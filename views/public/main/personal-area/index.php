<body>
<main>
    <hr>
    <div class="row">
        <div class="col-md-3">
            <div>
                <h1>Профиль</h1>
                id: <?= DataManager::getInstance()->getDataByKey('Students')->getID() ?><br>
                Имя: <?= DataManager::getInstance()->getDataByKey('Students')->getFIRSTNAME() ?><br>
                Фамилия: <?= DataManager::getInstance()->getDataByKey('Students')->getLASTNAME() ?><br>
                Почта: <?= DataManager::getInstance()->getDataByKey('Students')->getEMAIL() ?><br>
                Телефон: <?= DataManager::getInstance()->getDataByKey('Students')->getPHONE() ?><br>
                Skype: <?= DataManager::getInstance()->getDataByKey('Students')->getSkype() ?><br>
                Доступные курсы: <?= DataManager::getInstance()->getDataByKey('Students')->getCOURSES() ?><br>
                <span><a href="/account/?submit=logout">Logout</a></span><br><br>
            </div>
            <hr>
        </div>
        <div class="col-md-9">
            <div id='calendar'></div>
        </div>
    </div>
    <div>
        Уроки:<br>
        <?php foreach (DataManager::getInstance()->getDataByKey('Lessons') as $value): ?>
            <a href="/lessons-donwload?hash=<?= $value['Url'] ?>"><?= $value['Name'] ?></a><br>
        <?php endforeach ?>
    </div>
</main>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Are you sure that this day is preferred for lesson?</h5>
            </div>
            <div class="modal-body">
                <div style="margin-left: auto">
                    <span id="lessons-date" hidden></span>
                    <div class="input-group clockpicker" style="max-width: 140px;">
                         <input type="text" class="form-control" id="lessons-time" value="">
                         <span class="input-group-addon"><span class="">Time</span></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="addNewLesson()">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="edit-lessons-day" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Edit</h5>
            </div>
            <div class="modal-body">
                <div style="margin-left: auto">
                    <span id="lessons-date-edit" ></span>
                    <div class="input-group clockpicker" style="max-width: 140px;">
                        <input type="text" class="form-control" id="lessons-time-edit" value="">
                        <span class="input-group-addon"><span class="">Time</span></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="editLesson();">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="messageModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"></button>
                <h4 class="modal-title">Message</h4>
            </div>
            <div class="modal-body">
                <div id="error-message"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>