<?php

namespace Anax\Comments;

use \Anax\Database\ActiveRecordModel;

/**
 * A database driven model.
 */
class Comment extends ActiveRecordModel
{

    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Comments";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $article;
    public $author;
    public $email;
    public $topic;
    public $comment;
    public $type;
    public $time;
    public $votes;
    public $tags;
}
