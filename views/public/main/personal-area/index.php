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
                    <a href="/account" class="list-group-item active">Назначить/Отменить занятие</a>
                    <a href="/account/contents" class="list-group-item">Лекции и аудиозаписи</a>
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
                <div id='calendar' class="sf">
                    <div id="loading-calendar">
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
                    <span id="lessons-date-offset" hidden</span>
                    <div class="input-group clockpicker" style="max-width: 140px;">
                        <input type="text" class="form-control" id="lessons-time" value="">
                        <span class="input-group-addon"><span class="">Time</span></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="addNewLesson();">Save</button>
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
                    <span id="lessons-date-edit"></span>
                    <span id="lessons-date-edit-offset" hidden</span>
                    <div class="input-group clockpicker" style="max-width: 140px;">
                        <input type="text" class="form-control" id="lessons-time-edit" value="">
                        <span class="input-group-addon"><span class="">Time</span></span>
                    </div>
                </div>
                <button type="button" class="btn btn-warning" onclick="deleteLesson();">Delete</button>
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