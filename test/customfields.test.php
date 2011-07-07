<?php
require_once("../lib/HighriseAPI.class.php");

if (count($argv) != 3)
	die("Usage: php notes.test.php [account-name] [access-token]\n");

$hr = new HighriseAPI();
$hr->debug = false;
$hr->setAccount($argv[1]);
$hr->setToken($argv[2]);

$people = $hr->findPeopleBySearchTerm("Person Test");

$person = $people[0];
$fields = $person->getCustomFields();
foreach($fields as $field)
{
	print_r($field);
	# print $note->toXML();
}

// Create new field

$field = new HighriseCustomfield($hr);
$field->setLabel("New Label");
$field->save();

print "New field ID: " . $field->getId() . " Created at: " . $field->getCreatedAt() . "\n";

$notes = $person->getNotes();
foreach($notes as $note)
{
	if ($note->body == "Testi")
	{
		print "Deleting: " . $note->id . "\n";
		$note->delete();
		$found_one = true;
	}
	
}

if (!isset($found_one))
	throw new Exception("Couldn't find created note");

