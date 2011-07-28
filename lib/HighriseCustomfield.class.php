<?php
	
	class HighriseCustomfield
	{
		public $id;
		public $subject_field_id;
		public $subject_field_label;
		public $value;
		
		public function __construct($id = null, $value = null, $subject_field_id = null, $subject_field_label = null)
		{
			$this->setId($id);
			$this->setValue($value);
			$this->setSubjectFieldId($subject_field_id);
			$this->setSubjectFieldLabel($subject_field_label);
		}
		
		public function toXML()
		{
			$xml = '';
			if ($this->getId() != null) {
				$xml = "<subject_data>\n";
				$xml .= '  <id type="integer">' . $this->getId() . "</id>\n";
				$xml .= '  <value>' . $this->getValue() . "</value>\n";
				$xml .= '  <subject_field_id type="integer">' . $this->getSubjectFieldId() . "</subject_field_id>\n";
				$xml .= '  <subject_field_label>' . $this->getSubjectFieldLabel() . "</subject_field_label>\n";
				$xml .= "</subject_data>\n";
			}
			return $xml;
		}
		
		public function __toString()
		{
			return $this->subject_field_label . ": " . $this->value;
		}

		public function setId($id)
		{
			$this->id = (string)$id;
		}

		public function getId()
		{
			return $this->id;
		}
			
		public function setSubjectFieldId($subject_field_id)
		{
			$this->subject_field_id = (string)$subject_field_id;
		}

		public function getSubjectFieldId()
		{
			return $this->subject_field_id;
		}

		public function setSubjectFieldLabel($subject_field_label)
		{
			$this->subject_field_label = (string)$subject_field_label;
		}

		public function getSubjectFieldLabel()
		{
			return $this->subject_field_label;
		}

		public function setValue($value)
		{
			$this->value = (string)$value;
		}

		public function getValue()
		{
			return $this->value;
		}
	}
	
