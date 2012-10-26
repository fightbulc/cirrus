<?php

  namespace Cirrus\Playlists;

  class PlaylistsCirrus extends \Cirrus\Cirrus
  {
    /** @var string */
    protected $_playlistUrlPattern = '{{serviceUrl}}/playlists/{{playlistId}}.json{{clientIdUrlPattern}}';

    /** @var integer */
    protected $_playlistId;

    /** @var bool */
    protected $_fetchCompleteUserData = FALSE;

    // ##########################################

    /**
     * @return PlaylistsCirrus
     */
    public static function init()
    {
      return new PlaylistsCirrus();
    }

    // ##########################################

    /**
     * @return string
     */
    protected function _getPlaylistUrlPattern()
    {
      return $this->_playlistUrlPattern;
    }

    // ##########################################

    /**
     * @param $clientId
     * @return \Cirrus\Cirrus|PlaylistsCirrus
     */
    public function setClientId($clientId)
    {
      parent::setClientId($clientId);

      return $this;
    }

    // ##########################################

    /**
     * @param $playlistId
     * @return PlaylistsCirrus
     */
    public function setId($playlistId)
    {
      $this->_playlistId = $playlistId;

      return $this;
    }

    // ##########################################

    /**
     * @return int
     */
    protected function _getId()
    {
      return $this->_playlistId;
    }

    // ##########################################

    /**
     * @param bool $use
     * @return PlaylistsCirrus
     */
    public function withCompleteUserData($use = FALSE)
    {
      $this->_fetchCompleteUserData = $use;

      return $this;
    }

    // ##########################################

    /**
     * @return bool
     */
    protected function _getWithCompleteUserData()
    {
      return $this->_fetchCompleteUserData;
    }

    // ##########################################

    /**
     * @return array
     */
    protected function _getFetchData()
    {
      return array(
        'serviceUrl'         => $this->_getServiceUrl(),
        'playlistId'         => $this->_getId(),
        'clientIdUrlPattern' => $this->_getClientIdUrlPattern(),
      );
    }

    // ##########################################

    /**
     * @return PlaylistVo
     */
    public function fetchData()
    {
      $url = $this->_parseUrlPattern($this->_getPlaylistUrlPattern(), $this->_getFetchData());

      // array from response
      $playlistData = $this->_fetchRemoteData($url);

      /** @var $vo PlaylistVo */
      $vo = $this->_getDataVo($playlistData, new PlaylistVo());

      // get user data
      if($this->_getWithCompleteUserData() !== FALSE)
      {
        $userId = $vo->getUserId();
        $vo->setCompleteUserVo($this->_fetchCompleteUserData($userId));
      }

      return $vo;
    }

    // ##########################################

    /**
     * @param $userId
     * @return \Cirrus\Users\UserVo
     */
    protected function _fetchCompleteUserData($userId)
    {
      return \Cirrus\Users\UsersCirrus::init()
        ->setClientId($this->_getClientId())
        ->setId($userId)
        ->fetchData();
    }
  }