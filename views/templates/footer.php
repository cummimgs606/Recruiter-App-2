<!-- ------------------------------------------------------------------------------------------------ --> 
<!-- JAVA SCRIPT START -->     
<!-- ------------------------------------------------------------------------------------------------ -->     

<script src="javascripts/foundation-2.2/jquery.min.js"></script>
<script src="javascripts/foundation-2.2/jquery.reveal.js"></script>
<script src="javascripts/jquery.orbit-1.4.0-old.js"></script>
<script src="javascripts/hntv.js"></script>
<script src="javascripts/jquery.offcanvasmenu.js"></script>
<script src="javascripts/offcanvasmenuStart.js"></script>
<script src="javascripts/parsley.js"></script>
<script src="javascripts/nav-highlight.js"></script>
<script src="javascripts/jquery.svg.js"></script>



<script type="text/javascript">
     
    offCanvasStart(["push-menu-0","push-menu-1","push-menu-2"]);

    $('#CVName').on('change', function() {
         $('.form-upload').css('background-image', 'url(images/extra/upload-button-success.png)');
    });
     
    function windowOpen(url){
        window.open (url,'_self',false);
    };
    
    $(document).ready(function($){
        $('.push-menu').css('visibility','visible');
    });
    
    $(window).load(function() {
		$('#orbit-slider-1').orbit({
			directionalNav: false});
    });
	
	$('a[href^=#]').click(function(){
		event.preventDefault();
		var target = $(this).attr('href');
		console.log( target );
		if (target == '#')
		
			$('html, body').animate({scrollTop : 0}, 600);
		else
		  $('html, body').animate({
			scrollTop: $(target).offset().top - 0
		}, 600);
	});
	
	/*
	$(window).load(function() {
		
		$('.object-svg').each(function( index ) {
			
			var objectClass = $('.object-svg');
			var svgDocument = objectClass.get(index).contentDocument.rootElement;
			var svgHref		= $(this).parent().attr("href");
			
			console.log(svgDocument);
			
			svgDocument.addEventListener('click', function() { 
				var win 	= window.open(svgHref, '_blank');
					win.focus();
			});
		});
		
	}); 
	*/
</script>

<script src="javascripts/sticky-header.js"></script>
