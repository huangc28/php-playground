<?php
class EmailRegexTest extends PHPUnit_Framework_TestCase
{
	public function test_email_regex()
	{
		$email_regex = '/^[a-z0-9_\+-]+(\.[a-z0-9_\+-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*\.([a-z]{2,4})$/';
		$email = 'Jasonhuang12@gmail.com';
		$lower_email = strtolower($email);
		$this->assertTrue(preg_match($email_regex, $lower_email));
	}

}