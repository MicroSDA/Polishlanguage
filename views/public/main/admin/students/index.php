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
                <li class="nav-item active">
                    <a class="nav-link" href="/admin/secure/students/<?= DataManager::getInstance()->getDataByKey('admin-href')?>">Students</a>
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
    <div class="row">
        <div class="col-lg-6 col-sm-12">
            <div class="card">
                <h4 class="card-title" style="text-align: center">
                    <span class="btn btn-outline-dark ba"><h5 class="ba">New Students</h5></span>
                </h4>
                <div class="card-title" style="text-align: center">
                </div>
                <div class="card-body" style="height:507px; overflow-y: auto; display: block">
                    <h4 class="card-title"></h4>
                    <p class="card-text"></p>
                    <table class="table table-bordered">
                        <thead class="elegant-color">
                        <tr style="color:white">
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1;
                        foreach (DataManager::getInstance()->getDataByKey('Students') as $value): ?>
                            <?php if ($value['Status']== "not-active"): ?>
                                <tr>
                                    <form id="form-edit-<?= $i ?>" method="post">
                                        <th scope="row"><?= $i ?></th>
                                        <td><?= $value['FirstName'] ?><input hidden name="name" type="text" value="<?= $value['FirstName'] ?>" required></td>
                                        <td><?= $value['Email'] ?><input hidden name="email" type="text" value="<?= $value['Email'] ?>" required></td></td>
                                        <td><?= $value['Phone'] ?><input hidden name="phone" type="text" value="<?= $value['Phone'] ?>" required></td></td>
                                        <td>
                                            <button class="btn btn-outline-info ba" type="button" onclick="fillNewsStudent('form-edit-<?= $i ?>','get');">Fill</button>
                                        </td>
                                        <td>
                                            <button class="btn btn-outline-warning ba" type="button" onclick="fillNewsStudent('form-edit-<?= $i ?>','delete-ask');;">Delete</button>
                                        </td>
                                    </form>
                                </tr>
                                <?php $i++; ?>
                            <?php endif ?>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12">
            <div class="card">
                <h4 class="card-title" style="text-align: center">
                    <span class="btn btn-outline-dark ba"><h5 class="ba">All Students</h5></span>
                </h4>
                <div class="card-title" style="text-align: center">
                </div>
                <div class="card-body" style="height:507px; overflow-y: auto; display: block">
                    <h4 class="card-title"></h4>
                    <p class="card-text"></p>
                    <table class="table table-bordered">
                        <thead class="elegant-color">
                        <tr style="color:white">
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1;
                        foreach (DataManager::getInstance()->getDataByKey('Students') as $value): ?>
                            <?php if ($value['Status']== "active"): ?>
                                <tr>
                                    <form id="form-edit-<?= $i ?>" method="post">
                                        <th scope="row"><?= $i ?></th>
                                        <td><?= $value['FirstName'] ?></td>
                                        <td><?= $value['Email'] ?></td>
                                        <td><?= $value['Phone'] ?></td>
                                        <td>
                                            <button class="btn btn-outline-info ba" type="button" onclick="('form-edit-<?= $i ?>');">Change</button>
                                        </td>
                                        <td>
                                            <button class="btn btn-outline-warning ba" type="button" onclick="('form-edit-<?= $i ?>');">Delete</button>
                                        </td>
                                    </form>
                                </tr>
                                <?php $i++; ?>
                            <?php endif ?>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<div id="activate-students-modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                <form id="activateStudentForm" >
                    <div class="form-row">
                        <div class="col-md-6">
                            <label class="control-label" for="name">Name</label>
                            <input type="text" name="first-name" class="form-control" PLACEHOLDER="Name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label" for="name">Surname</label>
                            <input type="text" name="surname"  class="form-control" PLACEHOLDER="Surname" required>
                        </div>

                        <input type="text" name="email" class="form-control" PLACEHOLDER="" required hidden>

                        <div class="col-md-12">
                            <label class="control-label" for="name">Additional Info</label>
                            <textarea style="min-height: 150px" name="additionalInfo" id="additionalInfo"></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="control-label" for="name">Skype</label>
                            <input type="text" name="skype"  class="form-control" PLACEHOLDER="Skype" required>
                        </div>
                        <div class="col-md-4">
                            <label class="control-label" for="name">Age</label>
                            <input type="text" name="age" class="form-control" required>
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
                    </div>
                    </td>
                    <br>
                    <button class="btn btn-success" type="submit" onclick="fillNewsStudent('','save')">Activate</button>
                    <br>
                </form>
                <div id="activate-student-message" style="text-align: center"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-warning" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="delete-students-modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                Are you sure ?
            </div>
            <div class="modal-body">
                <form id="deleteStudentForm">
                    <div style="text-align: center">
                        <input type="text" name="email" class="form-control" PLACEHOLDER="" required hidden>
                        <button class="btn btn-warning ba" type="button" onclick="fillNewsStudent('','delete')">Delete</button>
                    </div>
                    </td>
                    <div id="delete-student-message" style="text-align: center"></div>
                </form>
                <div id="activate-student-message" style="text-align: center"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-warning ba" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
