// JavaScript Document

function deletecomprow(compid){
	$.ajax({
     	 	url: 'removecompanionship.php',
      		type: 'post',
     	 	data: {'thecompid': compid},
      		success: function(data, status) {
		
				$("#fullcomprow" + compid).remove();
      		},
		}); // end ajax call
}