<?php
namespace FileManager\Driver;

use FileManager\Contracts\Reader;
use FileManager\Component\Document;

class File extends Document implements Reader 
{
	public function __construct($path)
	{
		$path = realpath($path);
		parent::__construct($path);
	}

	/**
	 * scan the path
	 *
     * @return	array	FileManager\Component\Document
	 */
	public function scan()
	{
		//if is file
		if ($this->isFile) return [$this];

		//if is dir
		$docArr = scandir($this->path);
		$data = [];
		foreach ($docArr as $doc) {
			if ($doc == '.' || $doc == '..') continue;

			$data[] = new File($this->path . '/' . $doc);
		}

		return $data;
	}

	/**
	 * get the file content 
	 *
     * @return	string	
	 */
	public function getContent()
	{
		return $this->isFile ? file_get_contents($this->path) : NULL;
	}

}
