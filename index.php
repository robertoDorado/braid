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
$route->post("/token", "User:token");

/**
 * Admin
 */
$module = "braid-system";
$route->namespace("Source\Controllers");
$route->group($module);
$route->get("/", "Admin:perfil");
$route->post("/", "Admin:perfil");
$route->get("/client-report", "Admin:clientReport");
$route->get("/client-report-form", "Admin:clientReportForm");
$route->post("/client-report-form", "Admin:clientReportForm");
$route->post("/exit", "Admin:exit");
$route->get("/charge-on-demand/{hash}", "Admin:chargeOnDemand");
$route->get("/charge-on-demand-candidates/{hash}", "Admin:chargeOnDemandCandidates");
$route->get("/charge-on-demand-evaluation/{hash}", "Admin:chargeOnDemandEvaluation");
$route->get("/token", "Admin:getLoginTokenData");
$route->get("/search-project", "Admin:searchProject");
$route->get("/edit-project/{hash}", "Admin:editProject");
$route->post("/edit-project", "Admin:editProject");
$route->post("/delete-project", "Admin:deleteProject");
$route->get("/project-detail/{hash}", "Admin:projectDetail");
$route->post("/project-detail", "Admin:projectDetail");
$route->get("/profile-data/{hash}", "Admin:profileData");
$route->post("/profile-data", "Admin:profileData");
$route->get("/my-profile", "Admin:myProfile");
$route->get("/additional-data", "Admin:additionalData");
$route->post("/additional-data", "Admin:additionalData");
$route->get("/company-profile/{hash}", "Admin:companyProfile");
$route->post("/save-breadcrumb-link", "Admin:saveBreadCrumbLink");
$route->get("/chat-panel", "Admin:chatPanel");
$route->post("/chat-panel", "Admin:chatPanel");
$route->get("/chat-panel-user", "Admin:chatPanelUser");
$route->post("/chat-panel-user", "Admin:chatPanelUser");
$route->post("/chat-messages/{hash}", "Admin:chatMessages");
$route->get("/profile-data-json/{hash}", "Admin:profileDataJson");

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