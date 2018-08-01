
<body style="background: url('/public/images/back.png')">
<main>

    <div class="container-fluid" style="max-width: 500px; margin-top: 15%">
        <div class="jumbotron">
            <div id="login-user-block">
                <form id="login-user-form" onsubmit="return false">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp"
                               placeholder="Введите email" required>

                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Пароль</label>
                        <input type="password" class="form-control" id="password" name="password"
                               placeholder="Пароль">
                    </div>
                    <button class="btn btn-success" name="submit" type="submit" onclick="login();">Войти</button>
                </form>
                <br>
                <div id="login-user-message"></div>
            </div>
        </div>
    </div>
</main>