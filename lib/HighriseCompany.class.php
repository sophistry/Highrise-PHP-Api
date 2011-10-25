<?php
	
	class HighriseCompany extends HighriseEntity
	{
		public $name;
		public $type;
		
		public function setType($type) {
			$this->type = (string)$type;
		}
		public function getType() {
			return (string)$this->type;
		}

		public function delete()
		{
			$this->postDataWithVerb("/companies/" . $this->getId() . ".xml", "", "DELETE");
			$this->checkForErrors("Company", 200);	
		}
		
		public function save()
		{
			$xml = $this->toXML();
			if ($this->getId() != null)
			{
				$new_xml = $this->postDataWithVerb("/companies/" . $this->getId() . ".xml?reload=true", $xml, "PUT");
				$this->checkForErrors("Company");
			}
			else
			{
				$new_xml = $this->postDataWithVerb("/companies.xml", $xml, "POST");
				$this->checkForErrors("Company", 201);
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

						$new_tag_data = $this->postDataWithVerb("/companies/" . $this->getId() . "/tags.xml", "<name>" . $tag->getName() . "</name>", "POST");
						$this->checkForErrors("Company (add tag)", array(200, 201));
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

						$new_tag_data = $this->postDataWithVerb("/companies/" . $this->getId() . "/tags/" . $tag_id . ".xml", "", "DELETE");
						$this->checkForErrors("Company (delete tag)", 200);
					}					
				}
				
				foreach($this->tags as $tag_name => $tag)
					$this->original_tags[$tag->getId()] = 1;	
			}
		}

		public function toXML($include_header = true)
		{

			$xml = new SimpleXMLElement(parent::toXML());
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
	
