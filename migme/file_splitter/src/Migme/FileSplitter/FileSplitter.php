<?php 
require_once(__DIR__."/../../../../../vendor/autoload.php");

use Symfony\Component\Filesystem\Filesystem;
use Intervention\Image\Image;

/**
 * Requirements:
 *
 * 1. only 16px emoticons
 * 2. filename equals to hotkey
 */
class FileSplitter
{
	protected static $size = 16;
	protected static $extPattern = array(
			'png'
		);

   /**
    * Path of the file to be parsed.
    *
    * @param string $path
    */
	protected $fromPath = null;

	/**
	 * @var Symfony\Component\Filesystem\Filesystem
	 */
	protected $filesystem;

	/**
	 * Construct.
	 *
	 * @param string $path
	 */
	public function __construct(Filesystem $filesystem)
	{	
		$this->filesystem = $filesystem;
	}

	/**
	 * Set the source the file folder
	 *
	 * @param string $path
	 */
	public function setSourcePath($path)
	{	
		$this->fromPath = $path;
		return $this;
	}

	public function getSourcePath()
	{
		return $this->fromPath;
	}

	/**
	 * Set targetPath.
	 *
	 * @param string $targetPath
	 */
	public function setTargetPath($targetPath)
	{	
		$this->targetPath = $targetPath;
		return $this;
	}

	public function getTargetPath()
	{
		return $this->targetPath;
	}

	/**
	 * Parse to target path.
	 *
	 * @param string $path Path to the target directory/file.
	 */
	public function parseTo($targetPath)
	{
		$this->setTargetPath($targetPath);

		if(!$this->filesystem->exists($this->getSourcePath())) 
		{
			throw new \Exception("Source path does not exist or it not specified");
		}

		if( $dh = opendir($this->getSourcePath()) )
		{
			while(($fileName = readdir($dh)) !== false)
			{
				// if specified path is a directory
				// then we recursivly parse the directory
				if($fileName !== '..' && $fileName !== '.')
				{
					$this->parse(
							$this->getSourcePath(), 
							$fileName
						);
				}
			}
		}
		closedir($dh);
	}

	/**
	 * Parse directory.
	 *
	 * @param string $filePath
	 * @param string $fileName
	 */
	protected function parse($filePath, $fileName)
	{
		// if file path is a directory, then we dive down recursivly
		if(is_dir($filePath.'/'.$fileName))
		{
			$dh = opendir($filePath.'/'.$fileName);
			while( ($fileName = readdir($dh)) !== false )
			{
				$this->parse(
					$filePath, 
					$fileName
				);
			}
			closedir($dh);
		}
		else
		{
			// if target director does not exist, create one.
			if( !$this->filesystem->exists($filePath) )
			{
				$this->filesystem->mkdir($this->getTargetPath(), $mode=0777);
			}

			$from = $filePath.'/'.$fileName;
			$to   = $this->getTargetPath().'/'.$fileName; 

			// we need to check for file extension before copy it
			if($this->imageValidator( $from ))
			{
				$this->filesystem->copy($from, $to);	
			}
			
		}
	}

	protected function imageValidator( $imgPath )
	{
		if( $this->matchMimeType($imgPath) )
		{
			return $this->matchSize($imgPath) ? true : false;
		}
		return false;
	}

	/**
	 * Match mime type.
	 *
	 * @param string $path
	 * @return boolean 
	 */
	protected function matchMimeType($path)
	{
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		return (in_array($ext, self::$extPattern)) ? true : false;
	}

	/**
	 *
	 *
	 * 
	 */
	protected function matchSize($path)
	{
		// var_dump(file_exists($path));
		var_dump(Image::make($path));
		die;
	}
}

// $sourcePath = __DIR__.""

$filesystem = new Filesystem;

// use dependencies
$fileSplitter = new FileSplitter($filesystem);

// source path has to be absolute path
$fileSplitter->setSourcePath(__DIR__."/../../sample")->parseTo(__DIR__."/../../sample2");
// $fileSplitter->parseTo()
