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
                <li class="nav-item ">
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
                       href="/admin/secure/courses/<?= DataManager::getInstance()->getDataByKey('admin-href') ?>">Courses</a>
                </li>
                <li class="nav-item">
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
            <span class="btn btn-outline-dark"><h5 class="ba">Courses</h5></span>
        </h4>
        <div class="card-title" style="text-align: center">
            <button class="btn btn-outline-success" type="button" data-toggle="modal"
                    data-target="#add-new-course-modal">
                <h6 class="ba">Add new</h6>
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
                    <th>Level</th>
                    <th>Price</th>
                    <th>Duration</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1;
                foreach (DataManager::getInstance()->getDataByKey('Courses') as $value): ?>
                    <tr>
                        <form id="form-edit-<?= $i ?>" method="post">
                            <th scope="row"><?= $i ?></th>
                            <td><?= $value['Name'] ?></td>
                            <td><?= $value['Level'] ?></td>
                            <td><?= $value['Price'] ?></td>
                            <td><?= $value['Period'] ?></td>
                            <input type="text" name="id" value="<?= $value['id'] ?>" hidden>
                            <input type="text" name="name" value="<?= $value['Name'] ?>" hidden>
                            <input type="text" name="description" value="<?= $value['Description'] ?>" hidden>
                            <input type="text" name="level" value="<?= $value['Level'] ?>" hidden>
                            <input type="text" name="price" value="<?= $value['Price'] ?>" hidden>
                            <input type="text" name="duration" value="<?= $value['Period'] ?>" hidden>
                            <input type="text" name="score" value="<?= $value['Score'] ?>" hidden>
                            <td>
                                <button class="btn btn-outline-info ba" type="button"
                                        onclick="changeCourse('form-edit-<?= $i ?>','get');">
                                    Change
                                </button>
                            </td>
                            <td>
                                <button class="btn btn-outline-warning ba" type="button"
                                        onclick="changeCourse(<?= $value['id'] ?>,'delete-ask');">Delete
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
</div>

<div id="add-new-course-modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                <form id="add-new-course-form">
                    <div class="form-row">
                        <div class="col-md-12">
                            <input type="text" id="course-name" name="name" class="form-control" PLACEHOLDER="Name"
                                   required>
                        </div>
                        <div class="col-md-12">
                        <textarea style="min-height: 150px" type="text" id="lesson-description"
                                  name="course-description" class="form-control" PLACEHOLDER="Description"
                                  required></textarea>
                        </div>
                        <div class="col-md-2">
                            <label class="control-label" for="name">Level</label>
                            <select name="level" class="form-control">
                                <option value="A1">A1</option>
                                <option value="A2">A2</option>
                                <option value="B1">B1</option>
                                <option value="B2">B2</option>
                                <option value="C1">C1</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="control-label" for="price">Price</label>
                            <input type="text" id="course-price" name="price" class="form-control" PLACEHOLDER="1.0"
                                   required>
                        </div>
                        <div class="col-md-2">
                            <label class="control-label" for="duration">Duration</label>
                            <input type="text" id="course-duration" name="duration" class="form-control" PLACEHOLDER="1"
                                   required>
                        </div>
                        <div class="col-md-2">
                            <label class="control-label" for="score">Score</label>
                            <input type="text" id="score" name="score" class="form-control" PLACEHOLDER="1"
                                   required>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-success" type="submit" id="upload-bnt" onclick="addCourse();">Upload
                            </button>
                        </div>
                    </div>
                </form>
                <br>
                <br>
                <div id="add-course-message"></div>
                <br>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-warning" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="change-course-modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                <form id="change-course-form">
                    <div class="form-row">
                        <input type="text"  name="id" required hidden>
                        <div class="col-md-12">
                            <input type="text" id="course-name" name="name" class="form-control" PLACEHOLDER="Name"
                                   required>
                        </div>
                        <div class="col-md-12">
                        <textarea style="min-height: 150px" type="text" id="lesson-description"
                                  name="description" class="form-control" PLACEHOLDER="Description"
                                  required></textarea>
                        </div>
                        <div class="col-md-2">
                            <label class="control-label" for="name">Level</label>
                            <select name="level" class="form-control">
                                <option value="A1">A1</option>
                                <option value="A2">A2</option>
                                <option value="B1">B1</option>
                                <option value="B2">B2</option>
                                <option value="C1">C1</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="control-label" for="price">Price</label>
                            <input type="text" id="course-price" name="price" class="form-control" PLACEHOLDER="1.0"
                                   required>
                        </div>
                        <div class="col-md-2">
                            <label class="control-label" for="duration">Duration</label>
                            <input type="text" id="course-duration" name="duration" class="form-control" PLACEHOLDER="1"
                                   required>
                        </div>
                        <div class="col-md-2">
                            <label class="control-label" for="score">Score</label>
                            <input type="text" id="score" name="score" class="form-control" PLACEHOLDER="1"
                                   required>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-success" type="submit" id="upload-bnt" onclick="changeCourse('', 'change');">Upload
                            </button>
                        </div>
                    </div>
                </form>
                <br>
                <br>
                <div id="change-course-message"></div>
                <br>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-warning" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="delete-course-modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                Are you sure ?
            </div>
            <div class="modal-body">
                <form id="delete-course-form">
                    <div style="text-align: center">
                        <input type="text" name="id" class="form-control" PLACEHOLDER="" required hidden>
                        <button class="btn btn-warning ba" type="button" onclick="changeCourse('','delete')">Delete</button>
                    </div>
                    </td>
                    <div id="delete-course-message" style="text-align: center"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-warning ba" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>