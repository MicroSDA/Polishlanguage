<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark elegant-color" style="font-size: 75%">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
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
                    <a class="nav-link" href="/admin/secure/lessons/<?= DataManager::getInstance()->getDataByKey('admin-href')?>">Lessons</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="/admin/secure/settings/<?= DataManager::getInstance()->getDataByKey('admin-href')?>">Settings</a>
                </li>
            </ul>
            <span class="navbar-text white-text">Welcome <span class="text-info"><?= DataManager::getInstance()->getDataByKey('employee-info')['FirstName'] ?>&nbsp;&nbsp;&nbsp;</span>
                <span><a href="/admin/secure/dashboard/<?= DataManager::getInstance()->getDataByKey('admin-href')?>?submit=logout">Logout</a></span>
            </span>
        </div>
    </nav>
</header>
<div class="container-fluid">
    <div class="">
        <br>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs nav-justified">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#systemPanel" role="tab">System</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#emailPanel" role="tab">Email</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#databasePanel" role="tab">Data Base</a>
            </li>
        </ul>
        <!-- Tab panels -->
        <div class="tab-content card">
            <!--Panel 1-->
            <div class="tab-pane fade in show active" id="systemPanel" role="tabpanel">
                <br>
                <hr>
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="card">
                            <h4 class="card-title" style="text-align: center"><span
                                        class="btn btn-outline-dark"><h5 class="ba">Site Urls</h5></span></h4>
                            <div class="card-title" style="text-align: center"><button
                                        class="btn btn-outline-success ba" type="button" data-toggle="modal" data-target="#add-new-url-modal"><h6 class="ba">Add new</h6></button></div>
                            <div class="card-body" style="height:507px; overflow-y: auto; display: block">
                                <h4 class="card-title"></h4>
                                <p class="card-text"></p>

                                <table class="table table-bordered" >
                                    <thead class="elegant-color">
                                    <tr style="color:white" >
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Pattern</th>
                                        <th>Status</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1;
                                    foreach (DataManager::getInstance()->getDataByKey('URLS') as $value): ?>
                                        <tr>
                                            <form id="form-edit-<?= $i?>" method="post">
                                                <th scope="row"><?= $i ?></th>
                                                <td><?= $value['Name'] ?><input hidden name="name" type="text" value="<?= $value['Name'] ?>" required></td>
                                                <td><?= $value['Pattern'] ?><input hidden name="pattern" type="text" value="<?= $value['Pattern'] ?>" required></td>

                                                <?php if ($value['Status'] == 'active'): ?>
                                                    <td><span class="btn-success"><?= $value['Status'] ?></span></td>

                                                    <select hidden name="status" class="mdb-select colorful-select dropdown-primary">
                                                        <option value="active">Active</option>
                                                        <option value="not-active">Not active</option>
                                                    </select>
                                                <?php else: ?>
                                                    <td><span class="btn-warning"><?= $value['Status'] ?></span></td>
                                                    <select hidden name="status" class="mdb-select colorful-select dropdown-primary">
                                                        <option value="not-active">Not active</option>
                                                        <option value="active"Active</option>
                                                    </select>
                                                <?php endif ?>
                                                <td>
                                                    <button class="btn btn-outline-info ba" type="button" onclick="editUrlValidate('form-edit-<?=$i?>');">Change</button>
                                                </td>
                                                <td>
                                                    <button class="btn btn-outline-warning ba" type="button" onclick="deleteUrlValidate('form-edit-<?=$i?>');">Delete</button>
                                                </td>
                                                <td  hidden><input  hidden name="model" type="text" value="<?= $value['Model'] ?>" required></td>
                                                <td  hidden><input  hidden name="method" type="text" value="<?= $value['Method'] ?>" required></td>
                                                <td  hidden><input  hidden name="view" type="text" value="<?= $value['View'] ?>" required></td>

                                                <?php if ($value['Type'] == 'basic'): ?>
                                                    <td  hidden><select hidden name="type" class="mdb-select colorful-select dropdown-primary">
                                                            <option value="basic">Basic</option>
                                                            <option value="service">Service</option>
                                                        </select>
                                                    </td>
                                                <?php else: ?>
                                                    <td  hidden><select hidden name="type" class="mdb-select colorful-select dropdown-primary">
                                                            <option value="service">Service</option>
                                                            <option value="basic">Basic</option>
                                                        </select>
                                                    </td>
                                                <?php endif ?>
                                                <?php if ($value['Cache'] == 'yes'): ?>
                                                    <td  hidden><select hidden name="cache" class="mdb-select colorful-select dropdown-primary">
                                                            <option value="yes">Yes</option>
                                                            <option value="no">No</option>
                                                        </select>
                                                    </td>
                                                <?php else: ?>
                                                    <td  hidden><select hidden name="cache" class="mdb-select colorful-select dropdown-primary">
                                                            <option value="no">No</option>
                                                            <option value="yes">Yes</option>
                                                        </select>
                                                    </td>
                                                <?php endif ?>
                                            </form>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="card">
                            <h4 class="card-title" style="text-align: center"><span
                                        class="btn btn-outline-dark"><h5 class="ba">System's</h5></span></h4>
                            <div class="card-body" style="height:350px;">
                                <h4 class="card-title"></h4>
                                <p class="card-text"></p>
                                <br>
                                <br>
                                <br>
                                <form class="form-control" action="" type="Get">
                                    <div>
                                        <button type="submit" name="submit" value="site-map" class="btn btn-outline-primary ba"
                                                href="">Generate Site Map
                                        </button>
                                        <button type="submit" name="submit" value="reset-cache" class="btn btn-outline-warning ba"
                                                href="">Reset Cache
                                        </button>
                                    </div>
                                    <br>
                                </form>
                                <p style="text-align: center;">Href:
                                    <?= md5(getenv("REMOTE_ADDR") . "key" . time()); ?>
                                </p>
                                <p style="text-align: center;">Href:
                                    <?= md5(getenv("REMOTE_ADDR") . "key" . time()). md5(getenv("REMOTE_ADDR") . "key-2" .
                                        time()). md5(getenv("REMOTE_ADDR") . "key-3" . time()); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/.Panel 1-->
            <!--Panel 2-->
            <div class="tab-pane fade" id="emailPanel" role="tabpanel">
                <br>

            </div>
            <!--/.Panel 2-->
            <!--Panel 3-->
            <div class="tab-pane fade" id="databasePanel" role="tabpanel">
                <br>

            </div>
            <!--/.Panel 3-->
        </div>

    </div>
    <div id="add-new-url-modal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">
                    <form id="add-new-url-form" >
                        <div class="form-row">
                            <div class="col-md-4">
                                <label class="control-label" for="name">Name</label>
                                <input type="text" name="name" class="form-control" PLACEHOLDER="Page name" required>
                            </div>
                            <div class="col-md-8">
                                <label class="control-label" for="name">Pattern</label>
                                <input type="text" name="pattern"  value="(^\/    \/{0,1}$)" class="form-control" PLACEHOLDER="Pattern" required>
                            </div>
                            <div class="col-md-5">
                                <label class="control-label" for="name">Model</label>
                                <input type="text" name="model" class="form-control" PLACEHOLDER="Monel name" required>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label" for="name">Method</label>
                                <input  type="text" name="method" class="form-control" PLACEHOLDER="Method name" required>
                            </div>
                            <div class="col-md-3">
                                <label class="control-label" for="name">View</label>
                                <input  type="text" name="view" class="form-control" PLACEHOLDER="View folder path" required>
                            </div>
                            <div class="col-md-3">
                                <label class="control-label" for="name">Type</label>
                                <select name="type" class="form-control">
                                    <option value="basic">Basic</option>
                                    <option value="service">Service</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="control-label" for="name">Cache</label>
                                <select  name="cache" class="form-control">
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="control-label" for="name">Status</label>
                                <select name="status" class="form-control">
                                    <option value="active">Active</option>
                                    <option value="not-active">Not active</option>
                                </select>
                            </div>
                        </div>
                        </td>
                    </form>
                    <button class="btn btn-success" onclick="addNewUrl();">Add-new</button>
                    <br>
                    <div id="add-new-url-message"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-warning" type="button" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div id="edit-url-modal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">
                    <form id="edit-url-form">
                        <div class="form-row">
                            <div class="col-md-4">
                                <label class="control-label" for="name">Name</label>
                                <input id="edit-url-name" type="text" name="name" class="form-control" PLACEHOLDER="Page name" required>
                            </div>
                            <div class="col-md-8">
                                <label class="control-label" for="name">Pattern</label>
                                <input id="edit-url-pattern" type="text" name="pattern" class="form-control" PLACEHOLDER="Pattern" required>
                                <input hidden id="edit-url-pattern-old" type="text" name="pattern" class="form-control" PLACEHOLDER="Pattern" required>
                            </div>
                            <div class="col-md-5">
                                <label class="control-label" for="name">Model</label>
                                <input id="edit-url-model" type="text" name="model" class="form-control" PLACEHOLDER="Monel name" required>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label" for="name">Method</label>
                                <input id="edit-url-method" type="text" name="method" class="form-control" PLACEHOLDER="Method name" required>
                            </div>
                            <div class="col-md-3">
                                <label class="control-label" for="name">View</label>
                                <input id="edit-url-view" type="text" name="view" class="form-control" PLACEHOLDER="View folder path" required>
                            </div>
                            <div class="col-md-3">
                                <label class="control-label" for="name">Type</label>
                                <select id="edit-url-type" name="type" class="form-control">
                                    <option value="basic">Basic</option>
                                    <option value="service">Service</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="control-label" for="name">Cache</label>
                                <select id="edit-url-cache" name="cache" class="form-control">
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="control-label" for="name">Status</label>
                                <select id="edit-url-status" name="status" class="form-control">
                                    <option value="active">Active</option>
                                    <option value="not-active">Not active</option>
                                </select>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success" onclick="editUrl();">Save</button>
                    </form>
                    <br>
                    <div id="edit-url-message"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-warning" type="button" data-dismiss="modal" onclick="">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div id="delete-url-modal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">
                    <input hidden type="text" name="pattern" id="delete-url-pattern">
                    <div style="text-align: center"><div class="btn btn-outline-warning"><h3>Are you sure ?</h3></div></div>
                    <br>
                    <div style="text-align: center"><button type="button" class="btn btn-danger" onclick="deleteUrl()">Yes</button></div>
                    <hr size="15">
                    <br>
                    <div id="delete-url-message"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-warning" type="button" data-dismiss="modal" onclick="">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>