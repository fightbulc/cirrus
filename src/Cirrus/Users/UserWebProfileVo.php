<?php

    namespace Cirrus\Users;

    class UserWebProfileVo
    {
        protected $_id;
        protected $_service;
        protected $_title;
        protected $_url;
        protected $_username;

        // ######################################

        public function __construct(array $data)
        {
            $this->_id = $data['id'];
            $this->_service = $data['service'];
            $this->_title = $data['title'];
            $this->_url = $data['url'];
            $this->_username = $data['username'];
        }

        // ######################################

        /**
         * @return mixed
         */
        public function getId()
        {
            return $this->_id;
        }

        // ######################################

        /**
         * @return mixed
         */
        public function getService()
        {
            return $this->_service;
        }

        // ######################################

        /**
         * @return mixed
         */
        public function getTitle()
        {
            return $this->_title;
        }

        // ######################################

        /**
         * @return mixed
         */
        public function getUrl()
        {
            return $this->_url;
        }

        // ######################################

        /**
         * @return mixed
         */
        public function getUsername()
        {
            return $this->_username;
        }
    }