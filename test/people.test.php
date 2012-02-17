<?php
require_once("../lib/HighriseAPI.class.php");

if (count($argv) != 3)
	die("Usage: php people.test.php [account-name] [access-token]\n");


$highrise = new HighriseAPI();
$highrise->debug = false;
$highrise->setAccount($argv[1]);
$highrise->setToken($argv[2]);

$customFields = $highrise->findAllCustomfields();
$customField = $customFields['New Label'];

$people = $highrise->findPeopleBySearchTerm("Personality Changer");
foreach($people as $p)
	$p->delete();


$person = new HighrisePerson($highrise);
$person->setFirstName("Personality");
$person->setLastName("Changer");
$person->addEmailAddress("personalityc@gmail.com");
$person->save();


$person->addCustomfield($customField, 'Totally set');
$person->save();

print "Person CUSTOM FIELDS are: \n";
$fields = $person->getCustomFields();
foreach ($fields as $field)
{
    print_r($field);
    # print $note->toXML();
}


print "Person ID is: " . $person->getId() . "\n";
$person->addEmailAddress("personalitychanger@hotmail.com");
$person->save();
print "Person ID after save is: " . $person->getId() . "\n";
print_r($person);

$people = $highrise->findPeopleBySearchTerm("Personality Changer");
print_r($people);

$person->delete();
