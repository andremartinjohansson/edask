<?php

if ($di->get("session")->get("user") == null) {
    $di->get("response")->redirect("user/login");
}

$email_hash = md5(strtolower(trim($di->get("session")->get("user")["email"])));

?>

<div class="profile">

    <div class="profile-info">

        <h1>My Profile</h1>
        <p>Logged in as: <?=$di->get("session")->get("user")["name"]?>, <?=$di->get("session")->get("user")["email"]?></p>
        <img class="profile-pic" src="https://www.gravatar.com/avatar/<?=$email_hash?>?s=200&amp;d=http%3A%2F%2Fi.imgur.com%2FCrOKsOd.png" alt="gravatar">
        <p class="info">No avatar? We use <a href="https://sv.gravatar.com/">Gravatar</a>. Go there and sync an avatar to your email.</p>

    </div>

    <div class="profile-links">

        <?php
        if ($di->get("session")->get("user")["role"] == "admin") {?>
            <a class='profile-item' href="<?=$di->get("url")->create('admin')?>">Manage users<br></a><?php
        }?>

        <a class='profile-item' href="<?=$di->get("url")->create('user/email')?>">Change Email<br></a>
        <a class='profile-item' href="<?=$di->get("url")->create('user/logout')?>">Log out<br></a>

    </div>

</div>
