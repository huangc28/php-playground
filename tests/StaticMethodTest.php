<?php

class SampleClass
{
	const SAMPLE = 0;

	protected $sample_arr = array(
		'one',
		'two'
	);

	public static function sampleContent()
	{
		return "content";
	}

	public function outputConst()
	{
		return self::SAMPLE;
	}

	public function contentProvider($name)
	{
		return $this->{"$name"."ContentProvider"}();
	}

	public function sampleContentProvider()
	{	
		return 'sample';
	}

	public function getSampleArr()
	{
		$this->sample_arr = array();

		return $this->sample_arr;
		// $unset = unset($this->sample_arr);

		// return $unset;
	}
}

class StaticMethodTest extends PHPUnit_Framework_TestCase
{

	public function testStaticMethodExists()
	{
		$sampleClass = new SampleClass;

		$this->assertTrue(method_exists($this, 'sampleStatic'));
	}

	public function testClassConstant()
	{
		$sampleClass = new SampleClass;

		// var_dump($sampleClass->outputConst());
	}

	public function testDynamicProvider()
	{			
		$sampleClass = new SampleClass;

		var_dump($sampleClass->contentProvider('sample'));
	}

	public function testGetSampleArr()
	{
		$sampleClass = new SampleClass;

		var_dump($sampleClass->getSampleArr());
	}

	protected static function sampleStatic()
	{
		return 'hello';
	}
}