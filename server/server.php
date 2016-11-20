<?php
//No limit is imposed for maximum execution time
set_time_limit(0);
//set the path for fetching the data
$filePath='progress.txt';

while(true){
    
        //get the old file modification time from the querystring
	$oldTimestamp = isset( $_GET['timestamp'] ) ? (int)$_GET['timestamp'] : null;

        //clearstatcache() clears the information php caches about a file when using filemtime()
	clearstatcache();
        
        //get the most latest file modified time
	$fileModificationTimestamp = filemtime( $filePath );
        /*
         * $oldTimestamp contains the file modification
         * time sent with the earlier JSON response to client.js
         * 
         * $oldTimestamp is null when first request is made from client.js
         * 
         * Check if the progress.txt file is modified after the last JSON response was sent
         */
	if( $oldTimestamp == null || $fileModificationTimestamp > $oldTimestamp ){
                
                //fetch the file contents
                
		$fileContent = (file_get_contents( $filePath ));
                //create the PHP array of data to be sent
		$arrData = array('progress' => trim($fileContent), 'timestamp' => $fileModificationTimestamp );
		//prepare JSON response
                $response = json_encode($arrData);
		echo $response;
		exit;
	}
	else{
		sleep( 1 );
		continue;
	}
}
?>
