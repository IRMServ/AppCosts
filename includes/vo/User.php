<?php

class User {
	private $name = null;
	private $id = null;
	private $nivel = null;

	public function getName() {
		return $this->name;
	}

	public function setName($name) {
		$this->name = $name;
	}
        public function getId() {
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function getNivel() {
            return $this->nivel;
        }

        public function setNivel($nivel) {
            $this->nivel = $nivel;
        }
        
        
        
        


}
