<body>
<main>
   <h1>PERSONAL AREA PAGE</h1>
    <?php foreach (DataManager::getInstance()->getDataByKey('Lessons') as $value): ?>
        <a href="/lessons-donwload?hash=<?= $value['Url']?>"><?= $value['Name']?></a><br>
    <?php endforeach ?>
</main>