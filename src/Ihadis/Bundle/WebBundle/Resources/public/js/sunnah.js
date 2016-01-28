
   $(document).ready(function () { 
       
    
	$(window).scroll(function() {
		if ($(window).scrollTop() > 750) $("#back-to-top").addClass('bttenabled');
		else $("#back-to-top").removeClass('bttenabled');

		if ($(window).scrollTop() > 25) { // this number is height of short banner + breadcrumbs - 40
 
			
            $(".fl").css({'margin-top': '60px'});
			$("#header").css('position', 'fixed');
            
            
		}
		else {
            $(".fl").css({'margin-top': '43px'});
			$("#header").css('position', 'relative');
			
            
		}
	});
    

  });

	