<?php

    require __DIR__ . '/../vendor/autoload.php';
    require 'config.php';

    // ############################################

    $clientId = $config['clientId'];
    $userId = 995847;

    $userVo = \Cirrus\Users\UsersCirrus::init()
        ->setClientId($clientId)
        ->setId($userId)
        ->withTracksData(TRUE)
        ->withWebProfilesData(TRUE)
        ->fetchData();

    // ############################################

//    var_dump($userVo);
    /** @var \Cirrus\Tracks\TrackVo[] $trackVoMany */
    var_dump($userVo->getTrackGenresUnique());

