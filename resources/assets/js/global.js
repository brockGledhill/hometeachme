$(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		}
	});
});

function deletecomprow(compid) {
	$.ajax({
		url: '/companionships/delete?id=' + compid,
		type: 'post',
		data: {'thecompid': compid},
		success: function(data, status) {
			$("#fullcomprow" + compid).slideUp();
		},
	}); // end ajax call
}