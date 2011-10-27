<?php

require_once('./lib/autorun.php');
require_once('../lib/HighriseAPI.class.php');
require_once('./config.php');


class AllFileTests extends TestSuite {
	function __construct() {
		parent::__construct();
		$this->collect(dirname(__FILE__),new SimplePatternCollector('/_test.php/'));
	}
}

?>
