<?php

namespace Anax\Comments;

/**
 * Convert bbcode to HTML
 */
class Section
{
    public function makeReplies($reply, $di)
    {
        $replySection = "";
        $user = $di->get("session")->get("user");
        $filter = $di->get("textfilter");
        $authorRep = $reply->author;
        $contentRep = $filter->doFilter($reply->comment, "markdown");
        $emailHashRep = md5(strtolower(trim($reply->email)));
        // $timeRep = $reply->time;
        $userUrlRep = $di->get("url")->create('member') . "?name=" . $reply->author;
        $voteUrlR = $di->get("url")->create('upvote') . "?id=" . $reply->id;
        $sql = "SELECT user FROM Voted WHERE id = ?;";
        $usersVotedR = $di->get("db")->executeFetchAll($sql, [$reply->id]);
        $arrayVotedR = array();
        $votesRep = $reply->votes;
        if ($votesRep === 0) {
            $votesRep = "";
        }
        foreach ($usersVotedR as $member) {
            array_push($arrayVotedR, $member->user);
        }
        if (in_array($user["name"], $arrayVotedR) || ($reply->author == $user["name"])) {
            $voted = true;
        } else {
            $voted = false;
        }
        $votedLinkR = "";
        if (!$voted) {
            $votedLinkR =
            <<<EOD
            <a href="{$voteUrlR}" class="upvote">+1</a>
EOD;
        }
        $mLink = $this->makeManageLinks($authorRep, $reply, $di);
        $edit = $mLink[0];
        $delete = $mLink[1];
        $replySection .=
            <<<EOD
            <div class="reply">
            <span class="reply-votes">{$votesRep}</span>
            <img class="avatar-reply"
            src="https://www.gravatar.com/avatar/{$emailHashRep}?s=100&amp;d=http%3A%2F%2Fi.imgur.com%2FCrOKsOd.png"
            alt="gravatar">
            <address class="vcard author-reply">
            By <strong><a href="{$userUrlRep}">{$authorRep}</a></strong><br>
            </address>
            <div class="entry-content-reply">
            {$contentRep}
            </div>
            <div class="reply-actions">
            {$edit}
            {$delete}
            {$votedLinkR}
            </div>
            <div class="under-content-reply">
            </div>
            </div>
EOD;
        return $replySection;
    }

    public function makeVoteLink($content, $di)
    {
        $user = $di->get("session")->get("user");
        $voteUrl = $di->get("url")->create('upvote') . "?id=" . $content->id;
        $sql = "SELECT user FROM Voted WHERE id = ?;";
        $usersVoted = $di->get("db")->executeFetchAll($sql, [$content->id]);
        $arrayVoted = array();
        foreach ($usersVoted as $member) {
            array_push($arrayVoted, $member->user);
        }
        if (in_array($user["name"], $arrayVoted) || ($content->author == $user["name"])) {
            $voted = true;
        } else {
            $voted = false;
        }
        $votedLink = "";
        if (!$voted) {
            $votedLink =
            <<<EOD
            <a href="{$voteUrl}" class="upvote">+1</a>
EOD;
        }
        return $votedLink;
    }

    public function makeAnswers($comment, $question, $di)
    {
        $commentSection = "";
        $user = $di->get("session")->get("user");
        $filter = $di->get("textfilter");
        $pickUrl = "";
        $pick = $di->get("url")->create('mark') . "?questionid=" . $question->id . "&answerid=" . $comment->id;
        $sql = "SELECT * FROM Picked WHERE questionid = ?;";
        $picked = $di->get("db")->executeFetch($sql, [$question->id]);
        if ($user["name"] == $question->author) {
            if (!$picked) {
                $pickUrl = "<a href='{$pick}' class='pick-link'>Mark as Answer</a>";
            }
        }
        if ($picked) {
            if ($picked->answerid == $comment->id) {
                $pickUrl = "<img src='image/mark.png' alt='Marked' class='marked'>";
            }
        }
        $authorCom = $comment->author;
        $contentCom = $filter->doFilter($comment->comment, "markdown");
        $emailHashCom = md5(strtolower(trim($comment->email)));
        // $timeCom = $comment->time;
        $votesCom = $comment->votes;
        $replySection = "";
        $articleReply = $comment->id . "b";
        $userUrlAns = $di->get("url")->create('member') . "?name=" . $comment->author;
        $replyUrl = $di->get("url")->create('reply') . "?id=" . $articleReply;
        $replies = $di->get("commentsController")->getAllWhere("article = ?", $articleReply);
        $votedLinkA = $this->makeVoteLink($comment, $di);
        foreach ($replies as $reply) {
            $replySection .= $this->makeReplies($reply, $di);
        }
        $mLink = $this->makeManageLinks($authorCom, $comment, $di);
        $edit = $mLink[0];
        $delete = $mLink[1];
        $commentSection .=
            <<<EOD
            <div class="answer">
            <img class="avatar-answer"
            src="https://www.gravatar.com/avatar/{$emailHashCom}?s=100&amp;d=http%3A%2F%2Fi.imgur.com%2FCrOKsOd.png"
            alt="gravatar">
            <address class="vcard author-answer">
            By <strong><a href="{$userUrlAns}">{$authorCom}</a></strong><br>
            </address>
            <div class="entry-content-answer">
            {$contentCom}
            </div>
            {$pickUrl}
            <div class="answer-actions">
            {$edit}
            {$delete}
            </div>
            <div class="under-content">
            <a href="{$replyUrl}"><strong>Reply</strong></a>
            <div class="rate-answer"><span class="votes">{$votesCom} votes</span>{$votedLinkA}</div>
            </div>
            <div class="replies">
            {$replySection}
            </div>
            </div>
            <div class="under-content-answer">
            </div>
EOD;
        return $commentSection;
    }

    public function makeTags($tags, $di)
    {
        $tagSection = "";
        foreach ($tags as $tag) {
            $tagUrl = $di->get("url")->create('tag') . "?name=" . $tag;
            $tagSection .=
            <<<EOD
            <a href="{$tagUrl}" class="tag">#{$tag}</a>
EOD;
        }
        return $tagSection;
    }

    public function makeManageLinks($author, $content, $di)
    {
        $edt = $di->get("url")->create('preview');
        $del = $di->get("url")->create('delete_comment');
        $user = $di->get("session")->get("user");
        if ($user["name"] == $author) {
            $delete = "<p><a href='" . $del . "?id=" . $content->id . "'>Remove</a></p>";
            $edit = "<p><a href='" . $edt . "?id=" . $content->id . "'>Edit</a></p>";
        } elseif ($user["role"] == "admin") {
            $delete = "<p><a href='" . $del . "?id=" . $content->id . "'>Remove</a></p>";
            $edit = "<p><a href='" . $edt . "?id=" . $content->id . "'>Edit</a></p>";
        } else {
            $delete = "";
            $edit = "";
        }
        return [$edit, $delete];
    }

    public function makeComments($content, $di)
    {
        $htmlSection = "";
        $filter = $di->get("textfilter");

        foreach ($content as $question) {
            $author = $question->author;
            $content = $filter->doFilter($question->comment, "markdown");
            $emailHash = md5(strtolower(trim($question->email)));
            $time = $question->time;
            $tags = explode(",", $question->tags);
            $tagSection = $this->makeTags($tags, $di);
            $post = $di->get("url")->create('post_comment');
            $articleComment = $question->article . "a";
            $votes = $question->votes;
            $topic = $question->topic;
            $comments = $di->get("commentsController")->getAllWhere("article = ?", $articleComment);
            $commentSection = "";
            $url = $di->get("url")->create('question') . "?id=" . $question->id;
            $userUrl = $di->get("url")->create('member') . "?name=" . $question->author;
            $votedLink = $this->makeVoteLink($question, $di);
            foreach ($comments as $comment) {
                $commentSection .= $this->makeAnswers($comment, $question, $di);
            }
            $mLink = $this->makeManageLinks($author, $question, $di);
            $edit = $mLink[0];
            $delete = $mLink[1];
            $articleReplyMain = $question->id . "b";
            $replyUrlMain = $di->get("url")->create('reply') . "?id=" . $articleReplyMain;
            $repliesMain = $di->get("commentsController")->getAllWhere("article = ?", $articleReplyMain);
            $replySectionMain = "";
            foreach ($repliesMain as $reply) {
                $replySectionMain .= $this->makeReplies($reply, $di);
            }
            $loginUrl = $di->get("url")->create('user/login');
            if ($di->get("session")->get("user")) {
                $compose =
                <<<EOD
                <form action="{$post}" method="post">
                <input type="hidden" name="article" value="{$articleComment}">
                <textarea class="write-comment" name="comment" required="required" placeholder="Write an answer..."></textarea>
                <input class="answer-post" name="submit" type="submit" value="Post">
                </form>
EOD;
            } else {
                $compose =
                <<<EOD
                <p class="entry-content">You have to be <a href="{$loginUrl}">logged</a> in before answering questions.</p>
EOD;
            }
            $htmlSection .=
                <<<EOD
                <div class="comment">
                <p class="q-topic"><a href="{$url}">{$topic}</a></p>
                <img class="avatar"
                src="https://www.gravatar.com/avatar/{$emailHash}?s=100&amp;d=http%3A%2F%2Fi.imgur.com%2FCrOKsOd.png"
                alt="gravatar">
                <address class="vcard author">
                By <strong><a href="{$userUrl}">{$author}</a></strong><br>
                <span>{$time}</span>
                </address>

                <div class="entry-content">
                {$content}
                </div>
                <div class="comment-actions">
                {$edit}
                {$delete}
                </div>
                <div class="tags-container">
                {$tagSection}
                </div>
                <a href="{$replyUrlMain}" class="reply-main"><strong>Reply</strong></a>
                <div class="replies">
                {$replySectionMain}
                </div>
                <div class="rate-actions">
                    <span><strong>Answers</strong></span>
                    <div class="rate-answer"><span class="votes">{$votes} votes</span>{$votedLink}</div>
                </div>
                <div class="answers">
                {$commentSection}
                </div>
                <div class="add-comment">
                {$compose}
                </div>
                </div>
EOD;
        }
        return $htmlSection;
    }
}
