/*quick search*/
$(document).ready( function() {
			$("#result").hide();

$("#key").keyup( function(event){
	var key = $("#key").val();

	if( key != 0){
		$.ajax({
		type: "GET",
		data: ({key: key}),
		url:"search.php",
		success: function(response) {
		$("#result").slideDown().html(response); 
		}
		})
		
		}else{
		
		$("#result").slideUp( function() {
		$("#result").val("");
	});
		}
 }) 

 
});
		
 