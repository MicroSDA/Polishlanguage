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
                            <a href="/teacher/available-time" class="list-group-item active">Доступное время</a>
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
                        <div id="calendar" class="sf">
                            <div id="loading-calendar">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</main>
<div id="addTime" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Add new time</h5>
            </div>
            <div class="modal-body">
                <div style="margin-left: auto">
                    <span id="new-date" hidden></span>
                    <div class="input-group clockpicker" style="max-width: 140px;">
                        <input type="text" class="form-control" id="new-time" value="">
                        <span class="input-group-addon"><span class="">Time</span></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="addNewTime();">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="deleteTime" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Вы уверены что хотите удалить это время ?</h5>
            </div>
            <div class="modal-body">
                <div style="margin-left: auto">
                    <input id="delete-date" hidden/>
                    <input id="delete-time" hidden/>
                    <div style="text-align:  center">
                        <button type="button" class="btn btn-warning" onclick="deleteTime();">Да</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
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