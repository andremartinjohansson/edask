<?php

if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    $urlParts = explode("/", $_SERVER['HTTP_REFERER']);
    $url = end($urlParts);
    $di->get("response")->redirect($url);
    die();
}

$question = $di->get("commentsController")->get($id);
if (!$question) {
    $di->get("response")->redirect("ask");
}

?>

<div class="thread-content">

    <h2><?=$question->topic?></h2>

</div>

<div class="comment-section">
<?php
$questions = [$question];
$htmlSection = $di->get("commentsController")->createComments($questions);

echo $htmlSection
?>
</div>
