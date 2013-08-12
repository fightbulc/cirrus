<?php

    namespace Cirrus\Tracks;

    use Cirrus\AbstractVo;
    use Cirrus\Users\UserVo;

    class TrackVo extends AbstractVo
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

        public function getGenreFiltered()
        {
            $genresClean = [];
            $genres = $this->getGenre();
            $filtered = preg_replace('/[^\w ]+/u', ',', $genres);
            $pairs = explode(',', $filtered);

            foreach ($pairs as $k => $genre)
            {
                $genreTrimmed = trim($genre);

                if (!empty($genreTrimmed))
                {
                    $genresClean[] = $genreTrimmed;
                }
            }

            return join(',', $genresClean);
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

        public function getIsrc()
        {
            return $this->_getByKey('isrc');
        }

        // ##########################################

        public function getVideoUrl()
        {
            return $this->_getByKey('video_url');
        }

        // ##########################################

        public function getTrackType()
        {
            return $this->_getByKey('track_type');
        }

        // ##########################################

        public function getKeySignature()
        {
            return $this->_getByKey('key_signature');
        }

        // ##########################################

        public function getBpm()
        {
            return $this->_getByKey('bpm');
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

        public function getOriginalFormat()
        {
            return $this->_getByKey('original_format');
        }

        // ##########################################

        public function getOriginalSizeInBytes()
        {
            return $this->_getByKey('original_content_size');
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

        public function getUrlWaveform()
        {
            return $this->_getByKey('waveform_url');
        }

        // ##########################################

        public function getUrlStream()
        {
            return $this->_getByKey('stream_url');
        }

        // ##########################################

        public function getUrlStreamPlayable()
        {
            $urlStream = $this->_getByKey('stream_url');
            $clientIdString = "client_id={$this->_getClientId()}";
            $connectorChar = '?';

            if (strpos($urlStream, '?') !== FALSE)
            {
                $connectorChar = '&';
            }

            $urlStream = "{$urlStream}{$connectorChar}{$clientIdString}";

            return $urlStream;
        }

        // ##########################################

        public function getUrlDownload()
        {
            return $this->_getByKey('download_url');
        }

        // ##########################################

        public function getCountPlaybacks()
        {
            return $this->_getByKey('playback_count');
        }

        // ##########################################

        public function getCountDownloads()
        {
            return $this->_getByKey('download_count');
        }

        // ##########################################

        public function getCountFavoritings()
        {
            return $this->_getByKey('favoritings_count');
        }

        // ##########################################

        public function getCountComments()
        {
            return $this->_getByKey('comment_count');
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
         * @return UserVo
         */
        public function getUserVo()
        {
            $vo = new UserVo();
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

        public function getCreatedWith()
        {
            return $this->_getByKey('created_with');
        }

        // ##########################################

        public function getUriAttachments()
        {
            return $this->_getByKey('attachments_uri');
        }
    }