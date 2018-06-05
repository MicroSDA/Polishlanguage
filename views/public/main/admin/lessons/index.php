<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark elegant-color" style="font-size: 75%">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                data-target="#navbarText" aria-controls="navbarText" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link"
                       href="/admin/secure/dashboard/<?= DataManager::getInstance()->getDataByKey('admin-href') ?>">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                       href="/admin/secure/articles/<?= DataManager::getInstance()->getDataByKey('admin-href') ?>">Articles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                       href="/admin/secure/employee/<?= DataManager::getInstance()->getDataByKey('admin-href') ?>">Employee</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                       href="/admin/secure/entrance/<?= DataManager::getInstance()->getDataByKey('admin-href') ?>">Entrance</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                       href="/admin/secure/students/<?= DataManager::getInstance()->getDataByKey('admin-href') ?>">Students</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link"
                       href="/admin/secure/lessons/<?= DataManager::getInstance()->getDataByKey('admin-href') ?>">Lessons</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                       href="/admin/secure/settings/<?= DataManager::getInstance()->getDataByKey('admin-href') ?>">Settings</a>
                </li>
            </ul>
            <span class="navbar-text white-text">Welcome <span
                        class="text-info"><?= DataManager::getInstance()->getDataByKey('employee-info')['FirstName'] ?>
                    &nbsp;&nbsp;&nbsp;</span>
                <span><a href="/admin/secure/dashboard/<?= DataManager::getInstance()->getDataByKey('admin-href') ?>?submit=logout">Logout</a></span>
            </span>
        </div>
    </nav>
</header>
<div class="container-fluid">
    <div class="card">
        <h4 class="card-title" style="text-align: center">
            <span class="btn btn-outline-dark"><h5>Lessons</h5></span>
        </h4>
        <div class="card-title" style="text-align: center">
            <button class="btn btn-outline-success" type="button" data-toggle="modal"
                    data-target="#add-new-lesson-modal">
                <h6>Add new</h6>
            </button>
        </div>
        <div class="card-body" style="height:507px; overflow-y: auto; display: block">
            <h4 class="card-title"></h4>
            <p class="card-text"></p>
            <table class="table table-bordered">
                <thead class="elegant-color">
                <tr style="color:white">
                    <th>#</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1;
                foreach (DataManager::getInstance()->getDataByKey('Lessons') as $value): ?>
                    <tr>
                        <form id="form-edit-<?= $i ?>" method="post">
                            <th scope="row"><?= $i ?></th>
                            <td><?= $value['Name'] ?></td>
                            <td><?= $value['CourseName'] ?></td>
                            <td>
                                <button class="btn btn-outline-info" type="button" onclick="('form-edit-<?= $i ?>');">
                                    Change
                                </button>
                            </td>
                            <td>
                                <button class="btn btn-outline-warning" type="button"
                                        onclick="('form-edit-<?= $i ?>');">Delete
                                </button>
                            </td>
                        </form>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- <input id="upload-file" type="file" name="upload" />
    <button id="upload-bnt" onclick="uploadLesson();">Upload</button>-->
</div>

<div id="add-new-lesson-modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                <form id="add-new-lesson-form">
                <div class="form-row">
                    <div class="col-md-12">
                        <input type="text" id="lesson-name" name="name" class="form-control" PLACEHOLDER="Name"
                               required>
                    </div>
                    <div class="col-md-12">
                        <textarea style="min-height: 150px" type="text" id="lesson-description"
                                  name="lesson-description" class="form-control" PLACEHOLDER="Description"
                                  required></textarea>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label" for="name">Level</label>
                        <select id="lesson-course" name="lesson-course" class="form-control">
                            <?php foreach (DataManager::getInstance()->getDataByKey('Courses') as $value): ?>
                                <option name="<?= $value['Name'] ?>" value="<?= $value['id'] ?>"><?= $value['Name'] ?>
                                    (<?= $value['Level'] ?>)
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <label class="input-group-btn">
                                <span class="btn btn btn-outline-info">
                                    IMAGE&hellip; <input type="file" style="display: none;" id="upload-image" name="image">
                                </span>
                            </label>
                            <input type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <label class="input-group-btn">
                                <span class="btn btn btn-outline-info">
                                    PDF&hellip; <input type="file" style="display: none;" id="upload-pdf" name="pdf">
                                </span>
                            </label>
                            <input type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <label class="input-group-btn">
                                <span class="btn btn btn-outline-info">
                                    AUDIO&hellip; <input type="file" style="display: none;" id="upload-audio" name="audio">
                                </span>
                            </label>
                            <input type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button class="btn btn-success" type="" id="upload-bnt" onclick="uploadLesson();">Upload
                        </button>
                    </div>
                </div>
                </form>
                <br>
                <br>
                <div id="add-new-lesson-message"></div>
                <br>
                <div id="add-new-employee-message"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-warning" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
