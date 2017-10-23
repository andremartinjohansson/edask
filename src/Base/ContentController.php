<?php

namespace Anax\Base;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

/**
 * A default page rendering class.
 */
class ContentController implements InjectionAwareInterface
{
    use InjectionAwareTrait;

    public function renderIndex()
    {
        $this->di->get("view")->add("index");
        $this->di->get("pageRender")->renderPage([
            "title" => "Elite Ask"
        ]);
    }

    public function renderRoster()
    {
        $this->di->get("view")->add("roster");
        $this->di->get("pageRender")->renderPage([
            "title" => "Elite Ask | Roster"
        ]);
    }

    public function renderTags()
    {
        $this->di->get("view")->add("tags");
        $this->di->get("pageRender")->renderPage([
            "title" => "Elite Ask | Tags"
        ]);
    }

    public function renderAbout()
    {
        $this->di->get("view")->add("about");
        $this->di->get("pageRender")->renderPage([
            "title" => "Elite Ask | About"
        ]);
    }

    public function renderMain()
    {
        $this->di->get("view")->add("comments/comments");
        $this->di->get("pageRender")->renderPage([
            "title" => "Elite Ask | Ask Away!"
        ]);
    }

    public function renderEdit()
    {
        $this->di->get("view")->add("comments/edit_comment");
        $this->di->get("pageRender")->renderPage([
            "title" => "Elite Ask | Edit Question"
        ]);
    }

    public function renderComment()
    {
        $this->di->get("view")->add("comments/comment");
        $this->di->get("pageRender")->renderPage([
            "title" => "Elite Ask | View Question"
        ]);
    }

    public function renderUser()
    {
        $this->di->get("view")->add("comments/user");
        $this->di->get("pageRender")->renderPage([
            "title" => "Elite Ask | View Member"
        ]);
    }

    public function renderTag()
    {
        $this->di->get("view")->add("comments/tag");
        $this->di->get("pageRender")->renderPage([
            "title" => "Elite Ask | View Tag"
        ]);
    }

    public function renderReply()
    {
        $this->di->get("view")->add("comments/reply");
        $this->di->get("pageRender")->renderPage([
            "title" => "Elite Ask | Reply"
        ]);
    }
}
