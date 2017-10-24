<?php

if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    $urlParts = explode("/", $_SERVER['HTTP_REFERER']);
    $url = end($urlParts);
    $di->get("response")->redirect($url);
    die();
}

$comment = $di->get("commentsController")->get($id);

if ($comment->author !== $di->get("session")->get("user")['name']) {
    if ($di->get("session")->get("user")['role'] !== "admin") {
        $di->get("response")->redirect("404");
    }
}

$text = $comment->comment;
$tags = explode(",", $comment->tags);
$tagSection = "";
foreach ($tags as $tag) {
    $tagSection .=
    <<<EOD
    <a href="" class="tag">#{$tag}</a>
EOD;
}

$emailHash = md5(strtolower(trim($comment->email)));
$userUrl = $di->get("url")->create('member') . "?name=" . $comment->author;

?>

<h2 class="center">Edit</h2>

    <!-- <div class="preview">
        <img class="avatar"
        src="https://www.gravatar.com/avatar/<?=$emailHash?>?s=100&amp;d=http%3A%2F%2Fi.imgur.com%2FCrOKsOd.png"
        alt="gravatar">
        <address class="vcard author-prev">
            By <strong><a href="<?=$userUrl?>"><?=$comment->author?></a></strong><br>
        </address>

        <div class="entry-content">
            <?=$text?>
        </div>
        <?php if (isset($comment->tags)) : ?>
        <div class="tags-container">
            <?=$tagSection?>
        </div>
        <?php endif; ?>
    </div> -->

    <form action="<?=$di->get("url")->create('edit_comment')?>" method="post">

    <input type="hidden" name="id" value="<?=$_GET['id']?>">
    <input type="hidden" name="previous" value="<?=$_SERVER['HTTP_REFERER']?>">
    <div class="leave-comment">
        <div class="compose-comment">
            <textarea class="comment-text" name="comment" required="required"><?=$text?></textarea>
            <?php if (isset($comment->tags)) : ?>
            <p class="p-tags">Tags</p>
            <input class="input-tags" type="text" name="tags" value="<?=$comment->tags?>" placeholder="Tags">
            <?php endif; ?>
        </div>
    </div>

    <input class="comment-post" name="submit" type="submit" value="Submit">

</form>
