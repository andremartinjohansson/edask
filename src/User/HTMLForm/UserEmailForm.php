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
class UserEmailForm extends FormModel implements InjectionAwareInterface
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
                "legend" => "Change email"
            ],
            [
                "new-email" => [
                    "type"        => "email",
                    "placeholder" => "New Email",
                    "validation" => ["not_empty"],
                    "label" => "",
                    "class" => "standard-input",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Save",
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
        $email = $this->form->value("new-email");

        $user = new User();
        $user->setDb($this->di->get("db"));
        $old = $user->find("id", $this->di->get("session")->get("user")["id"]);
        $user->id = $old->id;
        $user->email = $email;
        $user->acronym = $old->acronym;
        $user->password = $old->password;
        $user->save();

        $_SESSION["user"]["email"] = $email;

        $this->form->addOutput("Email changed");
        return true;
    }
}
