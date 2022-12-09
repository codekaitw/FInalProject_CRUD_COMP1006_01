<?php

class ErrorHandle
{
	// error handle
	public function customErrorHandle(
		$errorNo, $errorMessage, $errorFile, $errorLine){
		echo "<p>Error Message: [$errorNo] $errorMessage</p>";
		echo "<p>Error on line: $errorLine in $errorFile</p>";
	}

	// fatal(runtime) error handle
	public function fatalErrorHandle(){
		// fatal(runtime) error handle
		ini_set('display_errors', 1);
		error_reporting(E_ALL & ~E_NOTICE);
		// error_log can write error in log file. In this case, don't have Permission(failed to open stream: Permission denied in)
		// error_log("Error Message", 3 "file_with_errors.log");
	}
}