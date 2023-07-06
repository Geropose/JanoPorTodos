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

$newsAndEventsManager = new JanoNewsAndEvents();

$newsAndEventsManager->addEvent(
    '644258887744689', JanoNewsAndEvents::FilterTandil
);
$newsAndEventsManager->addEvent(
    '632335558937022', JanoNewsAndEvents::FilterTandil
);
$newsAndEventsManager->addEvent(
    '2564870846986434', JanoNewsAndEvents::FilterTandil
);
$newsAndEventsManager->addEvent(
    '627728559397722',
    JanoNewsAndEvents::FilterJuarez
);

$newsAndEventsManager->addLatestNews(
    '648217694015475'
);
$newsAndEventsManager->addLatestNews(
    '648664413970803'
);

$twig->addGlobal('latestNews', $newsAndEventsManager->getLatestNews());
$twig->addGlobal('events', $newsAndEventsManager->getEvents());

return $twig->display("pages/$page.twig");