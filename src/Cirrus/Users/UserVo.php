<?php

    namespace Cirrus\Users;

    use Cirrus\AbstractVo;
    use Cirrus\Tracks\TrackVo;

    class UserVo extends AbstractVo
    {
        public function getId()
        {
            return $this->_getByKey('id');
        }

        // ##########################################

        public function getPermalink()
        {
            return $this->_getByKey('permalink');
        }

        // ##########################################

        public function getUsername()
        {
            return $this->_getByKey('username');
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

        public function getUrlAvatar()
        {
            return $this->_getByKey('avatar_url');
        }

        // ##########################################

        public function getCountry()
        {
            return $this->_getByKey('country');
        }

        // ##########################################

        public function getFullName()
        {
            return $this->_getByKey('full_name');
        }

        // ##########################################

        public function getCity()
        {
            return $this->_getByKey('city');
        }

        // ##########################################

        public function getDescription()
        {
            return $this->_getByKey('description');
        }

        // ##########################################

        public function getDiscogsName()
        {
            return $this->_getByKey('discogs_name');
        }

        // ##########################################

        public function getMyspaceName()
        {
            return $this->_getByKey('myspace_name');
        }

        // ##########################################

        public function getWebsite()
        {
            return $this->_getByKey('website');
        }

        // ##########################################

        public function getWebsiteTitle()
        {
            return $this->_getByKey('website_title');
        }

        // ##########################################

        public function isOnline()
        {
            return $this->_getByKey('online');
        }

        // ##########################################

        public function getCountTrack()
        {
            return $this->_getByKey('track_count');
        }

        // ##########################################

        public function getCountPlaylist()
        {
            return $this->_getByKey('playlist_count');
        }

        // ##########################################

        public function getCountFollowers()
        {
            return $this->_getByKey('followers_count');
        }

        // ##########################################

        public function getCountFollowings()
        {
            return $this->_getByKey('followings_count');
        }

        // ##########################################

        public function getCountPublicFavorites()
        {
            return $this->_getByKey('public_favorites_count');
        }

        // ##########################################

        public function setTracksVo($tracksVo)
        {
            $this->_setByKey('tracksVo', $tracksVo);

            return $this;
        }

        // ##########################################

        // list of trackVo
        public function getTracksVo()
        {
            return $this->_getByKey('tracksVo');
        }

        // ##########################################

        /**
         * @return bool|string
         */
        public function getTrackGenresUnique()
        {
            $unique = [];

            /** @var TrackVo[] $trackVoMany */
            $trackVoMany = $this->getTracksVo();

            if (empty($trackVoMany))
            {
                return FALSE;
            }

            foreach ($trackVoMany as $trackVo)
            {
                $genresFiltered = $trackVo->getGenreFiltered();
                $pairs = explode(',', $genresFiltered);

                foreach ($pairs as $genre)
                {
                    if (!empty($genre) && !in_array($genre, $unique))
                    {
                        $unique[] = $genre;
                    }
                }
            }

            // sort
            sort($unique);

            return join(',', $unique);
        }

        // ##########################################

        public function setPlaylistsVo($playlistsVo)
        {
            $this->_setByKey('playlistsVo', $playlistsVo);

            return $this;
        }

        // ##########################################

        // list of playlistVo
        public function getPlaylistsVo()
        {
            return $this->_getByKey('playlistsVo');
        }

        // ##########################################

        public function setFollowersVo($followersVo)
        {
            $this->_setByKey('followersVo', $followersVo);

            return $this;
        }

        // ##########################################

        // list of userVo
        public function getFollowersVo()
        {
            return $this->_getByKey('followersVo');
        }

        // ##########################################

        public function setFollowingsVo($followingsVo)
        {
            $this->_setByKey('followingsVo', $followingsVo);

            return $this;
        }

        // ##########################################

        // list of userVo
        public function getFollowingsVo()
        {
            return $this->_getByKey('followingsVo');
        }

        // ##########################################

        public function setFavoritesVo($favoritesVo)
        {
            $this->_setByKey('favoritesVo', $favoritesVo);

            return $this;
        }

        // ##########################################

        // list of trackVo
        public function getFavoritesVo()
        {
            return $this->_getByKey('favoritesVo');
        }

        // ##########################################

        public function setUserWebProfileVoMany(array $userWebProfileVoMany)
        {
            $this->_setByKey('userWebProfileVoMany', $userWebProfileVoMany);

            return $this;
        }

        // ##########################################

        // list of trackVo
        public function getUserWebProfileVoMany()
        {
            return $this->_getByKey('userWebProfileVoMany');
        }
    }