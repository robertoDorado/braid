<?php

ob_start();

require __DIR__ . '/vendor/autoload.php';

use Source\Core\MyRouter;

date_default_timezone_set("America/Sao_Paulo");

$path = "./Logs/error.log";

if (!file_exists($path)) {
    mkdir("Logs");
    file_put_contents($path, '');
}

error_reporting(E_ALL & (~E_NOTICE | ~E_USER_NOTICE));
ini_set('error_log', $path);
ini_set('log_errors', true);

$route = new MyRouter(url(), ":");

/**
 * Home
 */
$module = null;
$route->namespace("Source\Controllers");
$route->group($module);
$route->get("/", "Home:index");
$route->get("/email-confirmed", "Home:emailConfirmed");

/**
 * Login
 */
$module = "user";
$route->namespace("Source\Controllers");
$route->group($module);
$route->get("/login", "User:login");
$route->get("/register", "User:register");
$route->post("/register", "User:register");
$route->get("/confirm-email", "User:confirmEmail");

/**
 * Cookies
 */
$module = "cookies";
$route->namespace("Source\Controllers");
$route->group($module);
$route->post("/set-cookie", "Cookie:agree");
$route->get("/privacy-policy", "Cookie:privacyPolicy");

/**
 * Error
 */
$module = "ops";
$route->namespace("Source\Controllers");
$route->group($module);
$route->get("/error/{error_code}", "Home:error");


/**
 * Route
 */
$route->dispatch();

$route->error();

ob_end_flush();