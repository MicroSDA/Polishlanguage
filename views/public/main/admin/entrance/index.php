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
                <li class="nav-item">
                    <a class="nav-link" href="/admin/secure/employee/<?= DataManager::getInstance()->getDataByKey('admin-href')?>">Employee</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="/admin/secure/entrance/<?= DataManager::getInstance()->getDataByKey('admin-href')?>">Entrance</a>
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
            <span class="btn btn-outline-dark"><h5>Blocked</h5></span>
        </h4>
        <div class="card-title" style="text-align: center">
            <button class="btn btn-outline-success" type="button" data-toggle="modal" data-target="#add-new-block-modal">
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
                    <th>Ip</th>
                    <th>Time</th>
                    <th>Reason</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1;
                foreach (DataManager::getInstance()->getDataByKey('Entrance') as $value): ?>
                    <tr>
                        <form id="form-edit-<?= $i ?>" method="post">
                            <th scope="row"><?= $i ?></th>
                            <td><?= $value['IP'] ?></td>
                            <td><?= $value['Time'] ?></td>
                            <td><?= $value['Reason'] ?></td>
                            <td  hidden><input  hidden name="ip" type="text" value="<?= $value['IP'] ?>" required></td>
                            <td>
                                <button class="btn btn-outline-info" type="button" onclick="deleteBlockValidate('form-edit-<?= $i ?>');">Remove</button>
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
<div id="add-new-block-modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                <form id="add-new-block-form" >
                    <div class="form-row">
                        <div class="col-md-3">
                            <label class="control-label" for="name">Ip</label>
                            <input type="text" name="ip" class="form-control" PLACEHOLDER="Ip" required>
                        </div>
                        <div class="col-md-9">
                            <label class="control-label" for="name">Reason</label>
                            <input type="text" name="reason"  class="form-control" PLACEHOLDER="Reason" required>
                        </div>
                    </div>
                    </td>
                </form>
                <br>
                <button class="btn btn-success" onclick="addNewBlock();">Add-new</button>
                <br>
                <div id="add-new-block-message"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-warning" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="delete-block-modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                <input hidden type="text" name="ip" id="delete-block-ip">
                <div style="text-align: center"><div class="btn btn-outline-warning"><h3>Are you sure ?</h3></div></div>
                <br>
                <div style="text-align: center"><button type="button" class="btn btn-danger" onclick="deleteBlock();">Yes</button></div>
                <hr size="15">
                <br>
                <div id="delete-block-message"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-warning" type="button" data-dismiss="modal" onclick="">Close</button>
            </div>
        </div>
    </div>
</div>
