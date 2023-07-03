<?php
require_once "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__) . "/html");
$twig = new \Twig\Environment($loader, []);

$page=$_REQUEST['page'];
if(empty($page))
{
    $page = 'home';
}

return $twig->display("html/pages/$page.twig");