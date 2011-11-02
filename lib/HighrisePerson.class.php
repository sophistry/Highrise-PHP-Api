<?php

require_once('HighriseEntity.class.php');

	
	class HighrisePerson extends HighriseEntity
	{
		public $company_id;
		public $company_name;
		public $first_name;
		public $last_name;
		public $title;
		public $type;

		public function __construct(HighriseAPI $highrise)
		{
			parent::__construct($highrise);
			$this->url_base = "people";
			$this->errorcheck = "Person";
		}

		public function setType($type) {
			$this->type = (string)$type;
		}
		public function getType() {
			return (string)$this->type;
		}

		public function toXML($include_header = true)
		{

			$xml = new SimpleXMLElement("<person></person>");
			$xml = parent::createXML($xml);
			$xml->addChild("company-id",$this->getCompanyId());
			$xml->addChild("company-name",$this->getCompanyName());
			$xml->addChild("first-name",$this->getFirstName());
			$xml->addChild("last-name",$this->getLastName());
			$xml->addChild("type",$this->getType());
			
			return $xml->asXML();
		}
		
		public function loadFromXMLObject($xml_obj)
		{

			parent::loadFromXMLObject($xml_obj);

			$this->setFirstName($xml_obj->{'first-name'});
			$this->setLastName($xml_obj->{'last-name'});
			$this->setTitle($xml_obj->{'title'});
			$this->setCompanyId($xml_obj->{'company-id'});
			$this->setCompanyName($xml_obj->{'company-name'});
			$this->setType("Person");
			if (!empty($xml_obj->{'type'})) {
				$this->setType($xml_obj->{'type'});
			}
			
		}
		
		public function setCompanyId($company_id)
		{
			$this->company_id = (string)$company_id;
		}

		public function getCompanyId()
		{
			return $this->company_id;
		}
		
		public function setCompanyName($company_name)
		{
			$this->company_name = (string)$company_name;
		}

		public function getCompanyName()
		{
			return $this->company_name;
		}

		public function getFullName()
		{
			return $this->getFirstName() . " " . $this->getLastName();
		}
		public function setLastName($last_name)
		{
			$this->last_name = (string)$last_name;
		}

		public function getLastName()
		{
			return $this->last_name;
		}

		public function setFirstName($first_name)
		{
			$this->first_name = (string)$first_name;
		}

		public function getFirstName()
		{
			return $this->first_name;
		}

		public function setTitle($title)
		{
			$this->title = (string)$title;
		}

		public function getTitle()
		{
			return $this->title;
		}
	}
	
