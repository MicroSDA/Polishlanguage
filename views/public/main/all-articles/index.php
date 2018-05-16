<body>
<div class="container-fluid">
    <div class="row">
        <?php foreach (DataManager::getInstance()->getDataByKey('Articles') as $value): ?>
            <div class="col-lg-12 col-sm-12" style="margin-top: 30px">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><a
                                    href="/articles/article/<?= $value['Url'] ?>"><?= $value['Title'] ?></a></h4>
                        <p class="card-text"><?= $value['Description'] ?></p>
                        <hr>
                        <div class="view overlay hm-white-slight hm-zoom">
                            <img style="max-width: 200px" src="/assets/image/?hash=d372b2b0369e3eae0ad8e8d7efa89845"
                                 class="thumbnail" alt="">
                        </div>
                        <br>
                        <p>Created by: <?= $value['Writer'] ?></p>
                        <p class="card-text"><?= $value['Time'] ?></p>
                    </div>
                </div>
            </div>
            <br>
            <br>
        <?php endforeach ?>
    </div>
</div><!-- /.container -->