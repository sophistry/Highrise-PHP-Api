<?php

require_once('HighrisePerson.class.php');

	// company barely differs from a person in that it just uses a "name" instead of a split "firstname" and "lastname"
	class HighriseCompany extends HighrisePerson {

		public $name;

		function setName($name) {
			$this->name = $name;
		}
		function getName() {
			return $this->name;
		}

		function loadFromXMLObject($xml_object) {
			$this->setName($xml_object->{'name'});
			parent::loadFromXMLObject($xml_object);
		}
	}

