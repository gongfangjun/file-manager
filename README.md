# file-manager
A  file/dir manager for php


## install
add a line to the "require" section in your composer.json,then run the command: composer update

    {
		"require":{
			"gongfangjun/file-manager": "*"
		}
	}


## how to use it in your project

	include './vendor/autoload.php';

	use FileManager\FileManager;

	//scan sub docs in the dir
	$fm = new FileManager('/data/upload/');
	foreach ($fm->scan() as $doc) {
    	echo $doc->path,"\n";
	}

	//scan all the docs in the dir 
	function scan($path) {
    	$fm = new FileManager($path);
    	foreach ($fm->scan() as $doc) {
    	    if ($doc->isDir) {
    	        echo $doc->path,"\n";
    	        scan($doc->path);
    	    } else {
    	        echo $doc->path,"\n";
    	        echo "   |- file size : ", $doc->filesize,"\n";
    	        echo "   |- last visit time : ", date('Y-m-d H:i:s', $doc->lastVisitTime),"\n";
    	        echo "   `- last modify time : ", date('Y-m-d H:i:s', $doc->lastModTime),"\n";
    	    }   
    	}   
	}

	scan('/data/upload/');

	//delete a file
	$fm = new FileManager('/data/upload/js/inc/bootstrap.js');
	$fm->del();

	//delete a dir
	$fm = new FileManager('/data/upload/js/inc/');
	$fm->del();
