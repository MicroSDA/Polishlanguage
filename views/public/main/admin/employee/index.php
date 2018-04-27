<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark elegant-color" style="font-size: 85%">
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
                <li class="nav-item active">
                    <a class="nav-link" href="/admin/secure/employee/<?= DataManager::getInstance()->getDataByKey('admin-href')?>">Employee</a>
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
            <span class="btn btn-outline-dark"><h5>Employees</h5></span>
        </h4>
        <div class="card-title" style="text-align: center">
            <button class="btn btn-outline-success" type="button" data-toggle="modal" data-target="#add-new-employee-modal">
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
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1;
                foreach (DataManager::getInstance()->getDataByKey('Employee') as $value): ?>
                    <tr>
                        <form id="form-edit-<?= $i ?>" method="post">
                            <th scope="row"><?= $i ?></th>
                            <td><?= $value['FirstName'] ?></td>
                            <td><?= $value['LastName'] ?></td>
                            <td><?= $value['Email'] ?></td>
                            <td><?= $value['Role'] ?></td>
                            <td>
                                <button class="btn btn-outline-info" type="button" onclick="('form-edit-<?= $i ?>');">Change</button>
                            </td>
                            <td>
                                <button class="btn btn-outline-warning" type="button" onclick="('form-edit-<?= $i ?>');">Delete</button>
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
<div id="add-new-employee-modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                <form id="add-new-employee-form" >
                    <div class="form-row">
                        <div class="col-md-6">
                            <label class="control-label" for="name">First Name</label>
                            <input type="text" name="first-name" class="form-control" PLACEHOLDER="First Name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label" for="name">Last Name</label>
                            <input type="text" name="last-name"  class="form-control" PLACEHOLDER="Last Name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label" for="name">Email</label>
                            <input type="email" name="email" class="form-control" PLACEHOLDER="Email" required>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label" for="name">Password</label>
                            <input  type="password" name="password" class="form-control" PLACEHOLDER="Password" required>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" for="name">Role</label>
                            <select name="type" class="form-control">
                                <option value="admin">Admin</option>
                                <option value="manager">Manager</option>
                                <option value="moderator">Moderator</option>
                                <option value="employee">Employee</option>
                            </select>
                        </div>
                    </div>
                    </td>
                </form>
                <br>
                <button class="btn btn-success" onclick="addNewEmployee();">Add-new</button>
                <br>
                <div id="add-new-employee-message"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-warning" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
