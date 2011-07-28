<?php
	
	class HighriseParty extends HighriseAPI
	{
		private $highrise;

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

			$xml  = "<deal>\n";
			$xml .= '  <account-id>' . $this->getAccountId() . "</account-id>\n";
			$xml .= '</deal>';
			return $xml;
		}		
		
		public function loadFromXMLObject($xml_obj)
		{
	
			if ($this->debug)
				print_r($xml_obj);

			if ($xml_obj->{'type'} == "Company") {
                        	$company = new HighriseCompany($this->highrise);
                        	$company->loadFromXMLObject($xml_obj);
                        	return $company;
			} elseif ($xml_obj->{'type'} == "Person") {
                        	$person = new HighrisePerson($this->highrise);
                        	$person->loadFromXMLObject($xml_obj);
                        	return $person;
			} else {
				throw new Exception("Party type is not supported: " . $xml_obj->{'type'});
			}

		}

	}

