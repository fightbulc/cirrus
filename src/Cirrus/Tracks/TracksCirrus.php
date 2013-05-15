<?php

    namespace Cirrus\Tracks;

    use Cirrus\Cirrus;
    use Cirrus\Users\UsersCirrus;

    class TracksCirrus extends Cirrus
    {
        /** @var string */
        protected $_trackUrlPattern = '{{serviceUrl}}/tracks/{{trackId}}.json{{clientIdUrlPattern}}';

        /** @var string */
        protected $_trackWithSecretUrlPattern = '{{serviceUrl}}/tracks/{{trackId}}.json{{clientIdUrlPattern}}&secret_token={{trackSecret}}';

        /** @var integer */
        protected $_trackId;

        /** @var array */
        protected $_trackMultipleIds = [];

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
         * @param $fetchData
         *
         * @return string
         */
        protected function _getTrackUrlPattern($fetchData)
        {
            if (isset($fetchData['trackSecret']))
            {
                return $this->_trackWithSecretUrlPattern;
            }

            return $this->_trackUrlPattern;
        }

        // ##########################################

        /**
         * @param $clientId
         *
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
         *
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
         * @param array $trackIds
         *
         * @return TracksCirrus
         */
        public function setMultipleIds(array $trackIds)
        {
            $this->_trackMultipleIds = $trackIds;

            // reset single id
            $this->setId(NULL);

            return $this;
        }

        // ##########################################

        /**
         * @return array
         */
        protected function _getMultipleIds()
        {
            return $this->_trackMultipleIds;
        }

        // ##########################################

        /**
         * @param bool $use
         *
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
         * @param $trackId
         *
         * @return array
         */
        protected function _getFetchData($trackId)
        {
            // set default fields
            $urlParams = array(
                'serviceUrl'         => $this->_getServiceUrl(),
                'trackId'            => $trackId,
                'clientIdUrlPattern' => $this->_getClientIdUrlPattern(),
            );

            // parse for secret token; pattern = trackId:secretToken
            if (strpos($trackId, ':') !== FALSE)
            {
                $parts = explode(':', $trackId);
                $urlParams['trackId'] = $parts[0];
                $urlParams['trackSecret'] = $parts[1];
            }

            return $urlParams;
        }

        // ##########################################

        /**
         * @param $trackUrlPattern
         * @param $fetchData
         *
         * @return TrackVo
         */
        protected function _fetchData($trackUrlPattern, $fetchData)
        {
            $url = $this->_parseUrlPattern($trackUrlPattern, $fetchData);

            // array from response
            $trackData = $this->_fetchRemoteData($url);

            // handle error
            if ($trackData === FALSE)
            {
                return FALSE;
            }

            // add client id to VO for playable stream url
            $trackData['_client_id'] = $this->_getClientId();

            /** @var $vo TrackVo */
            $vo = $this->_getDataVo($trackData, new TrackVo());

            // get user data
            if ($this->_getWithCompleteUserData() !== FALSE)
            {
                $userId = $vo->getUserId();
                $userData = $this->_fetchCompleteUserData($userId);

                if ($userData !== FALSE)
                {
                    $vo->setCompleteUserVo($userData);
                }
            }

            return $vo;
        }

        // ##########################################

        /**
         * @return array
         */
        protected function _fetchMultipleData()
        {
            $voMany = array();
            $trackIds = $this->_getMultipleIds();

            // make sure that we got some id's
            if (empty($trackIds))
            {
                return FALSE;
            }

            foreach ($trackIds as $trackId)
            {
                $fetchData = $this->_getFetchData($trackId);
                $urlPattern = $this->_getTrackUrlPattern($fetchData);
                $voMany[] = $this->_fetchData($urlPattern, $fetchData);
            }

            return $voMany;
        }

        // ##########################################

        /**
         * @return TrackVo
         */
        public function fetchData()
        {
            // multiple track fetch
            if (is_null($this->_getId()))
            {
                return $this->_fetchMultipleData();
            }

            // single track fetch
            $fetchData = $this->_getFetchData($this->_getId());
            $urlPattern = $this->_getTrackUrlPattern($fetchData);

            return $this->_fetchData($urlPattern, $fetchData);
        }

        // ##########################################

        /**
         * @param $userId
         *
         * @return \Cirrus\Users\UserVo
         */
        protected function _fetchCompleteUserData($userId)
        {
            return UsersCirrus::init()
                ->setClientId($this->_getClientId())
                ->setId($userId)
                ->fetchData();
        }
    }