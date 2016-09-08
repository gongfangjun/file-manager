<?php
namespace FileManager\Contracts;

interface Writer
{
	/**
	 * write content to file 
	 *
	 * @param	string	
	 * @return	int	
	 */
	public function write($content);

	/**
	 * create a file 
	 *
	 * @param	string	$path		relative to the path of the current object,such as: abc.txt, inc/abc.data, and so on
	 * @param	string	$content
	 * @return	FileManage\Component\Document
	 */
	public function createFile($path, $content = null);

	/**
	 * create a dir
	 *
	 * @param	string	$path	relative to the path of the current object,such as: js,js/inc and so on
	 * @return	FileManage\Component\Document
	 */
	public function createDir($path);
}
