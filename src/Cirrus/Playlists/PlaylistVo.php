<?php

    namespace Cirrus\Playlists;

    use Cirrus\AbstractVo;
    use Cirrus\Tracks\TrackVo;

    class PlaylistVo extends AbstractVo
    {
        public function getId()
        {
            return $this->_getByKey('id');
        }

        // ##########################################

        public function getCreatedAt()
        {
            return $this->_getByKey('created_at');
        }

        // ##########################################

        public function getUserId()
        {
            return $this->_getByKey('user_id');
        }

        // ##########################################

        public function getDurationInMs()
        {
            return $this->_getByKey('duration');
        }

        // ##########################################

        public function isCommentable()
        {
            return $this->_getByKey('commentable');
        }

        // ##########################################

        public function getState()
        {
            return $this->_getByKey('state');
        }

        // ##########################################

        public function getSharingType()
        {
            return $this->_getByKey('sharing');
        }

        // ##########################################

        public function getTagList()
        {
            return $this->_getByKey('tag_list');
        }

        // ##########################################

        public function getPermalink()
        {
            return $this->_getByKey('permalink');
        }

        // ##########################################

        public function getDescription()
        {
            return $this->_getByKey('description');
        }

        // ##########################################

        public function isStreamable()
        {
            return $this->_getByKey('streamable');
        }

        // ##########################################

        public function isDownloadable()
        {
            return $this->_getByKey('downloadable');
        }

        // ##########################################

        public function getGenre()
        {
            return $this->_getByKey('genre');
        }

        // ##########################################

        public function getRelease()
        {
            return $this->_getByKey('release');
        }

        // ##########################################

        public function getUrlPurchase()
        {
            return $this->_getByKey('purchase_url');
        }

        // ##########################################

        public function getLabelId()
        {
            return $this->_getByKey('label_id');
        }

        // ##########################################

        public function getLabelName()
        {
            return $this->_getByKey('label_name');
        }

        // ##########################################

        public function getType()
        {
            return $this->_getByKey('type');
        }

        // ##########################################

        public function getPlaylistType()
        {
            return $this->_getByKey('playlist_type');
        }

        // ##########################################

        public function getEan()
        {
            return $this->_getByKey('ean');
        }

        // ##########################################

        public function getTitle()
        {
            return $this->_getByKey('title');
        }

        // ##########################################

        public function getReleaseYear()
        {
            return $this->_getByKey('release_year');
        }

        // ##########################################

        public function getReleaseMonth()
        {
            return $this->_getByKey('release_month');
        }

        // ##########################################

        public function getReleaseDay()
        {
            return $this->_getByKey('release_day');
        }

        // ##########################################

        public function getLicense()
        {
            return $this->_getByKey('license');
        }

        // ##########################################

        public function getUri()
        {
            return $this->_getByKey('uri');
        }

        // ##########################################

        public function getUrlPermalink()
        {
            return $this->_getByKey('permalink_url');
        }

        // ##########################################

        public function getUrlArtwork()
        {
            return $this->_getByKey('artwork_url');
        }

        // ##########################################

        /**
         * @return array
         */
        public function getUser()
        {
            return $this->_getByKey('user');
        }

        // ##########################################

        /**
         * @return \Cirrus\Users\UserVo
         */
        public function getUserVo()
        {
            $vo = new \Cirrus\Users\UserVo();
            $vo->setData($this->getUser());

            return $vo;
        }

        // ##########################################

        public function setCompleteUserVo($vo)
        {
            $this->_setByKey('userVo', $vo);

            return $this;
        }

        // ##########################################

        /**
         * @return \Cirrus\Users\UserVo
         */
        public function getCompleteUserVo()
        {
            return $this->_getByKey('userVo');
        }

        // ##########################################

        /**
         * @return array
         */
        public function getTracks()
        {
            return $this->_getByKey('tracks');
        }

        // ##########################################

        /**
         * @return int
         */
        public function getCountTracks()
        {
            return count($this->getTracks());
        }

        // ##########################################

        /**
         * @return array|bool
         */
        public function getTracksVo()
        {
            $tracks = $this->getTracks();

            if (!empty($tracks))
            {
                $tracksVo = array();

                foreach ($tracks as $track)
                {
                    // remove dublicate content
                    if (isset($track['user']))
                    {
                        unset($track['user']);
                    }

                    // for playable stream url
                    $track['_client_id'] = $this->_getClientId();

                    $vo = new TrackVo();
                    $vo->setData($track);
                    $tracksVo[] = $vo;
                }

                return $tracksVo;
            }

            return FALSE;
        }
    }