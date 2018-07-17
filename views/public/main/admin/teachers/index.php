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
                    <a class="nav-link" href="/admin/secure/dashboard/<?= DataManager::getInstance()->getDataByKey('admin-href')?>">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/secure/articles/<?= DataManager::getInstance()->getDataByKey('admin-href')?>">Articles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/secure/employee/<?= DataManager::getInstance()->getDataByKey('admin-href')?>">Employee</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/secure/entrance/<?= DataManager::getInstance()->getDataByKey('admin-href')?>">Entrance</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/secure/students/<?= DataManager::getInstance()->getDataByKey('admin-href')?>">Students</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="/admin/secure/teachers/<?= DataManager::getInstance()->getDataByKey('admin-href')?>">Teachers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/secure/courses/<?= DataManager::getInstance()->getDataByKey('admin-href')?>">Courses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/secure/lessons/<?= DataManager::getInstance()->getDataByKey('admin-href')?>">Lessons</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/secure/settings/<?= DataManager::getInstance()->getDataByKey('admin-href')?>">Settings</a>
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
            <span class="btn btn-outline-dark"><h5 class="ba">Teachers</h5></span>
        </h4>
        <div class="card-title" style="text-align: center">
            <button class="btn btn-outline-success" type="button" data-toggle="modal"
                    data-target="#add-new-teacher-modal">
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
                    <th>Surname</th>
                    <th>Level</th>
                    <th>Status</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1;
                foreach (DataManager::getInstance()->getDataByKey('Teachers') as $value): ?>
                    <tr>
                        <form id="form-edit-<?= $i ?>" method="post">
                            <th scope="row"><?= $i ?></th>
                            <td><?= $value['FirstName'] ?></td>
                            <td><?= $value['LastName'] ?></td>
                            <td><?= $value['Level'] ?></td>
                            <td><?= $value['Status'] ?></td>
                            <input type="text" name="id" value="<?= $value['id'] ?>" hidden>
                            <input type="text" name="name" value="<?= $value['FirstName'] ?>" hidden>
                            <input type="text" name="surname" value="<?= $value['LastName'] ?>" hidden>
                            <input type="text" name="email" value="<?= $value['Email'] ?>" hidden>
                            <input type="text" name="level" value="<?= $value['Level'] ?>" hidden>
                            <input type="text" name="status" value="<?= $value['Status'] ?>" hidden>
                            <input type="text" name="phone" value="<?= $value['Phone'] ?>" hidden>
                            <input type="text" name="skype" value="<?= $value['Skype'] ?>" hidden>
                            <input type="text" name="addinfo" value="<?= $value['AddInfo'] ?>" hidden>
                            <td>
                                <button class="btn btn-outline-info ba" type="button" onclick="editTeacher('form-edit-<?= $i ?>','get');">
                                    Change
                                </button>
                            </td>
                            <td>
                                <button class="btn btn-outline-warning ba" type="button"
                                        onclick="editTeacher(<?= $value['id'] ?>,'delete-ask');">Delete
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

<div id="add-new-teacher-modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                <form id="add-new-teacher-form">
                    <div class="form-row">
                        <div class="col-lg-6">
                            <label class="control-label" for="name">Name</label>
                            <input type="text" name="first-name" class="form-control" PLACEHOLDER="Name" required>
                        </div>
                        <div class="col-lg-6">
                            <label class="control-label" for="name">Surname</label>
                            <input type="text" name="surname"  class="form-control" PLACEHOLDER="Surname" required>
                        </div>
                        <div class="col-lg-6">
                            <label class="control-label" for="email">Email</label>
                            <input type="text" name="email" class="form-control" PLACEHOLDER="Email" required>
                        </div>
                        <div class="col-md-12">
                            <label class="control-label" for="name">Additional Info</label>
                            <textarea style="min-height: 150px" name="additionalInfo" id="additionalInfo"></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="control-label" for="name">Skype</label>
                            <input type="text" name="skype"  class="form-control" PLACEHOLDER="Skype" required>
                        </div>
                        <div class="col-md-4">
                            <label class="control-label" for="gender">Gender</label>
                            <div class="form-check">
                                <input class="form-check-input" name="gender" value="female" type="radio" id="female" checked>
                                <label class="form-check-label" for="female">Female</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="gender" value="male" type="radio" id="male">
                                <label class="form-check-label" for="male">Male</label>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <label class="control-label" for="phone">Phone</label>
                            <input type="text" name="phone" class="form-control" PLACEHOLDER="+" required>
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
                        <div class="col-md-12">
                            <button class="btn btn-success" type="submit"  id="upload-bnt" onclick="addTeacher();">Add
                            </button>
                        </div>
                    </div>
                </form>
                <br>
                <br>
                <div id="add-new-teacher-message"></div>
                <br>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-warning" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="edit-teacher-modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                <form id="edit-teacher-form">
                    <div class="form-row">
                        <div class="col-lg-6">
                            <label class="control-label" for="name">Name</label>
                            <input type="text" name="id" hidden required>
                            <input type="text" name="first-name" class="form-control" PLACEHOLDER="Name" required>
                        </div>
                        <div class="col-lg-6">
                            <label class="control-label" for="name">Surname</label>
                            <input type="text" name="surname"  class="form-control" PLACEHOLDER="Surname" required>
                        </div>
                        <div class="col-lg-6">
                            <label class="control-label" for="email">Email</label>
                            <input type="text" name="email" class="form-control" PLACEHOLDER="Email" required>
                        </div>
                        <div class="col-md-12">
                            <label class="control-label" for="name">Additional Info</label>
                            <textarea style="min-height: 150px" name="additionalInfo" id="additionalInfo"></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="control-label" for="name">Skype</label>
                            <input type="text" name="skype"  class="form-control" PLACEHOLDER="Skype" required>
                        </div>
                        <div class="col-md-4">
                            <label class="control-label" for="gender">Gender</label>
                            <div class="form-check">
                                <input class="form-check-input" name="gender" value="female" type="radio" id="female" checked>
                                <label class="form-check-label" for="female">Female</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="gender" value="male" type="radio" id="male">
                                <label class="form-check-label" for="male">Male</label>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <label class="control-label" for="phone">Phone</label>
                            <input type="text" name="phone" class="form-control" PLACEHOLDER="+" required>
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
                            <label class="control-label" for="name">Status</label>
                            <select name="status" class="form-control">
                                <option value="active">Active</option>
                                <option value="not-active">Not active</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-success" type="submit"  id="upload-bnt" onclick="editTeacher('','change');">Save
                            </button>
                        </div>
                    </div>
                </form>
                <br>
                <br>
                <div id="edit-teacher-message"></div>
                <br>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-warning" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="delete-teacher-modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                Are you sure ?
            </div>
            <div class="modal-body">
                <form id="delete-teacher-form">
                    <div style="text-align: center">
                        <input type="text" name="id" required hidden>
                        <button class="btn btn-warning ba" type="button" onclick="editTeacher('','delete')">Delete</button>
                    </div>
                    </td>
                    <div id="delete-teacher-message" style="text-align: center"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-warning ba" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
