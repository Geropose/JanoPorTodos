<?php

use Jano\JanoNewsAndEvents;

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