<?php

namespace Anax\User\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Anax\User\User;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

/**
 * Example of FormModel implementation.
 */
class UserLoginForm extends FormModel implements InjectionAwareInterface
{

    use InjectionAwareTrait;

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
                "class" => "standard-form",
                "legend" => "Login",
            ],
            [
                "user" => [
                    "type"        => "text",
                    "placeholder" => "Username",
                    "validation" => ["not_empty"],
                    "label" => "",
                    "class" => "standard-input",
                    //"description" => "Here you can place a description.",
                    //"placeholder" => "Here is a placeholder",
                ],

                "password" => [
                    "type"        => "password",
                    "placeholder" => "Password",
                    "validation" => ["not_empty"],
                    "label" => "",
                    "class" => "standard-input",
                    //"description" => "Here you can place a description.",
                    //"placeholder" => "Here is a placeholder",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Log in",
                    "callback" => [$this, "callbackSubmit"],
                    "class" => "standard-button",
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
        $acronym       = $this->form->value("user");
        $password      = $this->form->value("password");

        // Try to login
        // $db = $this->di->get("db");
        // $db->connect();
        // $user = $db->select("password")
        //            ->from("User")
        //            ->where("acronym = ?")
        //            ->executeFetch([$acronym]);

        // $user is false if user is not found
        // if (!$user || !password_verify($password, $user->password)) {
        //    $this->form->rememberValues();
        //    $this->form->addOutput("User or password did not match.");
        //    return false;
        // }

        $user = new User();
        $user->setDb($this->di->get("db"));
        $res = $user->verifyPassword($acronym, $password);

        if (!$res) {
            $this->form->rememberValues();
            $this->form->addOutput("User or password did not match.");
            return false;
        }

        $loggedIn = ["id" => $user->id, "name" => $user->acronym, "email" => $user->email, "role" => $user->role];

        $this->di->get("session")->set("user", $loggedIn);

        $this->form->addOutput("User " . $user->acronym . " logged in.");
        $this->di->get("response")->redirect("user");
        return true;
    }
}
