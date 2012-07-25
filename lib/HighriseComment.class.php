<?php

	class HighriseComment extends HighriseAPI
	{

		protected $_comment_type;
		protected $_comment_url;
		
		public $id;
		public $parent_id;
		public $author_id;
		public $created_at;
		public $updated_at;
		public $body;

		public $owner_id;
		public $subject_id;
		public $subject_type;
		public $subject_name;
		public $visible_to;

		public $deleted;
	

		public function __construct(HighriseAPI $highrise)
		{
			$this->account = $highrise->account;
			$this->token = $highrise->token;
			$this->debug = $highrise->debug;
			$this->curl = curl_init();		
			
			$this->_comment_type = "comment";
			$this->_comment_url = "/comments";
		}

		public function save()
		{

			if ($this->id == null) { // Create
				$comment_xml = $this->toXML();
				$new_xml = $this->postDataWithVerb($this->_comment_url . ".xml", $comment_xml, "POST");
				$this->checkForErrors(ucwords($this->_comment_type), 201);	
				$this->loadFromXMLObject(simplexml_load_string($new_xml));
				return true;
			}
			else // Update
			{
				$comment_xml = $this->toXML();
				$new_xml = $this->postDataWithVerb($this->_comment_url . "/" . $this->getId() . ".xml", $comment_xml, "PUT");
				$this->checkForErrors(ucwords($this->_comment_type), 200);	
				return true;
			}
		}
		
		public function delete()
		{
			$this->postDataWithVerb($this->_comment_url . "/" . $this->getId() . ".xml", "", "DELETE");
			$this->checkForErrors(ucwords($this->_comment_type), 200);	
			$this->deleted = true;
		}
	
		public function loadFromXMLObject($xml_obj)
		{
			if ($this->debug) {
				print_r($xml_obj);
			}

			$this->setId($xml_obj->{'id'});
			$this->setAuthorId($xml_obj->{'author-id'});
			$this->setParentId($xml_obj->{'parent-id'});
			$this->setCreatedAt($xml_obj->{'created-at'});
			$this->setBody($xml_obj->{'body'});

			$this->setOwnerId($xml_obj->{'owner-id'});
			$this->setSubjectId($xml_obj->{'subject-id'});
			$this->setSubjectType($xml_obj->{'subject-type'});
			$this->setSubjectName($xml_obj->{'subject-name'});

			$this->setUpdatedAt($xml_obj->{'updated-at'});
			$this->setVisibleTo($xml_obj->{'visible-to'});
			
			return true;
		}
		
		
		public function setSubjectName($subject_name)
		{
			$this->subject_name = (string)$subject_name;
		}

		public function getSubjectName()
		{
			return $this->subject_name;
		}
		
		public function setVisibleTo($visible_to)
		{
			$this->visible_to = (string)$visible_to;
		}

		public function getVisibleTo()
		{
			return $this->visible_to;
		}

		
		public function setUpdatedAt($updated_at)
		{
			$this->updated_at = (string)$updated_at;
		}

		public function getUpdatedAt()
		{
			return $this->updated_at;
		}

		
		public function setSubjectType($subject_type)
		{
			$valid_types = array("Party", "Company", "Deal", "Kase");
			$subject_type = ucwords(strtolower($subject_type));
			if ($subject_type != null && !in_array($subject_type, $valid_types))
				throw new Exception("$subject_type is not a valid subject type. Available subject types: " . implode(", ", $valid_types));
	
			$this->subject_type = (string)$subject_type;
		}

		public function getSubjectType()
		{
			return $this->subject_type;
		}

		public function setSubjectId($subject_id)
		{
			$this->subject_id = (string)$subject_id;
		}

		public function getSubjectId()
		{
			return $this->subject_id;
		}

		
		public function setOwnerId($owner_id)
		{
			$this->owner_id = (string)$owner_id;
		}

		public function getOwnerId()
		{
			return $this->owner_id;
		}

		
		public function setCreatedAt($created_at)
		{
			$this->created_at = (string)$created_at;
		}

		public function getCreatedAt()
		{
			return $this->created_at;
		}

		
		public function setBody($body)
		{
			$this->body = (string)$body;
		}

		public function getBody()
		{
			return $this->body;
		}

		
		public function setAuthorId($author_id)
		{
			$this->author_id = (string)$author_id;
		}

		public function getAuthorId()
		{
			return $this->author_id;
		}

		public function toXML()
		{

			$comment = new SimpleXMLElement("<" . $this->_comment_type . "></" . $this->_comment_type .">");

			$comment->addChild("id",$this->getId());
			$comment->id->addAttribute("type","integer");
			$comment->addChild("parent-id",$this->getParentId());
			$comment->addChild("author-id",$this->getAuthorId());
			$comment->addChild("body",$this->getBody());
			$comment->addChild("owner-id",$this->getOwnerId());
			$comment->addChild("subject-id",$this->getSubjectId());
			$comment->addChild("subject-type",$this->getSubjectType());
			$comment->addChild("visible-to",$this->getVisibleTo());
			$comment->addChild("created-at",$this->getCreatedAt());
			$comment->{'created-at'}->addAttribute("type","datetime");
			$this->_toXMLAdditionalFields($comment);

			return $comment->asXML();
		}
		
		protected function _toXMLAdditionalFields(&$comment) {
		  // Child classes can override this to insert additional children into the xml object
		}

		
		public function __toString()
		{
			return $this->id;
		}
		

		public function setId($id)
		{
			$this->id = (string)$id;
		}

		public function getId()
		{
			return $this->id;
		}
		
		public function setParentId($parent_id)
		{
			$this->parent_id = (string)$parent_id;
		}

		public function getParentId()
		{
			return $this->parent_id;
		}
	}
	
	
