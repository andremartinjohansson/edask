<?php

namespace Anax\Admin\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Anax\User\User;

/**
 * Form to create an item.
 */
class CreateForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $di)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Add user",
            ],
            [
                "acronym" => [
                    "type"        => "text",
                    "placeholder" => "Username",
                    "validation" => ["not_empty"],
                ],

                "email" => [
                    "type"        => "email",
                    "placeholder" => "Email",
                    "validation" => ["not_empty"],
                ],

                "password" => [
                    "type"        => "password",
                    "placeholder" => "Password",
                    "validation" => ["not_empty"],

                ],

                "password-again" => [
                    "type"        => "password",
                    "placeholder" => "Repeat Password",
                    "validation" => [
                        "match" => "password"
                    ],
                ],

                // "role" => [
                //     "type"        => "select",
                //     "label"       => "Select user role:",
                //     "options"     => ["user", "admin"],
                // ],

                "role" => [
                    "type"        => "text",
                    "placeholder" => "user/admin",
                    "validation" => ["not_empty"],
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Create user",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        // Get values from the submitted form
        $acronym       = $this->form->value("acronym");
        $password      = $this->form->value("password");
        $passwordAgain = $this->form->value("password-again");
        $email         = $this->form->value("email");
        $role          = $this->form->value("role");

        // Check password matches
        if ($password !== $passwordAgain) {
            $this->form->rememberValues();
            $this->form->addOutput("Password did not match.");
            return false;
        }

        // Save to database
        // $db = $this->di->get("db");
        // $password = password_hash($password, PASSWORD_DEFAULT);
        // $db->connect()
        //    ->insert("User", ["acronym", "password"])
        //    ->execute([$acronym, $password]);
        $user = new User();
        $user->setDb($this->di->get("db"));
        $user->acronym = $acronym;
        $user->setPassword($password);
        $user->email = $email;
        $user->role = $role;
        var_dump($role);
        $user->save();

        $this->form->addOutput("User was created.");
        return true;
    }
}
