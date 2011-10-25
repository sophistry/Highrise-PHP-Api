<?php
	
	class HighrisePerson extends HighriseEntity
	{
		public $company_id;
		public $first_name;
		public $last_name;
		public $title;
		public $type;
		
		public function setType($type) {
			$this->type = (string)$type;
		}
		public function getType() {
			return (string)$this->type;
		}

		public function delete()
		{
			$this->postDataWithVerb("/people/" . $this->getId() . ".xml", "", "DELETE");
			$this->checkForErrors("Person", 200);	
		}
		
		public function save()
		{
			$person_xml = $this->toXML();
			if ($this->getId() != null)
			{
				$new_xml = $this->postDataWithVerb("/people/" . $this->getId() . ".xml?reload=true", $person_xml, "PUT");
				$this->checkForErrors("Person");
			}
			else
			{
				$new_xml = $this->postDataWithVerb("/people.xml", $person_xml, "POST");
				$this->checkForErrors("Person", 201);
			}
			
			// Reload object and add tags.
			$tags = $this->tags;
			$original_tags = $this->original_tags;
				
			$this->loadFromXMLObject(simplexml_load_string($new_xml));
			$this->tags = $tags;
			$this->original_tags = $original_tags;
			$this->saveTags();
		
			return true;
		}
		
		public function saveTags()
		{
			if (is_array($this->tags))
			{
				foreach($this->tags as $tag_name => $tag)
				{
					if ($tag->getId() == null) // New Tag
					{
					 	
						if ($this->debug)
							print "Adding Tag: " . $tag->getName() . "\n";

						$new_tag_data = $this->postDataWithVerb("/people/" . $this->getId() . "/tags.xml", "<name>" . $tag->getName() . "</name>", "POST");
						$this->checkForErrors("Person (add tag)", array(200, 201));
						$new_tag_data = simplexml_load_string($new_tag_data);
						$this->tags[$tag_name]->setId($new_tag_data->id);
						unset($this->original_tags[$tag->getId()]);

					}
					else // Remove Tag from deletion list
					{
						unset($this->original_tags[$tag->getId()]);
					}
				}
				
				if (is_array($this->original_tags))
				{
					foreach($this->original_tags as $tag_id=>$v)
					{
						if ($this->debug)
							print "REMOVE TAG: " . $tag_id;
						$new_tag_data = $this->postDataWithVerb("/people/" . $this->getId() . "/tags/" . $tag_id . ".xml", "", "DELETE");
						$this->checkForErrors("Person (delete tag)", 200);
					}					
				}
				
				foreach($this->tags as $tag_name => $tag)
					$this->original_tags[$tag->getId()] = 1;	
			}
		}

		public function toXML($include_header = true)
		{

			$xml = new SimpleXMLElement(parent::toXML());
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

		public function __construct(HighriseAPI $highrise)
		{
			$this->highrise = $highrise;
			$this->account = $highrise->account;
			$this->token = $highrise->token;
			$this->setVisibleTo("Everyone");
			$this->debug = $highrise->debug;
			$this->curl = curl_init();		
		}
	}
	
