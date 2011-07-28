<?php
	class HighriseDeal extends HighriseAPI
	{
		private $highrise;
		public $id;

		public $account_id;
		public $author_id;
		public $background;
		public $category_id;
		public $created_at;
		public $currency;
		public $duration;
		public $group_id;
		public $name;
		public $owner_id;
		public $party_id;
		public $price;
		public $price_type;
		public $responsible_party_id;
		public $status;
		public $status_changed_on;
		public $parties;
		public $party;
		
		public function __construct(HighriseAPI $highrise)
		{
			$this->highrise = $highrise;
			$this->account = $highrise->account;
			$this->token = $highrise->token;
			$this->debug = $highrise->debug;
			$this->curl = curl_init();		
			$this->parties = array();
		}

		public function status_update($status)
		{
			$valid_status = array(
				'pending',
				'won',
				'lost'
			);
			if (!in_array($status,$valid_status)) {
				throw new Exception("'$status' is not a valid status type. Available status names: " . implode(", ", $valid_status));
			}
			$status_update_xml = "<status><name>$status</name></status>";
			$response = $this->postDataWithVerb("/deals/" . $this->getId() . "/status.xml", $status_update_xml, "PUT");
			$this->checkForErrors("Deals", 200);	
			return true;
		}
		
		public function save()
		{
			if ($this->getFrame() == null)
				throw new Exception("You need to specify a valid time frame to save a task");

			if ($this->id == null) // Create
			{
				$task_xml = $this->toXML();
				$new_task_xml = $this->postDataWithVerb("/tasks.xml", $task_xml, "POST");
				$this->checkForErrors("Task", 201);	
				$this->loadFromXMLObject(simplexml_load_string($new_task_xml));
				return true;
			}
			else
			{
				$task_xml = $this->toXML();
				$new_task_xml = $this->postDataWithVerb("/tasks/" . $this->getId() . ".xml", $task_xml, "PUT");
				$this->checkForErrors("Task", 200);	
				return true;	
			}
		}
		
		public function delete()
		{
			$this->postDataWithVerb("/deals/" . $this->getId() . ".xml", "", "DELETE");
			$this->checkForErrors("Task", 200);	
			$this->deleted = true;
		}
		
		public function assignToUser(HighriseUser $user)
		{
			$this->setOwnerId($user->getId());
		}
		
		public function setOwnerId($owner_id)
		{
			$this->owner_id = (string)$owner_id;
		}

		public function getOwnerId()
		{
			return $this->owner_id;
		}

		
		public function setAccountId($account_id)
		{
			$this->account_id = (string)$account_id;
		}

		public function getAccountId()
		{
			return $this->account_id;
		}

		public function setAuthorId($author_id)
		{
			$this->author_id = (string)$author_id;
		}

		public function getAuthorId()
		{
			return $this->author_id;
		}

		
		
		public function setBackground($background)
		{
			$this->background = (string)$background;
		}

		public function getBackground()
		{
			return $this->background;
		}

		
		public function setCategoryId($category_id)
		{
			$this->category_id = (string)$category_id;
		}

		public function getCategoryId()
		{
			return $this->category_id;
		}

		
		public function setCreatedAt($created_at)
		{
			$this->created_at = (string)$created_at;
		}

		public function getCreatedAt()
		{
			return $this->created_at;
		}

		
		public function setCurrency($currency)
		{
			$this->currency = (string)$currency;
		}

		public function getCurrency()
		{
			return $this->currency;
		}

		public function setDuration($duration)
		{
			$this->duration = (string)$duration;
		}

		public function getDuration()
		{
			return $this->duration;
		}

		
		public function setGroupId($group_id)
		{
			$this->group_id = (string)$group_id;
		}

		public function getGroupId()
		{
			return $this->group_id;
		}

		
		public function setName($name)
		{
			$this->name = (string)$name;
		}

		public function getName()
		{
			return $this->name;
		}

		public function setPartyId($party_id)
		{
			$this->party_id = (string)$party_id;
		}

		public function getPartyId()
		{
			return $this->party_id;
		}

		
		public function setPrice($price)
		{
			$this->price = (string)$price;
		}

		public function getPrice()
		{
			return $this->price;
		}

		
		public function setPriceType($price_type)
		{
			$this->price_type = (string)$price_type;
		}

		public function getPriceType()
		{
			return $this->price_type;
		}

		
		public function setResponsiblePartyId($responsible_party_id)
		{
			$this->responsible_party_id = (string)$responsible_party_id;
		}

		public function getResponsiblePartyId()
		{
			return $this->responsible_party_id;
		}

		public function setStatus($status)
		{
			$this->status = (string)$status;
		}

		public function getStatus()
		{
			return $this->status;
		}

		public function setStatusChangedOn($status_changed_on)
		{
			$this->status_changed_on = (string)$status_changed_on;
		}

		public function getStatusChangedOn()
		{
			return $this->status_changed_on;
		}

		public function setUpdatedAt($updated_at)
		{
			$this->updated_at = (string)$updated_at;
		}

		public function getUpdatedAt()
		{
			return $this->updated_at;
		}

		public function setVisibleTo($visible_to)
		{
			$this->visible_to = (string)$visible_to;
		}

		public function getVisibleTo()
		{
			return $this->visible_to;
		}

		// no set parties or party since they're "special"
		public function getParties()
		{
			return $this->parties;
		}

		public function getParty()
		{
			return $this->party;
		}

		public function toXML()
		{

			$xml  = "<deal>\n";
			$xml .= '  <account-id>' . $this->getAccountId() . "</account-id>\n";
			$xml .= '  <author-id>' . $this->getAuthorId() . "</author-id>\n";
			$xml .= '  <background>' . $this->getBackground() . "</background>\n";
			$xml .= '  <category-id>' . $this->getCategoryId() . "</category-id>\n";
			$xml .= '  <created-at>' . $this->getCreatedAt() . "</created-at>\n";
			$xml .= '  <currency>' . $this->getCurrency() . "</currency>\n";
			$xml .= '  <duration>' . $this->getDuration() . "</duration>\n";
			$xml .= '  <group-id>' . $this->getGroupId() . "</group-id>\n";
			$xml .= '  <name>' . $this->getName() . "</name>\n";
			$xml .= '  <owner-id>' . $this->getOwnerId() . "</owner-id>\n";
			$xml .= '  <party-id>' . $this->getPartyId() . "</party-id>\n";
			$xml .= '  <price>' . $this->getPrice() . "</price>\n";
			$xml .= '  <price-type>' . $this->getPriceType() . "</price-typen";
			$xml .= '  <responsible-party-id>' . $this->getResponsiblePartyId() . "</responsible-party-id>\n";
			$xml .= '  <status>' . $this->getStatus() . "</status>\n";
			$xml .= '  <status-changed-on>' . $this->getStatusChangedOn() . "</status-changed-on>\n";
			$xml .= '  <updated-at>' . $this->getUpdatedAt() . "</updated-at>\n";
			$xml .= '  <visibile-to>' . $this->getVisibleTo() . "</visible-to>\n";
			$xml .= '  <parties>' . $this->getParties() . "</parties>\n";
			$xml .= '  <party>' . $this->getParty() . "</party>\n";
			$xml .= '</deal>';
			return $xml;
		}		
		
		public function loadFromXMLObject($xml_obj)
		{
	
			if ($this->debug)
				print_r($xml_obj);

			$this->setAccountId($xml_obj->{'account-id'});
			$this->setAuthorId($xml_obj->{'author-id'});
			$this->setBackground($xml_obj->{'background'});
			$this->setCategoryId($xml_obj->{'category-id'});
			$this->setCreatedAt($xml_obj->{'created-at'});
			$this->setCurrency($xml_obj->{'currency'});
			$this->setDuration($xml_obj->{'duration'});
			$this->setGroupId($xml_obj->{'group-id'});
			$this->setName($xml_obj->{'name'});
			$this->setOwnerId($xml_obj->{'owner-id'});
			$this->setPartyId($xml_obj->{'party-id'});
			$this->setPrice($xml_obj->{'price'});
			$this->setPriceType($xml_obj->{'price-type'});
			$this->setResponsiblePartyId($xml_obj->{'responsible-party-id'});
			$this->setStatus($xml_obj->{'status'});
			$this->setStatusChangedOn($xml_obj->{'status-changed-on'});
			$this->setUpdatedAt($xml_obj->{'updated-at'});
			$this->setVisibleTo($xml_obj->{'visible-to'});

			$this->loadPartiesFromXMLObject($xml_obj->{'parties'});
			$this->loadPartyFromXMLObject($xml_obj->{'party'});

			return true;
		}


		function loadPartyFromXMLObject($xml_obj) {

			$party = new HighriseParty($this->highrise);
			$this->party = $party->loadfromXMLObject($xml_obj);

		}

		function loadPartiesFromXMLObject($xml_obj) {
			if (count($xml_obj->{'party'}) > 0) {
				foreach($xml_obj->{'party'} as $party_obj) {
					$new_party = new HighriseParty($this->highrise);
					$this->parties[] = $new_party->loadFromXMLObject($party_obj);
				}
			}

		}

	}
	
