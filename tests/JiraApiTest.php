<?php
require __DIR__."/../vendor/autoload.php";

use chobie\Jira\Api;
use chobie\Jira\Api\Authentication\Basic;
use chobie\Jira\Issues\Walker;
use Jira\JiraClient;

class JiraApiTest extends PHPUnit_Framework_TestCase
{
	const API_ENDPOINT = "mig-me.atlassian.net";

	public function test_init_chobie()
	{
		$jira_auth = new Basic(
			"bryan.ch.h@mig.me",
			"Huang_0216"
		);

		$api = new Api(
			self::API_ENDPOINT,
			$jira_auth
		);

		
		var_dump($api);
		die;
	}

	/**
	 * Test retrieving Jira api token. Retrieve single task. 		
	 */
	public function test_init_cpliakas()
	{	
		$host = 'http://mig-me.atlassian.net';
		$username = 'bryan.ch.h';
		$password = 'Huang_0216';

		$jira = new JiraClient($host);
		$token = $jira->login($username, $password);
		$issues = $jira->issue("IG-177")->get();

		// var_dump($issues);

		// var_dump($issues);
		// var_dump($jira);
		die;
	}
}