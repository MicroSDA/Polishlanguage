<body>
<main>
    <h1>Login</h1>
    <div id="login-user-block" style="margin-left: 20px">
        <form id="login-user-form"  onsubmit="return false">
            Email<br>
            <input id="email" name="email" type="email" required/><br>
            Password<br>
            <input id="password" name="password" type="password" required/><br><br>
            <button name="submit" type="submit" onclick="login();">Login</button><br>
        </form>
    </div>
    <div id="login-user-message"></div>
</main>