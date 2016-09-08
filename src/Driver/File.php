<?php
namespace FileManager\Driver;

use FileManager\Contracts\Reader;
use FileManager\Contracts\Writer;
use FileManager\Component\Document;

class File extends Document implements Reader,Writer 
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

    /** 
     * write content to file 
     *
     * @param   string  
     * @return  int 
     */
    public function write($content = '')
	{
		return $this->isFile ? file_put_contents($this->path, $content) : FALSE;
	}

    /** 
     * create a file 
     *
     * @param   string  $path   relative to the path of the current object,such as: abc.txt, inc/abc.data, and so on
     * @return  FileManage\Component\Document
     */
    public function createFile($path, $content = null)
	{
		$file = $this->path . '/' . $path;

		//if file exists
		if (file_exists($file)) {
			if ($content === null) {
				return new File($file);
			} else {
				return file_put_contents($file, $content) >= 0 ? (new File($file)) : null;
			}
		}

		//if file not exists, we create it
		if ($this->createDir(dirname($path)) === null) return null;
		return file_put_contents($file, ($content === null ? '' : $content)) >= 0 ? new File($file) : null;
	}

    /** 
     * create a dir
     *
     * @param   string  $path   relative to the path of the current object,such as: js,js/inc and so on
     * @return  FileManage\Component\Document
     */
    public function createDir($path)
	{
		$dir = $this->path . '/' . $path;
		if (!is_dir($dir)) {
			if (mkdir($dir, 0755, true) == false) return null;
		}

		return new File(realpath($dir));
	}
}
