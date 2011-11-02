<?php
	
require_once('HighriseEntity.class.php');

	class HighriseCompany extends HighriseEntity
	{
		public $name;
		public $type;

		public function __construct(HighriseAPI $highrise)
		{
			parent::__construct($highrise);
			$this->url_base = "companies";
			$this->errorcheck = "Company";
		}
		
		public function setType($type) {
			$this->type = (string)$type;
		}
		public function getType() {
			return (string)$this->type;
		}

		public function toXML($include_header = true)
		{

			$xml = new SimpleXMLElement("<company></company>");
			$xml = parent::createXML($xml);
			$xml->addChild("name",$this->getName());
			$xml->addChild("type",$this->getType());
			return $xml->asXML();
		}
		
		public function loadFromXMLObject($xml_obj)
		{

			parent::loadFromXMLObject($xml_obj);

			$this->setName($xml_obj->{'name'});
			$this->setType("Company");
			if (!empty($xml_obj->{'type'})) {
				$this->setType($xml_obj->{'type'});
			}
			
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
	
