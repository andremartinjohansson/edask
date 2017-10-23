<?php

if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    die();
}

$question = $di->get("commentsController")->get($id);

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
