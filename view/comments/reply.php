<?php

if (isset($_GET["id"])) {
    $article = $_GET["id"];
} else {
    die();
}

$id = substr($article, 0, 1);

$question = $di->get("commentsController")->get($id);

$emailHash = md5(strtolower(trim($question->email)));
$userUrl = $di->get("url")->create('member') . "?name=" . $question->author;

?>

<div class="thread-content">

    <h2>Replying to <?=$question->author?></h2>

    <!-- <div class="preview">
        <div class="reply">
            <img class="avatar"
            src="https://www.gravatar.com/avatar/<?=$emailHash?>?s=100&amp;d=http%3A%2F%2Fi.imgur.com%2FCrOKsOd.png"
            alt="gravatar">
            <address class="vcard author-prev">
                By <strong><a href="<?=$userUrl?>"><?=$question->author?></a></strong><br>
            </address>
            <div class="entry-content">
                <?=$question->comment?>
            </div>
        </div>
    </div> -->

</div>

<form action="<?=$di->get("url")->create('post_comment')?>" method="post">
    <input type="hidden" name="article" value="<?=$article?>">
    <input type="hidden" name="previousPage" value="<?=$_SERVER['HTTP_REFERER']?>">
    <textarea class="write-reply" name="comment" required="required" placeholder="Reply..."></textarea>
    <input class="post-reply" name="submit" type="submit" value="Post">
</form>
