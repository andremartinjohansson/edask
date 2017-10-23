<?php

namespace Anax\Comments;

class Comments
{

    private $data = array();
    private $article;
    private $answers = array();

    public function init($db)
    {
        $comment = new Comment();
        $comment->setDb($db);

        $this->data = array();

        $allComments = $comment->findAllWhere("type = ?", "question");
        foreach ($allComments as $comment) {
            $input = array(
                'id' => $comment->id,
                'article' => $comment->article,
                'author' => $comment->author,
                'email' => $comment->email,
                'comment' => $comment->comment,
                'topic' => $comment->topic,
                'type' => $comment->type,
                'time' => $comment->time,
                'votes' => $comment->votes,
                'tags' => $comment->tags,
                'answers' => $comment->answers);

            if ($input["votes"] === null) {
                $input["votes"] = 0;
            }

            array_push($this->data, $input);
        }

        $last = end($this->data);
        $this->article = $last["article"];
    }

    public function getComment($id, $db)
    {
        $comment = new Comment();
        $comment->setDb($db);
        $content = $comment->find("id", $id);

        return $content;
    }

    public function getCommentsWhere($where, $value, $db)
    {
        $comment = new Comment();
        $comment->setDb($db);
        $content = $comment->findAllWhere($where, $value);

        return $content;
    }

    public function getAllComments($type, $db)
    {
        if ($type == "array") {
            return $this->data;
        } elseif ($type == "object") {
            $comment = new Comment();
            $comment->setDb($db);
            $questions = $comment->findAllWhere("type = ?", "question");
            return $questions;
        }
    }

    public function addComment($vars, $db, $user)
    {
        if (isset($vars["article"])) {
            $article = $vars["article"];
            if (substr($article, -1) == "a") {
                $type = "answer";
            } else {
                $type = "reply";
            }
            $tags = null;
            $topic = null;
            $answers = null;
        } else {
            $article = ($this->article + 1);
            $type = "question";
            $tags = $vars["tags"];
            $topic = $vars["topic"];
            $answers = 0;
        }

        if ($type == "answer") {
            $questionId = substr($article, 0, 1);
            $comment = new Comment();
            $comment->setDb($db);
            $old = $comment->find("id", $questionId);
            $comment->article = $old->article;
            $comment->author = $old->author;
            $comment->email = $old->email;
            $comment->comment = $old->comment;
            $comment->topic = $old->topic;
            $comment->type = $old->type;
            $comment->time = $old->time;
            $comment->votes = $old->votes;
            $comment->tags = $old->tags;
            $comment->answers = ($old->answers + 1);
            $comment->save();
        }

        $input = array(
            'id' => ($this->commentCount() + 1),
            'article' => $article,
            'author' => $user["name"],
            'email' => $user["email"],
            'comment' => $vars["comment"],
            'topic' => $topic,
            'type' => $type,
            'tags' => $tags,
            'answers' => $answers);

        if (isset($vars["article"])) {
            array_push($this->answers, $input);
        } else {
            array_push($this->data, $input);
        }

        $comment = new Comment();
        $comment->setDb($db);
        $comment->article = $input['article'];
        $comment->author = $user["name"];
        $comment->email = $user["email"];
        $comment->comment = $input['comment'];
        $comment->topic = $input['topic'];
        $comment->type = $input['type'];
        $comment->votes = 0;
        $comment->tags = $input['tags'];
        $comment->answers = $input['answers'];
        $comment->save();
    }

    public function deleteComment($id, $db)
    {
        $comment = new Comment();
        $comment->setDb($db);
        $comment = $comment->find("id", $id);
        $comment->delete();
    }

    public function editComment($id, $text, $tags, $db)
    {
        $comment = new Comment();
        $comment->setDb($db);
        $old = $comment->find("id", $id);
        $comment->article = $old->article;
        $comment->author = $old->author;
        $comment->email = $old->email;
        $comment->comment = $text;
        $comment->topic = $old->topic;
        $comment->type = $old->type;
        $comment->time = $old->time;
        $comment->votes = $old->votes;
        $comment->tags = $tags;
        $comment->answers = $old->answers;
        $comment->save();
    }

    public function commentCount()
    {
        return count($this->data);
    }

    public function upvoteComment($id, $db)
    {
        $comment = new Comment();
        $comment->setDb($db);
        $old = $comment->find("id", $id);
        $comment->article = $old->article;
        $comment->author = $old->author;
        $comment->email = $old->email;
        $comment->comment = $old->comment;
        $comment->topic = $old->topic;
        $comment->type = $old->type;
        $comment->time = $old->time;
        $comment->votes = ($old->votes + 1);
        $comment->tags = $old->tags;
        $comment->answers = $old->answers;
        $comment->save();

        $sql = "SELECT rep FROM Rep WHERE user = ?;";
        $result = $db->executeFetch($sql, [$comment->author]);
        $rep = ($result->rep + 1);
        $sql = "UPDATE Rep SET rep = ? WHERE user = ?;";
        $db->execute($sql, [$rep, $comment->author]);
    }
}
