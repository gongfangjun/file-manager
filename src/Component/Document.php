<?php
namespace FileManager\Component;

class Document
{
	public $path;
	public $isFile;
	public $isDir;
	public $isReadable;
	public $isWritable;
	public $lastVisitTime;
	public $lastModTime;
	public $filesize;
	public $extName;

	public function __construct($path)
	{	
		$this->path = $path;
		$this->setBaseInfo();
	}

	/**
	 * delete the doc, no matter whether it is a file or dir
	 *  
	 * @return	bool
	 */
	public function del()
	{
		if ($this->isDir) {
			$dirDocArr = $this->scan();
			foreach ($dirDocArr as $doc) {
				$doc->del();
			}
			return rmdir($this->path);
		} else {
			return unlink($this->path);
		}
	}


	/**
	 * set the base info of the document
	 */
	private function setBaseInfo()
	{
		$this->isFile = is_file($this->path);
		$this->isDir = !($this->isFile);
		$this->isReadable = is_readable($this->path);
		$this->isWritable = is_writable($this->path);
		if ($this->isFile) {
			$this->lastModTime = filemtime($this->path);
			$this->lastVisitTime = fileatime($this->path);
			$this->filesize = filesize($this->path);
			$tmpExtNameData = explode('/', $this->path);
			$tmpExtNameData = explode('.', array_pop($tmpExtNameData));
			$this->extName = count($tmpExtNameData) > 1 ? array_pop($tmpExtNameData) : '';  
		}
	}

}
