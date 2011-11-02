<?php
	
require_once('HighriseEntity.class.php');

	class HighriseCompany extends HighriseEntity
	{
		public $name;

		public function __construct(HighriseAPI $highrise)
		{
			parent::__construct($highrise);
			$this->url_base = "companies";
			$this->errorcheck = "Company";
			$this->setType("Company");
		}

		public function toXML($header = "company")
		{

			$xml = new SimpleXMLElement("<" . $header . "></" . $header . ">");
			$xml = parent::createXML($xml);
			$xml->addChild("name",$this->getName());
			return $xml->asXML();
		}
		
		public function loadFromXMLObject($xml_obj)
		{

			parent::loadFromXMLObject($xml_obj);
			$this->setName($xml_obj->{'name'});
		}
		
		public function setName($name)
		{
			$this->name = (string)$name;
		}

		public function getName()
		{
			return $this->name;
		}
		
	}
	
