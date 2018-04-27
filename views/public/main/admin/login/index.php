<body>
<div class="container">
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <form method="post" action="">
        <p class="h5 text-center mb-4">Log in</p>
        <?php
        if(key_exists('error_login',DataManager::getInstance()->getAllData())){
            echo '<div  style="text-align: center"><p class="btn btn-outline-warning">'.DataManager::getInstance()->getDataByKey('error_login').'</p></div>';
        }
        ?>
        <div class="md-form">
            <i class="fa fa-envelope prefix grey-text"></i>
            <input type="email" name="email" class="form-control" required>
            <label for="defaultForm-email">Your email</label>
        </div>
        <div class="md-form">
            <i class="fa fa-lock prefix grey-text"></i>
            <input type="password" name="password" class="form-control" required>
            <label for="defaultForm-pass">Your password</label>
        </div>
        <div class="text-center">
            <button class="btn btn-default" type="submit" name="login" value="login">Login</button>
        </div>
    </form><!-- Form login -->
</div>
