<?php


namespace App\Helper\View;


use App\Helper\Renderable;
use Module\JWT\JWT;

class Notice extends Renderable
{
    public static function create($color, $content = "", $css = [], $permission = null, $icon = null, $routes = null, $priority = 0, $closable = true)
    {
        return prop("notices")->add(compact("color", "content", "routes", "permission", "icon", "priority", "css", "closable"));
    }

    public function render($object): ?string
    {
        return view("components.notice", compact("object"),false);
    }

    public function prioritySort(): Renderable
    {
        return $this->sortBy("priority");
    }

    public function can($object): bool
    {
        return JWT::getUser()->can($object["permission"]);
    }
}