<?php

    require __DIR__ . '/../vendor/autoload.php';
    require 'config.php';

    // ############################################

    $clientId = $config['clientId'];
    $playlistId = 1681980;

    $playlistVo = \Cirrus\Playlists\PlaylistsCirrus::init()
        ->setClientId($clientId)
        ->setId($playlistId)
        ->withCompleteUserData(TRUE)
        ->fetchData();

    // ############################################

    var_dump($playlistVo);