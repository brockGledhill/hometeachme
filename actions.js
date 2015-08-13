// JavaScript Document

function deletecomprow(compid){
	$.ajax({
     	 	url: 'removecompanionship.php',
      		type: 'post',
     	 	data: {'thecompid': compid},
      		success: function(data, status) {
		
				$("#fullcomprow" + compid).remove();
				$(".comprow:odd").css("background-color", "#f4f4f4");
      		},
		}); // end ajax call
}