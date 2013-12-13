<?php

    namespace Cirrus;

    class Cirrus
    {
        /** @var string */
        protected $_clientId;

        /** @var string */
        protected $_accessToken;

        /** @var string */
        protected $_serviceUrl = 'http://api.soundcloud.com';

        /** @var string */
        protected $_secureServiceUrl = 'https://api.soundcloud.com';

        /** @var string */
        protected $_clientIdUrlPattern = '?client_id={{clientId}}';

        /** @var string */
        protected $_accessTokenUrlPattern = '?oauth_token={{accessToken}}';

        /** @var string */
        protected $_resolveUrlPattern = '{{serviceUrl}}/resolve.json{{clientIdUrlPattern}}&url={{url}}';

        /** @var array */
        protected static $_imageSizes = [
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
        ];

        // ##########################################

        /**
         * @param $key
         *
         * @return bool|string
         */
        protected function _getVarByKey($key)
        {
            if (!isset($this->$key))
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
         * @return bool|string
         */
        protected function _getSecureServiceUrl()
        {
            return $this->_getVarByKey('_secureServiceUrl');
        }

        // ##########################################

        /**
         * @param $clientId
         *
         * @return static
         */
        public function setClientId($clientId)
        {
            $this->_clientId = $clientId;

            return $this;
        }

        // ##########################################

        /**
         * @return bool|string
         * @throws CirrusException
         */
        protected function _getClientId()
        {
            $clientId = $this->_getVarByKey('_clientId');

            if (empty($clientId))
            {
                throw new CirrusException(__CLASS__ . ': Missing Soundcloud API-Key (clientId)', 500);
            }

            return $clientId;
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
         * @param $accessToken
         *
         * @return $this
         */
        public function setAccessToken($accessToken)
        {
            $this->_accessToken = $accessToken;

            return $this;
        }

        // ##########################################

        /**
         * @return bool|string
         * @throws CirrusException
         */
        protected function _getAccessToken()
        {
            $accessToken = $this->_getVarByKey('_accessToken');

            if (empty($accessToken))
            {
                throw new CirrusException(__CLASS__ . ': Missing Soundcloud Access Token', 500);
            }

            return $accessToken;
        }

        // ##########################################

        protected function _getAccessTokenUrlPattern()
        {
            $data = array(
                'accessToken' => $this->_getAccessToken(),
            );

            return $this->_parseUrlPattern($this->_accessTokenUrlPattern, $data);
        }

        // ##########################################

        /**
         * @param $url
         *
         * @return string
         */
        protected function _getResolveUrlPattern($url)
        {
            $data = array(
                'serviceUrl'         => $this->_getServiceUrl(),
                'clientIdUrlPattern' => $this->_getClientIdUrlPattern(),
                'url'                => $url,
            );

            return $this->_parseUrlPattern($this->_resolveUrlPattern, $data);
        }

        // ##########################################

        /**
         * @param $pattern
         * @param $values
         *
         * @return string
         */
        protected function _parseUrlPattern($pattern, $values)
        {
            foreach ($values as $key => $val)
            {
                $pattern = str_replace('{{' . $key . '}}', $val, $pattern);
            }

            return $pattern;
        }

        // ##########################################

        /**
         * @param $url
         *
         * @return mixed
         * @throws CirrusException
         */
        protected function _fetchRemoteData($url)
        {
            $jsonResponse = \CURL::init($url)
                ->setReturnTransfer(TRUE)
                ->execute();

            $data = json_decode($jsonResponse, TRUE);

            // handle errors
            if (isset($data['errors']))
            {
                throw new CirrusException(__CLASS__ . ": Failed fetching remote data from url={$url}", 500);
            }

            return $data;
        }

        // ##########################################

        /**
         * @param $url
         * @param $vars
         *
         * @return mixed
         * @throws CirrusException
         */
        protected function _putRemoteData($url, $vars)
        {
            $jsonResponse = \CURL::init($url)
                ->setReturnTransfer(TRUE)
                ->setCustomRequest('PUT')
                ->setPostFields($vars)
                ->execute();

            $data = json_decode($jsonResponse, TRUE);

            // handle errors
            if (isset($data['errors']))
            {
                throw new CirrusException(__CLASS__ . ": Failed putting reote data at url={$url}", 500);
            }

            return $data;
        }

        // ##########################################

        /**
         * @param array $data
         * @param AbstractVo $voClass
         *
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
         *
         * @return mixed
         */
        public static function getImageUrlBySize($imageUrl, $size)
        {
            if (!isset(Cirrus::$_imageSizes[$size]))
            {
                return $imageUrl;
            }

            return str_replace('large', Cirrus::$_imageSizes[$size], $imageUrl);
        }

        // ##########################################

        /**
         * @param $url
         *
         * @return bool|CirrusResolveUrlVo
         */
        public function resolveUrl($url)
        {
            // build url
            $url = $this->_getResolveUrlPattern($url);

            // talk to soundcloud
            $response = $this->_fetchRemoteData($url);

            // handle response
            if (isset($response['status']) && strpos($response['status'], '302') !== FALSE)
            {
                $data = $this->_parseResolveUrlResponse($response['location']);

                if ($data !== FALSE)
                {
                    return new CirrusResolveUrlVo($data);
                }
            }

            return FALSE;
        }

        // ######################################

        /**
         * @param $urlResponse
         *
         * @return array|bool
         */
        protected function _parseResolveUrlResponse($urlResponse)
        {
            $parts = explode('/', $urlResponse);
            $path = explode('.', $parts[4]);

            $type = NULL;
            $id = NULL;

            // user
            if ($parts[3] === 'users' && !empty($path[0]))
            {
                $type = 'user';
                $id = $path[0];
            }

            // tracks
            elseif ($parts[3] === 'tracks' && !empty($path[0]))
            {
                $type = 'track';
                $id = $path[0];
            }

            // playlist
            elseif ($parts[3] === 'playlists' && !empty($path[0]))
            {
                $type = 'playlist';
                $id = $path[0];
            }

            if ($type !== NULL)
            {
                return [
                    'type' => $type,
                    'id'   => $id,
                ];
            }

            return FALSE;
        }
    }
