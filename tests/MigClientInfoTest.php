<?php

/**
 *	'client'           => $client
 *  'client_version'   => $full_ua
 *	'version'          => $version
 *	'client_build_str' => $matches[2]
 *	'client_build'     => $build_num
 */
class ClientInfo
{
	protected static $clientInfo = array();

	/**
	 * @param string $header
	 */
	public function get_client_info($header)
	{
		// J2ME series of header 
		// if(preg_match('', $header))
		// {

		// }

		// var_dump($header);
		// die;
	}
}

class MigClientInfoTest extends PHPUnit_Framework_TestCase
{
	const J2ME_HEADER_ONE = 0;
	const J2ME_HEADER_TWO = 1;
	const MIG_HEADER_ONE = 2;
	const MIG_HEADER_TWO = 3;
	const MIG_HEADER_THREE = 4;

	/**
	 * Header pattern for testing
	 *
	 * @var array
	 */
	protected $headers = array(
		self::J2ME_HEADER_ONE => 'J2MEv4.20.291 testerfriend035 Tunnel/60.251.3.181',
		self::J2ME_HEADER_TWO => 'J2MEv5.0.1 testerfriend035 Tunnel/60.251.3.181',
		self::MIG_HEADER_ONE => 'mig33/5.0 (unknown) KBrowser UNTRUSTED/1.0',
		self::MIG_HEADER_TWO => 'migme/5.0 (unknown) KBrowser UNTRUSTED/1.0',
		self::MIG_HEADER_THREE => 'mig33/android/5.0.1' 
	);

	public function test_get_client_info_with_mig_header_one()
	{
		$client_info = new ClientInfo;

		$client_info_arr = $client_info->get_client_info($this->headers[self::MIG_HEADER_ONE]);
	}

	public function test_get_cleint_info_with_mig_header_two()
	{	
		$client_info = new ClientInfo;

		$client_info_arr = $client_info->get_client_info($this->headers[self::MIG_HEADER_TWO]);
	}

	public function test_j2me_series_pattern()
	{

		$this->assertTrue( !!preg_match('/(J2ME)v([0-9.]+)/', $this->headers[self::J2ME_HEADER_ONE]) );

		$this->assertTrue( !!preg_match('/(J2ME)v([0-9.]+)/'), $this->headers[self::J2ME_HEADER_ONE] );

	}

	/**
	 * mig33/5.0 (unknown) KBrowser UNTRUSTED/1.0 
	 *
	 * $match format:
	 * [
	 * 	 0 => "mig33/5.0"
	 *   1 => "mig33"
	 *   2 => "5.0" 
	 * ]
	 */
	public function test_mig33_j2me_header_pattern()
	{
		$header = $this->headers[self::MIG_HEADER_ONE];

		// var_dump($header);
		// die; 
		if(preg_match('/(mig33|migme)\/([\d\.]+)/', $header, $matches))
		{
			// var_dump('ddd');
			var_dump($matches);
		}
	}

	/**
	 * mig33/android/5.0.1
	 *
	 * $match format:
	 *
	 * [
	 * 	  '0' => mig33/android/5.0.1',
	 *    '1' => 'mig33',
	 * 	  '2' => 'android',
	 *    '3' => 5.0.1
	 * ]
	 */
	public function test_mig33_android_header_pattern()
	{
		$header = $this->headers[self::MIG_HEADER_THREE];

		var_dump($header);
		die;
		if(preg_match('/mig33|migme\/(android|blackberry|mre|ios)\/([\d\.]+)/', $header, $matches))
		{
			var_dump($matches);
			die;
			// var_dump('ddd');
			// var_dump($matches);
		}
	}

	/**
	 * J2MEv4.20.291 testerfriend035 Tunnel/60.251.3.181
	 *
	 * $match format:
	 * [
	 * 	 0 => "J2MEv4.20.291",
	 *   1 => "J2ME",
	 *   2 => "4.20.291"
	 * ]
	 */
	public function test_old_header_parser_on_j2me_one_header()
	{

		// var_dump(self::J2ME_HEADER_ONE);
		// die;
		$j2me_type_one_header = $this->headers[self::J2ME_HEADER_ONE];

		var_dump($j2me_type_one_header);
		die;

		if(preg_match('/^(J2ME)v([0-9.]+)/', $j2me_type_one_header, $matches))
		{

			var_dump($matches);
			die;
			$full_ua = $matches[0];
			$client = strtolower($matches[1]);
			$version = $matches[2];
			// list($version, $build_num) = self::derive_client_build_and_version($version, $client, $full_ua);
			// settype($version, 'float');

			// $client_info = array(
			// 					  'client'           => $client
			// 					, 'client_version'   => $full_ua
			// 					, 'version'          => $version
			// 					, 'client_build_str' => $matches[2]
			// 					, 'client_build'     => $build_num
			// 				);
			// var_dump($client_info);
		}
	}
}