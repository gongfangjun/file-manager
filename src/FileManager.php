<?php
namespace FileManager;

class FileManager
{
	protected $handler;

	public function __construct($path)
	{
		$engine = '\FileManager\Driver\\' . $this->getEngine($path);
		$this->handler = new $engine($path);
	}

	/**
	 * choose the file engine through the path
	 *
	 * @param	string	$path
	 * @return	string 
	 */
	private function getEngine($path)
	{
		if (file_exists($path)) {
			return 'File';
		} else {
			throw new \Exception('unsupport protocol or file not exists');
		}
	}

	public function __call($method, $args)
	{
		//if the method exists in the file engine, then use it
		if (method_exists($this->handler, $method)) {
			return call_user_func_array([$this->handler, $method], $args);
		} else {
			throw new \Exception('method not exists: ' . $method);
		}
	}
}
