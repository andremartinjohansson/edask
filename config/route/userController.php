<?php
/**
 * Routes for user controller.
 */
return [
    "routes" => [
        [
            "info" => "User Controller index.",
            "requestMethod" => "get",
            "path" => "",
            "callable" => ["userController", "getIndex"],
        ],
        [
            "info" => "Login a user.",
            "requestMethod" => "get|post",
            "path" => "login",
            "callable" => ["userController", "getPostLogin"],
        ],
        [
            "info" => "Create a user.",
            "requestMethod" => "get|post",
            "path" => "create",
            "callable" => ["userController", "getPostCreateUser"],
        ],
        [
            "info" => "Logout",
            "requestMethod" => null,
            "path" => "logout",
            "callable" => ["userController", "logout"],
        ],
        [
            "info" => "Change email",
            "requestMethod" => "get|post",
            "path" => "email",
            "callable" => ["userController", "getPostChangeEmail"],
        ],
    ]
];
