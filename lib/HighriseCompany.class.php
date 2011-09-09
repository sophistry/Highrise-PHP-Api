<?php

require_once('HighrisePerson.class.php');

	// company barely differs from a person in that it just uses a "name" instead of a split "firstname" and "lastname"
	class HighriseCompany extends HighrisePerson {

		public $name;

		public function setName($name) {
			$this->name = (string)$name;
		}
		public function getName() {
			return $this->name;
		}

		public function loadFromXMLObject($xml_object) {
			$this->setName($xml_object->{'name'});
			parent::loadFromXMLObject($xml_object);
		}

		public function toXML($include_header = true)
		{

			$xml = '';
			if ($include_header == true) {
				$xml = "<company>";
			}

			$xml .= "the xml goes here";
			# $xml .= parent::toXML(false) . "\n";

			if ($include_header == true) {
				$xml .= "</company";
			}

			return $xml;
		}
	}
