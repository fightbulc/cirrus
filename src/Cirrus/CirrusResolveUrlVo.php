<?php

    namespace Cirrus;

    class CirrusResolveUrlVo
    {
        protected $_type;
        protected $_id;

        // ######################################

        public function __construct(array $data)
        {
            $this
                ->setId($data['id'])
                ->setType($data['type']);
        }

        // ######################################

        /**
         * @param mixed $id
         *
         * @return CirrusResolveUrlVo
         */
        public function setId($id)
        {
            $this->_id = $id;

            return $this;
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
         * @param mixed $type
         *
         * @return CirrusResolveUrlVo
         */
        public function setType($type)
        {
            $this->_type = $type;

            return $this;
        }

        // ######################################

        /**
         * @return mixed
         */
        public function getType()
        {
            return $this->_type;
        }
    }