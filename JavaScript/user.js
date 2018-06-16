$(document).ready(function() {

	$("#find").click(function() {
		$.ajax({
		   url: 'test.php',
		   success: function(data) {
		      $("#result").html(data);
		   },
		   type: 'GET'
		});
	});
	$("#nurse").click(function() {
		$.ajax({
		   url: 'test.php',
		   success: function(data) {
		      $("#result").html(data);
		   },
		   type: 'GET'
		});
	});

});