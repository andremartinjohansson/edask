<?php
/**
 * Routes for comments.
 */
return [
    "routes" => [
        [
            "info" => "Posting question",
            "requestMethod" => null,
            "path" => "post_comment",
            "callable" => ["commentsController", "add"],
        ],
        [
            "info" => "Deleting question",
            "requestMethod" => null,
            "path" => "delete_comment",
            "callable" => ["commentsController", "delete"],
        ],
        [
            "info" => "Updating...",
            "requestMethod" => null,
            "path" => "edit_comment",
            "callable" => ["commentsController", "edit"],
        ],
        [
            "info" => "Upvoted",
            "requestMethod" => null,
            "path" => "upvote",
            "callable" => ["commentsController", "upvote"],
        ],
        [
            "info" => "Mark",
            "requestMethod" => null,
            "path" => "mark",
            "callable" => ["commentsController", "mark"],
        ],
    ]
];
