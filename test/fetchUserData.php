<?php

    require __DIR__ . '/../vendor/autoload.php';
    require 'config.php';

    // ############################################

    $clientId = $config['clientId'];
    $userId = 428623;

    $userVo = \Cirrus\Users\UsersCirrus::init()
        ->setClientId($clientId)
        ->setId($userId)
        ->withTracksData(TRUE)
        ->withPlaylistsData(TRUE)
        ->withFollowersData(TRUE)
        ->withFollowingsData(TRUE)
        ->withFavoritesData(TRUE)
        ->fetchData();

    // ############################################

    var_dump($userVo);