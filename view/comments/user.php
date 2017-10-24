<?php

if (isset($_GET["name"])) {
    $name = $_GET["name"];
} else {
    $urlParts = explode("/", $_SERVER['HTTP_REFERER']);
    $url = end($urlParts);
    $di->get("response")->redirect($url);
    die();
}

$sql = "SELECT rep FROM Rep WHERE user = ?;";
$result = $di->get("db")->executeFetch($sql, [$name]);

$sql = "SELECT count(id) AS given FROM Voted WHERE user = ?;";
$votes = $di->get("db")->executeFetch($sql, [$name]);

?>

<div class="thread-content">

    <h2><?=$name?></h2>

    <p>Reputation: <?=$result->rep?></p>

    <p>Votes given: <?=$votes->given?></p>

    <p>All questions that the user has asked or answered.</p>

</div>

<?php

$orderBy = isset($_GET["orderby"]) ? $_GET["orderby"] : "time";

$sql = "SELECT * FROM Comments WHERE author = ? ORDER BY $orderBy DESC;";
$questions = $di->get("db")->executeFetchAll($sql, [$name]);

$interacted = array();

foreach ($questions as $question) {
    if (!in_array($question->article, $interacted)) {
        if ((substr($question->article, -1) == "a") || (substr($question->article, -1) == "b")) {
            $answered = substr($question->article, 0, 1);
            if (in_array($answered, $interacted)) {
                continue;
            } else {
                array_push($interacted, $answered);
                continue;
            }
        } elseif ((substr($question->article, -1) != "a") && (substr($question->article, -1) != "b")) {
            array_push($interacted, $question->article);
        }
    }
}

$questions = array();

foreach ($interacted as $article) {
    $question = $di->get("commentsController")->getAllWhere("article = ? AND type = ?", [$article, "question"]);
    array_push($questions, $question[0]);
}

?>

<div class="comment-section">

    <div class="sort-bar">
        <span><strong>Sort by: </strong></span>
        <a href="<?=$di->get("request")->getRoute() . "?name={$name}&orderby=time"?>" class="sort-link">Latest</a>
        <span> | </span>
        <a href="<?=$di->get("request")->getRoute() . "?name={$name}&orderby=votes"?>" class="sort-link">Most Votes</a>
    </div>

    <?php foreach ($questions as $question) : ?>
        <div class="comment-list-item">
            <div class="comment-details">
                <span class="comment-votes"><?=$question->votes?><br>votes</span>
                <span class="comment-answers"><?=$question->answers?><br>answers</span>
            </div>
            <div class="comment-main">
                <a href="<?=$di->get("url")->create('question') . "?id=" . $question->id?>" class="comment-title"><?=$question->topic?></a>
                <div class="comment-tags">
                    <?php $tags = explode(",", $question->tags); ?>
                    <?php foreach ($tags as $tag) : ?>
                        <a href="<?=$di->get("url")->create('tag') . "?name=" . $tag?>" class="comment-tag">#<?=$tag?></a>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="comment-user-details">
                <span class="user-link"><a href="<?=$di->get("url")->create('member') . "?name=" . $question->author?>"><?=$question->author?></a> / </span>
                <span class="comment-time"><?=$question->time?></span>
            </div>
        </div>
    <?php endforeach; ?>

</div>
