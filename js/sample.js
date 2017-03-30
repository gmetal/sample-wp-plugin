jQuery(document).ready(function( $ ) {

	$('#click_btn').click(function(event) {
	
		$.get("/wordpress/index.php/wp-json/wp/v2/posts", null,
	    
				function(response) {
			
	                $.each(response, function(index, value) {
	                   	$("<tr><td>"+ index + "</td><td>" + value.title.rendered + "</td></tr>").appendTo('#my_tbl');
	                });
	            });
	});
	
	$('#hide_btn').click(function(event) {
		$('#my_tbl').hide();
	});
	
	$('#show_btn').click(function(event) {
		$('#my_tbl').show();
	});
	
});
