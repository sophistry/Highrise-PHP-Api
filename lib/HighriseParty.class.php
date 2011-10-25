<?php
	
	class HighriseParty extends HighriseAPI
	{
		private $highrise;
		public $type;

		public function __construct(HighriseAPI $highrise)
		{
			$this->highrise = $highrise;
			$this->account = $highrise->account;
			$this->token = $highrise->token;
			$this->debug = $highrise->debug;
			$this->curl = curl_init();		
		}

		// TODO
		public function toXML()
		{
			if (empty($this->type)) {
				return "";
			}

			$xml = "<party>\n";

			if ($this->type == "Company") {
				$xml .= $this->company->toXML(false);
			} elseif ($this->type == "Person") {
				$xml .= $this->person->toXML(false);
			} else {
				throw new Exception("Party type is not supported: " . $this->type);
			}

			$xml .= "</party>\n";
			return $xml;
		}		
		
		public function loadFromXMLObject($xml_obj)
		{

			if ($this->debug) {
				print_r($xml_obj);
			}

			if (empty($xml_obj->{'type'})) {
				return false;
			}

			if ($xml_obj->{'type'} == "Company") {
				$this->type = "Company";
                        	$this->company = new HighriseCompany($this->highrise);
                        	$this->company->loadFromXMLObject($xml_obj);
			} elseif ($xml_obj->{'type'} == "Person") {
				$this->type = "Person";
                        	$this->person = new HighrisePerson($this->highrise);
                        	$this->person->loadFromXMLObject($xml_obj);
			} else {
				throw new Exception("Party type is not supported: " . $xml_obj->{'type'});
			}

		}

	}

