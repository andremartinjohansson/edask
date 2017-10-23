<ul>

    <li><a class="ua-link" href="<?=$di->get("url")->create("ask")?>">Ask</a></li>
    <li><a class="ua-link" href="<?=$di->get("url")->create("roster")?>">Roster</a></li>
    <li><a class="ua-link" href="<?=$di->get("url")->create("tags")?>">Tags</a></li>
    <li><a class="ua-link" href="<?=$di->get("url")->create("about")?>">About</a></li>
    <div class="user-actions">
        <?php if ($di->get("session")->get("user") == null) { ?>
        <li><a class="ua-link" href="<?=$di->get("url")->create("user/login")?>">Login</a></li>
        <li><a class="ua-link" href="<?=$di->get("url")->create("user/create")?>">Register</a></li>
        <?php } else { ?>
        <li><a class="ua-link" href="<?=$di->get("url")->create("user")?>">Profile</a></li>
        <li><a class="ua-link" href="<?=$di->get("url")->create('user/logout')?>">Log out</a></li>
        <?php } ?>
    </div>

</ul>
