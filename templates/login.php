<!doctype html>
<html>
<body>

<h1>Login</h1>

<form
    action="index.php"
    method="post"
>
    <input type="hidden" name="action" value="processLogin">

    username:
    <input name="username" id="username">

    <p>

    password:
        <input name="password" id="password">

    <input type="submit" name="login_name" id="login_id" value="LOGIN">
</form>

<?php
require_once __DIR__ . '/_nav.php';