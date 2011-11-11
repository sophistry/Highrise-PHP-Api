<?php

class TestOfHighrisePeople extends UnitTestCase {

	public $account;
	public $token;

	private $highrise;
	private $person;

	function __construct() {
		global $hr_account, $hr_apikey;
		$this->account = $hr_account;
		$this->token   = $hr_apikey;
	}


	// setup highrise and a person before testing.
	function setup() {
		$this->highrise = new HighriseAPI;
		$this->highrise->setAccount($this->account);
		$this->highrise->setToken($this->token);

		$this->person = new HighrisePerson($this->highrise);
		$this->person->setFirstName("gF5fK5hU");
		$this->person->setLastName("Nc23jvHP");
		$this->person->addEmailAddress("gF5fK5hU@Nc23jvHP.com");
		$this->person->save();
	}

	// delete the person when complete.
	function tearDown() {
		$this->person->delete();
	}

	function testFindTestUser() {
		$people = $this->highrise->findPeopleByEmail('gF5fK5hU@Nc23jvHP.com');
		$this->assertTrue(count($people)==1);
	}

	function testEmailAddresses() {

		$testaddr = "xxx1xxx@xxx1xxx.com";
		$this->person->addEmailAddress($testaddr);
		$this->person->save();
		$addresses = $this->person->getEmailAddresses();
		foreach ($addresses as $obj) {
			// this seems silly to me, but I'm still new at writing test cases.
			if ($obj->address == $testaddr) {
				$this->assertEqual($obj->address,$testaddr);
				return;
			}
		}
		$this->fail();
	}



}

?>
