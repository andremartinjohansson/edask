<?php

namespace Anax\Comments;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;
use \Anax\Comments\Section;

class CommentsController implements InjectionAwareInterface
{
    use InjectionAwareTrait;

    private $db;
    private $session;
    private $response;

    public function init($database, $session)
    {
        $this->db = $database;
        $this->response = $this->di->get("response");
        $this->session = $session;
    }

    public function add()
    {
        $user = $this->session->get("user");
        if (!isset($user)) {
            $this->response->redirect("user/login");
        }
        $this->di->get("comments")->addComment($_POST, $this->db, $user);
        $sql = "SELECT rep FROM Rep WHERE user = ?;";
        $result = $this->db->executeFetch($sql, [$user["name"]]);
        $rep = ($result->rep + 1);
        $sql = "UPDATE Rep SET rep = ? WHERE user = ?;";
        $this->di->get("db")->execute($sql, [$rep, $user["name"]]);
        $urlParts = explode("/", $_SERVER['HTTP_REFERER']);
        $url = end($urlParts);
        if (isset($_POST["previousPage"])) {
            $urlParts = explode("/", $_POST["previousPage"]);
            $url = end($urlParts);
        }
        if (!headers_sent()) {
            $this->response->redirect($url);
        }
    }

    public function delete()
    {
        $this->di->get("comments")->deleteComment($_GET['id'], $this->db);
        $urlParts = explode("/", $_SERVER['HTTP_REFERER']);
        $url = end($urlParts);
        if (!headers_sent()) {
            $this->response->redirect($url);
        }
    }

    public function edit()
    {
        $tags = isset($_POST["tags"]) ? $_POST["tags"] : null;
        $this->di->get("comments")->editComment($_POST['id'], $_POST['comment'], $tags, $this->db);
        $urlParts = explode("/", $_SERVER['HTTP_REFERER']);
        $url = end($urlParts);
        if (!headers_sent()) {
            $this->response->redirect($url);
        }
    }

    public function get($id)
    {
        return $this->di->get("comments")->getComment($id, $this->db);
    }

    public function getAll($type)
    {
        return $this->di->get("comments")->getAllComments($type, $this->db);
    }

    public function getAllWhere($where, $value)
    {
        return $this->di->get("comments")->getCommentsWhere($where, $value, $this->db);
    }

    public function createComments($comments)
    {
        $section = new Section();
        return $section->makeComments($comments, $this->di);
    }

    public function upvote()
    {
        $id = isset($_GET["id"]) ? $_GET["id"] : null;
        $urlParts = explode("/", $_SERVER['HTTP_REFERER']);
        $url = end($urlParts);
        $this->di->get("comments")->upvoteComment($id, $this->db);
        $sql = "INSERT INTO Voted (id, user) VALUES (?, ?);";
        $this->db->execute($sql, [$id, $this->session->get("user")["name"]]);
        if (!headers_sent()) {
            $this->response->redirect($url);
        }
    }

    public function mark()
    {
        $questionId = isset($_GET["questionid"]) ? $_GET["questionid"] : null;
        $answerId = isset($_GET["answerid"]) ? $_GET["answerid"] : null;
        $urlParts = explode("/", $_SERVER['HTTP_REFERER']);
        $url = end($urlParts);
        $sql = "INSERT INTO Picked (questionid, answerid) VALUES (?, ?);";
        $this->db->execute($sql, [$questionId, $answerId]);
        if (!headers_sent()) {
            $this->response->redirect($url);
        }
    }
}
