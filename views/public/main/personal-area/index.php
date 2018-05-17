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
                    <div class="col-md-12">
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
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Test">
        Launch demo modal
    </button>
</main>
<!-- Modal -->
<div id="getAllTeachersModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Are you sure that this day is preferred for lesson?</h5>
            </div>
            <div class="modal-body">
                <div style="margin-left: auto">
                   <div id="allTeachers"></div>
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
<div id="Test" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"></button>
                <h4 class="modal-title">Message</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="thumbnail">
                            <div class="caption">
                                <h5 style="text-align: center">Профиль</h5>
                                <hr>
                                <h6>Имя: Родион</h6>
                                <h6>Уровень: A1</h6>
                                <h6>Доступное время</h6>
                                <hr>
                                <div data-toggle="buttons">
                                    <label class="btn btn-primary">
                                        <input type="radio" name="options" id="option1" autocomplete="off"> 12:00
                                    </label>
                                    <br>
                                    <label class="btn btn-primary">
                                        <input type="radio" name="options" id="option2" autocomplete="off"> 15:00
                                    </label>
                                    <br>
                                    <label class="btn btn-primary">
                                        <input type="radio" name="options" id="option3" autocomplete="off"> 18:00
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                    </div>
                    <div class="col-lg-4">s</div>
                    <div class="col-lg-4">s</div>
                    <div class="col-lg-4">s</div>
                    <div class="col-lg-4">s</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>