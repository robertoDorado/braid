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

$realPath = __DIR__ . "/themes/braid-theme/assets/img/user";

if (!file_exists($realPath)) {
    if (!mkdir($realPath, 0777, true)) {
        throw new \Exception("Erro ao criar a pasta de upload");
    }
}

$route = new MyRouter(url(), ":");

/**
 * Site
 */
$module = null;
$route->namespace("Source\Controllers");
$route->group($module);
$route->get("/", "Home:index");

/**
 * User
 */
$module = "user";
$route->namespace("Source\Controllers");
$route->group($module);
$route->get("/login", "User:login");
$route->post("/login", "User:login");
$route->get("/register", "User:register");
$route->post("/register", "User:register");
$route->get("/confirm-email", "User:confirmEmail");
$route->get("/email-confirmed", "User:emailConfirmed");
$route->get("/recover-password", "User:recoverPassword");
$route->post("/recover-password", "User:recoverPassword");
$route->get("/recover-password-message", "User:recoverPasswordMessage");
$route->get("/recover-password-form", "User:recoverPasswordForm");
$route->post("/recover-password-form", "User:recoverPasswordForm");
$route->get("/expired-link-recover-password", "User:expiredLinkRecoverPassword");
$route->get("/success-change-password", "User:successChangePassword");

/**
 * Admin
 */
$module = "braid-system";
$route->namespace("Source\Controllers");
$route->group($module);
$route->get("/", "Admin:index");
$route->post("/exit", "Admin:exit");


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