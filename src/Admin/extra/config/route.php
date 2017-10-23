<?php
/**
 * Configuration file for routes.
 */
return [
    // Load these routefiles in order specified and optionally mount them
    // onto a base route.
    "routeFiles" => [
        [
            // Add routes from adminController and mount on admin/
            "mount" => "admin",
            "file" => __DIR__ . "/route/adminController.php",
        ],
    ],

];
