<?php

  namespace Cirrus\Tracks;

  class TracksCirrus extends \Cirrus\Cirrus
  {
    /** @var string */
    protected $_trackUrlPattern = '{{serviceUrl}}/tracks/{{trackId}}.json{{clientIdUrlPattern}}';

    /** @var integer */
    protected $_trackId;

    /** @var bool */
    protected $_fetchCompleteUserData = FALSE;

    // ##########################################

    /**
     * @return TracksCirrus
     */
    public static function init()
    {
      return new TracksCirrus();
    }

    // ##########################################

    /**
     * @return string
     */
    protected function _getTrackUrlPattern()
    {
      return $this->_trackUrlPattern;
    }

    // ##########################################

    /**
     * @param $clientId
     * @return \Cirrus\Cirrus|TracksCirrus
     */
    public function setClientId($clientId)
    {
      parent::setClientId($clientId);

      return $this;
    }

    // ##########################################

    /**
     * @param $trackId
     * @return TracksCirrus
     */
    public function setId($trackId)
    {
      $this->_trackId = $trackId;

      return $this;
    }

    // ##########################################

    /**
     * @return int
     */
    protected function _getId()
    {
      return $this->_trackId;
    }

    // ##########################################

    /**
     * @param bool $use
     * @return TracksCirrus
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
        'trackId'            => $this->_getId(),
        'clientIdUrlPattern' => $this->_getClientIdUrlPattern(),
      );
    }

    // ##########################################

    /**
     * @return TrackVo
     */
    public function fetchData()
    {
      $url = $this->_parseUrlPattern($this->_getTrackUrlPattern(), $this->_getFetchData());

      // array from response
      $trackData = $this->_fetchRemoteData($url);

      /** @var $vo TrackVo */
      $vo = $this->_getDataVo($trackData, new TrackVo());

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