<?php

    namespace Cirrus\Users;

    use Cirrus\Cirrus;
    use Cirrus\Tracks\TrackVo;

    class UsersCirrus extends Cirrus
    {
        /** @var string */
        protected $_userUrlPattern = '{{serviceUrl}}/users/{{userId}}.json{{clientIdUrlPattern}}';

        /** @var string */
        protected $_userTracksUrlPattern = '{{serviceUrl}}/users/{{userId}}/tracks.json{{clientIdUrlPattern}}';

        /** @var string */
        protected $_userPlaylistsUrlPattern = '{{serviceUrl}}/users/{{userId}}/playlists.json{{clientIdUrlPattern}}';

        /** @var string */
        protected $_userFollowersUrlPattern = '{{serviceUrl}}/users/{{userId}}/followers.json{{clientIdUrlPattern}}';

        /** @var string */
        protected $_userFollowingsUrlPattern = '{{serviceUrl}}/users/{{userId}}/followings.json{{clientIdUrlPattern}}';

        /** @var string */
        protected $_userFavoritesUrlPattern = '{{serviceUrl}}/users/{{userId}}/favorites.json{{clientIdUrlPattern}}';

        /** @var integer */
        protected $_userId;

        /** @var bool */
        protected $_fetchTracksData = FALSE;

        /** @var bool */
        protected $_fetchPlaylistsData = FALSE;

        /** @var bool */
        protected $_fetchFollowersData = FALSE;

        /** @var bool */
        protected $_fetchFollowingsData = FALSE;

        /** @var bool */
        protected $_fetchFavoritesData = FALSE;

        // ##########################################

        /**
         * @return UsersCirrus
         */
        public static function init()
        {
            return new UsersCirrus();
        }

        // ##########################################

        /**
         * @param $clientId
         *
         * @return \Cirrus\Cirrus|UsersCirrus
         */
        public function setClientId($clientId)
        {
            parent::setClientId($clientId);

            return $this;
        }

        // ##########################################

        /**
         * @return string
         */
        protected function _getUserUrlPattern()
        {
            return $this->_userUrlPattern;
        }

        // ##########################################

        /**
         * @return string
         */
        protected function _getUserTracksUrlPattern()
        {
            return $this->_userTracksUrlPattern;
        }

        // ##########################################

        /**
         * @return string
         */
        protected function _getUserPlaylistsUrlPattern()
        {
            return $this->_userPlaylistsUrlPattern;
        }

        // ##########################################

        /**
         * @return string
         */
        protected function _getUserFollowersUrlPattern()
        {
            return $this->_userFollowersUrlPattern;
        }

        // ##########################################

        /**
         * @return string
         */
        protected function _getUserFollowingsUrlPattern()
        {
            return $this->_userFollowingsUrlPattern;
        }

        // ##########################################

        /**
         * @return string
         */
        protected function _getUserFavoritesUrlPattern()
        {
            return $this->_userFavoritesUrlPattern;
        }

        // ##########################################

        /**
         * @param $userId
         *
         * @return UsersCirrus
         */
        public function setId($userId)
        {
            $this->_userId = $userId;

            return $this;
        }

        // ##########################################

        /**
         * @return int
         */
        protected function _getId()
        {
            return $this->_userId;
        }

        // ##########################################

        /**
         * @param bool $use
         *
         * @return UsersCirrus
         */
        public function withTracksData($use = FALSE)
        {
            $this->_fetchTracksData = $use;

            return $this;
        }

        // ##########################################

        /**
         * @return bool
         */
        protected function _getWithTracksData()
        {
            return $this->_fetchTracksData;
        }

        // ##########################################

        /**
         * @param bool $use
         *
         * @return UsersCirrus
         */
        public function withPlaylistsData($use = FALSE)
        {
            $this->_fetchPlaylistsData = $use;

            return $this;
        }

        // ##########################################

        /**
         * @return bool
         */
        protected function _getWithPlaylistsData()
        {
            return $this->_fetchPlaylistsData;
        }

        // ##########################################

        /**
         * @param bool $use
         *
         * @return UsersCirrus
         */
        public function withFollowersData($use = FALSE)
        {
            $this->_fetchFollowersData = $use;

            return $this;
        }

        // ##########################################

        /**
         * @return bool
         */
        protected function _getWithFollowersData()
        {
            return $this->_fetchFollowersData;
        }

        // ##########################################

        /**
         * @param bool $use
         *
         * @return UsersCirrus
         */
        public function withFollowingsData($use = FALSE)
        {
            $this->_fetchFollowingsData = $use;

            return $this;
        }

        // ##########################################

        /**
         * @return bool
         */
        protected function _getWithFollowingsData()
        {
            return $this->_fetchFollowingsData;
        }

        // ##########################################

        /**
         * @param bool $use
         *
         * @return UsersCirrus
         */
        public function withFavoritesData($use = FALSE)
        {
            $this->_fetchFavoritesData = $use;

            return $this;
        }

        // ##########################################

        /**
         * @return bool
         */
        protected function _getWithFavoritesData()
        {
            return $this->_fetchFavoritesData;
        }

        // ##########################################

        /**
         * @return array
         */
        protected function _getFetchData()
        {
            return array(
                'serviceUrl'         => $this->_getServiceUrl(),
                'userId'             => $this->_getId(),
                'clientIdUrlPattern' => $this->_getClientIdUrlPattern(),
            );
        }

        // ##########################################

        /**
         * @return UserVo
         */
        public function fetchData()
        {
            $url = $this->_parseUrlPattern($this->_getUserUrlPattern(), $this->_getFetchData());

            // array from response
            $userData = $this->_fetchRemoteData($url);

            // handle error
            if ($userData === FALSE)
            {
                return FALSE;
            }

            /** @var $vo UserVo */
            $vo = $this->_getDataVo($userData, new UserVo());

            // get tracks data
            if ($this->_getWithTracksData() !== FALSE)
            {
                $tracksData = $this->fetchTracksData();

                if ($tracksData !== FALSE)
                {
                    $vo->setTracksVo($tracksData);
                }
            }

            // get playlists data
            if ($this->_getWithPlaylistsData() !== FALSE)
            {
                $playlistsData = $this->fetchPlaylistsData();

                if ($playlistsData !== FALSE)
                {
                    $vo->setPlaylistsVo($playlistsData);
                }
            }

            // get followers data
            if ($this->_getWithFollowersData() !== FALSE)
            {
                $followersData = $this->fetchFollowersData();

                if ($followersData !== FALSE)
                {
                    $vo->setFollowersVo($followersData);
                }
            }

            // get followings data
            if ($this->_getWithFollowingsData() !== FALSE)
            {
                $followingsData = $this->fetchFollowingsData();

                if ($followingsData !== FALSE)
                {
                    $vo->setFollowingsVo($followingsData);
                }
            }

            // get favorites data
            if ($this->_getWithFavoritesData() !== FALSE)
            {
                $favoritesData = $this->fetchFavoritesData();

                if ($favoritesData !== FALSE)
                {
                    $vo->setFavoritesVo($favoritesData);
                }
            }

            return $vo;
        }

        // ##########################################

        /**
         * @param $tracksData
         *
         * @return array
         */
        protected function _parseTracksData($tracksData)
        {
            // vo collection
            $tracksVoMany = array();

            foreach ($tracksData as $data)
            {
                // remove dublicate content
                if (isset($data['user']))
                {
                    unset($data['user']);
                }

                // for playable track stream url
                $data['_client_id'] = $this->_getClientId();

                $vo = new TrackVo();
                $vo->setData($data);
                $tracksVoMany[] = $vo;
            }

            return $tracksVoMany;
        }

        // ##########################################

        /**
         * @param $usersData
         *
         * @return array
         */
        protected function _parseUsersData($usersData)
        {
            // vo collection
            $usersVoMany = array();

            foreach ($usersData as $data)
            {
                $vo = new UserVo();
                $vo->setData($data);
                $usersVoMany[] = $vo;
            }

            return $usersVoMany;
        }

        // ##########################################

        /**
         * @return array
         */
        public function fetchTracksData()
        {
            $url = $this->_parseUrlPattern($this->_getUserTracksUrlPattern(), $this->_getFetchData());

            // array from response
            $tracksData = $this->_fetchRemoteData($url);

            // handle error
            if ($tracksData === FALSE)
            {
                return FALSE;
            }

            // format favorites data to trackVos
            return $this->_parseTracksData($tracksData);
        }

        // ##########################################

        /**
         * @return array
         */
        public function fetchPlaylistsData()
        {
            $url = $this->_parseUrlPattern($this->_getUserPlaylistsUrlPattern(), $this->_getFetchData());

            // array from response
            $playlistsData = $this->_fetchRemoteData($url);

            // handle error
            if ($playlistsData === FALSE)
            {
                return FALSE;
            }

            // vo collection
            $playlistsVoMany = array();

            foreach ($playlistsData as $data)
            {
                // dublicate content
                if (isset($data['user']))
                {
                    unset($data['user']);
                }

                $vo = new \Cirrus\Playlists\PlaylistVo();
                $vo->setData($data);
                $playlistsVoMany[] = $vo;
            }

            return $playlistsVoMany;
        }

        // ##########################################

        /**
         * @return array
         */
        public function fetchFollowersData()
        {
            $url = $this->_parseUrlPattern($this->_getUserFollowersUrlPattern(), $this->_getFetchData());

            // array from response
            $followersData = $this->_fetchRemoteData($url);

            // handle error
            if ($followersData === FALSE)
            {
                return FALSE;
            }

            // form followers data to userVos
            return $this->_parseUsersData($followersData);
        }

        // ##########################################

        /**
         * @return array
         */
        public function fetchFollowingsData()
        {
            $url = $this->_parseUrlPattern($this->_getUserFollowingsUrlPattern(), $this->_getFetchData());

            // array from response
            $followingsData = $this->_fetchRemoteData($url);

            // handle error
            if ($followingsData === FALSE)
            {
                return FALSE;
            }

            // format followings data to userVos
            return $this->_parseUsersData($followingsData);
        }

        // ##########################################

        /**
         * @return array
         */
        public function fetchFavoritesData()
        {
            $url = $this->_parseUrlPattern($this->_getUserFavoritesUrlPattern(), $this->_getFetchData());

            // array from response
            $tracksData = $this->_fetchRemoteData($url);

            // handle error
            if ($tracksData === FALSE)
            {
                return FALSE;
            }

            // format favorites data to trackVos
            return $this->_parseTracksData($tracksData);
        }
    }
