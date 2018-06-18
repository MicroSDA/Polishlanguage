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
                <li class="nav-item active">
                    <a class="nav-link" href="/admin/secure/articles/<?= DataManager::getInstance()->getDataByKey('admin-href')?>">Articles</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="/admin/secure/employee/<?= DataManager::getInstance()->getDataByKey('admin-href')?>">Employee</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/secure/entrance/<?= DataManager::getInstance()->getDataByKey('admin-href')?>">Entrance</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/secure/students/<?= DataManager::getInstance()->getDataByKey('admin-href')?>">Students</a>
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
            <span class="navbar-text white-text">Welcome <span class="text-info"><?= DataManager::getInstance()->getDataByKey('employee-info')['FirstName'] ?>&nbsp;&nbsp;&nbsp;</span>
                <span><a href="/admin/secure/dashboard/<?= DataManager::getInstance()->getDataByKey('admin-href')?>?submit=logout">Logout</a></span>
            </span>
        </div>
    </nav>
</header>

<div class="container-fluid">
    <h4 class="card-title" style="text-align: center"><span
                class="btn btn-outline-dark"><h5>Articles</h5></span></h4><hr>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs nav-justified">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#panel1" role="tab">New</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#panel2" role="tab">All</a>
        </li>
    </ul>
    <!-- Tab panels -->
    <div class="tab-content card">
        <!--Panel 1-->
        <div class="tab-pane fade in show active" id="panel1" role="tabpanel">
            <div id="add-article-error-message"></div>
            <hr>
            <br>
            <form id="add-article">
                <div class="form-row">
                    <div class="col-lg-6">
                        <input type="text" name="title" class="form-control" PLACEHOLDER="Title" required>
                    </div>
                    <div class="col-lg-6">
                        <input type="text" name="url" class="form-control" PLACEHOLDER="Url" required>
                    </div>
                    <div class="col-lg-12">
                       <!-- <textarea id="article-body" name="article-body"></textarea>-->
                        <textarea name="article_body" id="article_body" rows="10" cols="80"></textarea>
                        <script type="text/javascript">
                            var CKEDITOR_BASEPATH = '/public/contents/ckeditor/';
                            var CKEDITOR_CONFIG_BASEPATH = '/assets/js/?page=Admin&hash=44asdasdasdasdf27dbs39df6aee19b615b430f333a0/';
                            document.addEventListener("DOMContentLoaded", function (){initAdd();});
                        </script>
                        <script>//CKEDITOR.replace('article_body');</script>
                    </div>
                </div>
            </form>
            <div>
                <br>
                <button class="btn btn-success" onclick="addArticle();">Add</button>
            </div>
        </div>
        <!--/.Panel 1-->
        <!--Panel 2-->
        <div class="tab-pane fade" id="panel2" role="tabpanel">
            <div style="height:507px; overflow-y: auto; display: block">
            <table class="table table-bordered">
                <thead class="elegant-color">
                <tr style="color:white">
                    <th>#</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Url</th>
                    <th>Writer</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php $i=1; foreach (DataManager::getInstance()->getDataByKey('Articles') as $value): ?>
                <form id="form-article-edit-<?= $i?>">
                <tr>
                    <td><?= $i?></td>
                    <td><?= $value['Title'] ?><input hidden name="title" type="text" value="<?= $value['Title'] ?>"></td>
                    <td><?= $value['Description'] ?></td>
                    <td><?= $value['Url'] ?><input hidden name="url" type="text" value="<?= $value['Url'] ?>" ></td>
                    <td><?= $value['Writer'] ?><input hidden name="name" type="text" value="<?= $value['Writer'] ?>" ></td>
                    <td><button class="btn btn-outline-info" type="button" onclick="editArticleValidate('form-article-edit-<?=$i?>');">Edit</button></td>
                    <td><button class="btn btn-outline-warning" type="button" onclick="deleteArticleValidate('form-article-edit-<?=$i?>');">Delete</button></td>
                </tr>
                </form>
                    <?php $i++?>
                <?php endforeach ?>
                </tbody>
            </table>
            </div>
        </div>
        <!--/.Panel 2-->
    </div>
</div>
<div id="edit-article-modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                <form id="edit-article-form" >
                    <div class="form-row">
                        <div class="col-md-4">
                            <label class="control-label" for="name">Title</label>
                            <input type="text" id="edit-article-title" name="title" class="form-control" PLACEHOLDER="Page name" required>
                        </div>
                        <div class="col-md-4">
                            <label class="control-label" for="name">Url</label>
                            <input type="text" id="edit-article-url" name="url"   class="form-control" PLACEHOLDER="Url" required>
                            <input type="text" id="edit-article-url-old"  name="url-old" class="form-control" hidden>
                        </div>
                        <div class="col-md-4">
                            <label class="control-label" for="name">Writer</label>
                            <input type="text" id="edit-article-writer" name="writer" class="form-control" PLACEHOLDER="Writer name" required>
                        </div>
                        <div class="col-md-12">
                            <textarea name="edit_rticle_body" id="edit_article_body" rows="10" cols="80"></textarea>
                            <script type="text/javascript">
                                var CKEDITOR_BASEPATH = '/public/contents/ckeditor/';
                                var CKEDITOR_CONFIG_BASEPATH = '/assets/js/?page=Admin&hash=44asdasdasdasdf27dbs39df6aee19b615b430f333a0/';
                                document.addEventListener("DOMContentLoaded", function (){initEdit();});
                            </script>
                            <script>//CKEDITOR.replace('edit_article_body');</script>
                        </div>
                    </div>
                    </td>
                    <button type="button" class="btn btn-success" onclick="editArticle();">Save</button>
                </form>
                <br>
                <div id="edit-article-message"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-warning" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="delete-article-modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                <input hidden type="text" name="pattern" id="delete-article-url">
                <div style="text-align: center"><div class="btn btn-outline-warning"><h3>Are you sure ?</h3></div></div>
                <br>
                <div style="text-align: center"><button type="button" class="btn btn-danger" onclick="deleteArticle();">Yes</button></div>
                <hr size="15">
                <br>
                <div id="delete-article-message"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-warning" type="button" data-dismiss="modal" onclick="">Close</button>
            </div>
        </div>
    </div>
</div>
