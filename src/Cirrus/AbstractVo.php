<?php

  namespace Cirrus;

  class AbstractVo
  {
    /** @var array */
    protected $_data = array();

    // ##########################################

    /**
     * @param $key
     * @param $value
     * @return AbstractVo
     */
    protected function _setByKey($key, $value)
    {
      $this->_data[$key] = $value;

      return $this;
    }

    // ##########################################

    /**
     * @param $key
     * @return bool
     */
    protected function _getByKey($key)
    {
      if(! isset($this->_data[$key]))
      {
        return FALSE;
      }

      return $this->_data[$key];
    }

    // ##########################################

    public function setData(array $data)
    {
      $this->_data = $data;

      return $this;
    }

    // ##########################################

    /**
     * @return array
     */
    public function getData()
    {
      return $this->_data;
    }
  }
