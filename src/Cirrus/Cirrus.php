<?php

  namespace Cirrus;

  class Cirrus
  {
    /** @var string */
    protected $_clientId;

    /** @var string */
    protected $_serviceUrl = 'http://api.soundcloud.com';

    /** @var string */
    protected $_clientIdUrlPattern = '?client_id={{clientId}}';

    /** @var array */
    protected $_imageSizes = array(
      'original' => 'original',
      '500'      => 't500x500',
      '400'      => 'crop',
      '300'      => 't300x300',
      '100'      => 'large',
      '67'       => 't67x67',
      '47'       => 'badge',
      '32'       => 'small',
      '20'       => 'tiny_artworks',
      '18'       => 'tiny_avatars',
      '16'       => 'mini',
    );

    // ##########################################

    /**
     * @param $key
     * @return bool|string
     */
    protected function _getVarByKey($key)
    {
      if(! isset($this->$key))
      {
        return FALSE;
      }

      return $this->$key;
    }

    // ##########################################

    /**
     * @return bool|string
     */
    protected function _getServiceUrl()
    {
      return $this->_getVarByKey('_serviceUrl');
    }

    // ##########################################

    /**
     * @param $clientId
     * @return Cirrus
     */
    public function setClientId($clientId)
    {
      $this->_clientId = $clientId;

      return $this;
    }

    // ##########################################

    /**
     * @return bool|string
     */
    protected function _getClientId()
    {
      return $this->_getVarByKey('_clientId');
    }

    // ##########################################

    /**
     * @return string
     */
    protected function _getClientIdUrlPattern()
    {
      $data = array(
        'clientId' => $this->_getClientId(),
      );

      return $this->_parseUrlPattern($this->_clientIdUrlPattern, $data);
    }

    // ##########################################

    /**
     * @param $pattern
     * @param $values
     * @return string
     */
    protected function _parseUrlPattern($pattern, $values)
    {
      foreach($values as $key => $val)
      {
        $pattern = str_replace('{{' . $key . '}}', $val, $pattern);
      }

      return $pattern;
    }

    // ##########################################

    /**
     * @param $url
     * @return array
     */
    protected function _fetchRemoteData($url)
    {
      $jsonResponse = \CURL::init($url)
        ->setReturnTransfer(TRUE)
        ->execute();

      return json_decode($jsonResponse, TRUE);
    }

    // ##########################################

    /**
     * @param array $data
     * @param AbstractVo $voClass
     * @return AbstractVo
     */
    protected function _getDataVo(array $data, AbstractVo $voClass)
    {
      return $voClass->setData($data);
    }

    // ##########################################

    /**
     * @param $imageUrl
     * @param $size
     * @return mixed
     */
    public function getImageUrlBySize($imageUrl, $size)
    {
      return str_replace('large', $size, $imageUrl);
    }
  }
