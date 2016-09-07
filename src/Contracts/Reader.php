<?php
namespace FileManager\Contracts;

interface Reader
{
	/**
	 * scan dir by the given dirPath
	 *
	 * @return	array	FileManage\Component\Document	
	 */
	public function scan();

	/**
	 * get the file content 
	 *
	 * @return	string	
	 */
	public function getContent();
}
