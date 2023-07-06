<?php
require_once "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . "/html");
$twig = new \Twig\Environment($loader, []);

$page = $_REQUEST['page'];
if (empty($page)) {
    $page = 'home';
}

/*
    events object should have the facebook postId as key and type class(es) as value
    types for filter: 'tandil', 'juarez', 'next'
*/
$events = [
    '644258887744689' => 'tandil',
    '632335558937022' => 'tandil',
    '2564870846986434' => 'tandil',
    '627728559397722' => 'juarez'
];


$twig->addGlobal('latestNews', ['648217694015475', '648664413970803']);

$twig->addGlobal('events',$events);

return $twig->display("pages/$page.twig");