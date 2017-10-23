<?php
/**
 * Routes for flat file content.
 */
return [
    "routes" => [
        [
            "info" => "File content.",
            "requestMethod" => null,
            "path" => "",
            "callable" => ["ContentController", "renderIndex"],
        ],
        [
            "info" => "File content.",
            "requestMethod" => null,
            "path" => "roster",
            "callable" => ["ContentController", "renderRoster"],
        ],
        [
            "info" => "File content.",
            "requestMethod" => null,
            "path" => "tags",
            "callable" => ["ContentController", "renderTags"],
        ],
        [
            "info" => "File content.",
            "requestMethod" => null,
            "path" => "about",
            "callable" => ["ContentController", "renderAbout"],
        ],
        [
            "info" => "Ask Away!",
            "requestMethod" => null,
            "path" => "ask",
            "callable" => ["ContentController", "renderMain"],
        ],
        [
            "info" => "Edit",
            "requestMethod" => null,
            "path" => "preview",
            "callable" => ["ContentController", "renderEdit"],
        ],
        [
            "info" => "View Question",
            "requestMethod" => null,
            "path" => "question",
            "callable" => ["ContentController", "renderComment"],
        ],
        [
            "info" => "View Member",
            "requestMethod" => null,
            "path" => "member",
            "callable" => ["ContentController", "renderUser"],
        ],
        [
            "info" => "View Tag",
            "requestMethod" => null,
            "path" => "tag",
            "callable" => ["ContentController", "renderTag"],
        ],
        [
            "info" => "Reply",
            "requestMethod" => null,
            "path" => "reply",
            "callable" => ["ContentController", "renderReply"],
        ],
    ]
];
