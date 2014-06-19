
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5073346f51b846f2"></script>
<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script> 
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="http://code.jquery.com/jquery.js"></script>
<script src="js/bootstrap.min.js"></script> 
<script type="text/javascript" src="../plugins/tinymce/tinymce.min.js"></script>

<script>
		$(document).ready(function() {
			// Show or hide the sticky footer button
			$(window).scroll(function() {
				if ($(this).scrollTop() > 200) {
					$('.btn_top').fadeIn(200);
				} else {
					$('.btn_top').fadeOut(200);
				}
			});
			
			// Animate the scroll to top
			$('.btn_top').click(function(event) {
				event.preventDefault();
				
				$('html, body').animate({scrollTop: 0}, 300);
			})
		});
</script>

<script type="text/javascript" charset="utf-8">

	function askdelete(postID){
		var postDelete = confirm ('You really want to delete this post?');
		if (postDelete){
			window.location.href = 'delete.php?id='+postID;
		}
		return;
	}
	$('#myTab a').click(function (e) {
  e.preventDefault();
  $(this).tab('show');
})
</script>
	
<script type="text/javascript">

	tinymce.init({
    	selector: "textarea",
		plugins: "jbimages",
		relative_urls: true
	});
	
</script>