<body>
<main>
   <h1>INDEX PAGE</h1>
    <div id="register-new-user-block" style="margin-left: 20px">
        <form id="register-new-user-form"method="post">
            First Name<br>
            <input id="first-name" name="first-name" type="text" required/><br>
            Last Name<br>
            <input id="last-name" name="last-name" type="text" required/><br>
            Email<br>
            <input id="email" name="email" type="email" required/><br>
            Phone<br>
            <input id="phone" name="phone" type="text" required/><br>
            Skype<br>
            <input id="skype" name="skype" type="text"/><br>
            Password<br>
            <input id="password" name="password" type="password" required/><br>
            <button name="submit" type="button" onclick="registerNewUser();">Register</button>
        </form>
    </div>
    <div id="register-new-user-message"></div>
</main>