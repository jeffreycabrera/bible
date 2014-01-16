$(document).ready(function() {
	$("#thumb").click(function() {
		$("#overlay").fadeIn("slow");
		$("#overlay_div").fadeIn("slow");
	});
		$("#close_button").click(function() {
		$("#overlay").fadeOut("fast");
		$("#overlay_div").fadeOut("fast");
	});
});