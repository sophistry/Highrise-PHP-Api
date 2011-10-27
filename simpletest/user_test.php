<?php

class TestOfHighriseUsers extends UnitTestCase {

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
	}

	// delete the person when complete.
	function tearDown() {
	}

	function testFindMe() {
		$user = $this->highrise->findMe();
		$this->assertTrue(is_object($user));
	}

	function testFindAllUsers() {
		$users = $this->highrise->findAllUsers();
		$this->assertTrue(count($users)>0);
	}

}

?>
