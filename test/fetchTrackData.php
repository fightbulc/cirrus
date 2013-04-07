<?php

    require __DIR__ . '/../vendor/autoload.php';
    require 'config.php';

    // ############################################

    $clientId = $config['clientId'];
    $trackId = 64321366;

    $trackVo = \Cirrus\Tracks\TracksCirrus::init()
        ->setClientId($clientId)
        ->setId($trackId)
        ->withCompleteUserData(TRUE)
        ->fetchData();

    // ############################################

    var_dump($trackVo);