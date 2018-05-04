<body>
<main>
    <h1>INDEX PAGE</h1>
    <div id="register-new-user-block" style="margin-left: 20px">
        <form id="register-new-user-form">
            First Name<br>
            <input id="first-name" name="first-name" type="text" required/><br>
            Last Name<br>
            <input id="last-name" name="last-name" type="text" required/><br>
            Email<br>
            <input id="email" name="email" type="email" required/><br>
            Phone<br>
            <input id="phone" name="phone" type="text" value="+" required/><br>
            Skype<br>
            <input id="skype" name="skype" type="text"/><br>
            Password<br>
            <input id="password" name="password" type="password" required/><br>
            Confirm Password<br>
            <input id="password-confirm" name="password-confirm" type="password" required/><br><br>
            <button name="submit" type="button" onclick="registerNewUser();">Register</button><br>
        </form>
    </div>
    <div id="register-new-user-message"></div>
    <br>
    <a href="/account">Account</a><br>
    <a href="/login">Login</a><br>
</main>