<?php

use Jano\JanoNewsAndEvents;

require_once "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . "/html");
$twig = new \Twig\Environment($loader, []);

$page = $_REQUEST['page'];
if (empty($page)) {
    $page = 'home';
}

/** @var JanoNewsAndEvents $newsAndEventsManager */
include __DIR__ . "/news-events.php";

$twig->addGlobal('latestNews', $newsAndEventsManager->getLatestNews());
$twig->addGlobal('events', $newsAndEventsManager->getEvents());

$twig->display("pages/$page.twig");