<?php

use App\Helper\{Validator,View\Menu};
use Core\{App, Hook, Translation, View, Cache, Container};
use Illuminate\Support\Collection;

/**
 * Get Engine Main Class Instance
 * @param $param
 * @return App|mixed
 */
function app($param = null)
{
    return $param ? container($param) : App::instance();
}

/**
 * Get project url
 * @param string|null $uri Uri Slug
 * @param array $extra
 * @return string
 */
function url(string $uri = null, array $extra = [])
{
    return App::url($uri, $extra);
}

/**
 * Get project configs
 * @param $name string Config file name
 * @return array
 */
function config(string $name): array
{
    return require BASEDIR . "/config/" . $name . ".php";
}

/**
 * Blade helper function
 * @param $view
 * @param array $data
 * @param bool $user Bind JWT User To View
 * @return Exception|string
 */
function view($view, $data = [],$user =true)
{
    return View::instance()->make($view, $data,$user);
}

/**
 * I18N helper
 * @param $key
 * @param null $default
 * @param null $locale
 * @return array|mixed|string|null
 */
function __($key, $default = null, $locale = null)
{
    return Translation::instance()->translate($key, $locale, $default);
}

/**
 * Redirect to new url
 * @param $url
 * @return bool|void
 */
function redirect($url = null)
{
    $url = strtolower(substr($url, 0, 4)) != "http" ? App::url($url) : $url;
    header("Location: {$url}");
    exit;
    return true;
}

/**
 * Validate Http Requests
 * @param $data
 * @param $rules
 * @param bool $exit
 * @param array $messages
 * @param array $attributes
 * @return bool|\Illuminate\Validation\Validator|void
 */
function validate($data, $rules, $exit = true, $messages = [], $attributes = [])
{
    return Validator::make($data, $rules, $exit, $messages, $attributes);
}

/**
 * Migrate database tables
 * @param $migration string Migration file name
 * @param $moduleDir string Module Dirname
 */
function migrate(string $migration, string $moduleDir)
{
    require_once $moduleDir . "/Database/Migration/" . $migration . ".php";
}

/**
 * Run Hook After Load All Modules
 * @param $hook
 * @param mixed ...$args
 */
function hook($hook, ...$args)
{
    Hook::runAfterHook($hook, ...$args);
}

/**
 * @param $slug
 * @param $title
 * @param $url
 * @param string $parent
 * @param null $permission
 * @param null $icon
 * Add Item To Dashboard Sidebar
 * @param int $priority
 */
function menu($slug, $title, $url, $parent = "", $permission = null, $icon = null, $priority = 0)
{
    Menu::add($slug, $title, $url, $parent, $permission, $icon, $priority);
}

/**
 * Get Route Url with Name
 * @param $name
 * @param array $parameters
 * @param false $absolute
 * @return string
 */
function route($name, $parameters = [], $absolute = false)
{
    return url("") . App::instance()->url->route($name, $parameters, $absolute);
}

/**
 * Get Redis Instance
 * @return Cache
 */
function cache(): Cache
{
    return Cache::instance();
}

/**
 * Create Illuminate Collection
 * @param array $items
 * @return Collection
 */
function collection($items = []): Collection
{
    return new Collection($items);
}

/**
 * Get View Props
 * @param $prop
 * @param $default
 * @return mixed|null
 */
function prop($prop, $default = null)
{
    return View::getProp($prop, $default);
}

/**
 * Abort Application
 * @param $message
 * @param $code
 * @return mixed|null
 */
function abort($message = null, $code = null)
{
    http_response_code($code);
    die($message);
}

/**
 * Get or Set Container
 * @param $param
 * @param null $value
 * @return bool|mixed
 */
function container($param, $value = null)
{
    return $value ? Container::add($param, $value) : Container::get($param);
}