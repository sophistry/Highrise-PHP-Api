<?php
	
	class HighriseTag
	{
		public $id;
		public $name;
		
		public function __construct($id = null, $name = null)
		{
			$this->setId($id);
			$this->setName($name);
		}
		
		public function toXML()
		{

			$xml = new SimpleXMLElement("<tag></tag>");
			$xml->addChild("id",$this->getId());
			$xml->id->addAttribute("type","integer");
			$xml->addChild("name",$this->getName());
			return $xml->asXML();
		}
		
		public function __toString()
		{
			return $this->name;
		}
			
		public function setName($name)
		{
			$this->name = (string)$name;
		}

		public function getName()
		{
			return $this->name;
		}

		public function setId($id)
		{
			$this->id = (string)$id;
		}

		public function getId()
		{
			return $this->id;
		}
	}
	
