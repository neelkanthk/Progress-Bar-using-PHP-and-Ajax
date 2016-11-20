$(document).ready(function() {
    sendAJAX();
});
/*
 * Sends AJAX request and shows the server response on webpage
 * @timestamp the file modified timestamp sent by the server,  null in case of first request
 * 
 */
function sendAJAX(timestamp) {
    
    //prepare the query string to send the timestamp with the AJAX request
    
    var queryString = {'timestamp': timestamp};

    //Prepare AJAX call
    jQuery.ajax({
        type: 'GET',
        url: '/progressbar/server/server.php',
        data: queryString,
        success: function(data) {
            
            //convert json string to javascript
            var obj = jQuery.parseJSON(data);
            
           
            //change the width of progress bar
            $('.progress-bar').attr("style","width:"+obj.progress);
            //show the proress complete stat
	    $('.progress-bar #complete-info').html(obj.progress);	
            $('.progress-bar').attr("aria-valuenow",obj.progress);
	    
	    if(obj.progress=="100%")
	    {
		//Perform action on completion
	    	$('#status').html("Process Completed.");
	    }
            //poll the server again with the file stamp sent by server            
            sendAJAX(obj.timestamp);
        },
        error: function(data) {
            
        }
    });
}
