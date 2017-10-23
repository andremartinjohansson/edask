<?php
/**
 * Routes for controller.
 */
return [
    "routes" => [
        [
            "info" => "Manage users.",
            "requestMethod" => "get",
            "path" => "",
            "callable" => ["adminController", "getIndex"],
        ],
        [
            "info" => "Create a user.",
            "requestMethod" => "get|post",
            "path" => "create",
            "callable" => ["adminController", "getPostCreateItem"],
        ],
        [
            "info" => "Delete a user.",
            "requestMethod" => "get|post",
            "path" => "delete",
            "callable" => ["adminController", "getPostDeleteItem"],
        ],
        [
            "info" => "Update a user.",
            "requestMethod" => "get|post",
            "path" => "update/{id:digit}",
            "callable" => ["adminController", "getPostUpdateItem"],
        ],
    ]
];
