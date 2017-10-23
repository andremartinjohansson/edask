<?php
/**
 * Configuration file for DI container.
 */
return [

    // Services to add to the container.
    "services" => [
        "adminController" => [
            "shared" => true,
            "callback" => function () {
                $obj = new \Anax\Admin\AdminController();
                $obj->setDI($this);
                return $obj;
            }
        ],
    ],
];
