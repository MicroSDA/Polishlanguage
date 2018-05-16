<body>
<div class="container-fluid">
    <div class="col-lg-12 col-sm-12" style="margin-top: 30px">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><?= DataManager::getInstance()->getDataByKey('Article')['Title'] ?></h4>
                <hr>
                <p class="card-text"><?= DataManager::getInstance()->getDataByKey('Article')['Body'] ?></p>
                <hr>
                <div class="view overlay hm-white-slight hm-zoom">
                    <img style="max-width: 200px" src="/assets/image/?hash=d372b2b0369e3eae0ad8e8d7efa89845"
                         class="thumbnail" alt="">
                </div>
                <br>
                <p>Created by: <?= DataManager::getInstance()->getDataByKey('Article')['Writer'] ?></p>
                <p class="card-text"><?= DataManager::getInstance()->getDataByKey('Article')['Time'] ?></p>
                <hr>
                <div ><a href="/articles"><span class="btn btn-outline-info"><h7>Back to all</h7></span></a></div>
            </div>
        </div>
    </div>
    <br>
    <br>
</div><!-- /.container -->