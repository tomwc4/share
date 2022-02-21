// Site General JS Document

function formatCurrency(num, dec) {
		var result = Math.round(num*Math.pow(10,dec))/Math.pow(10,dec);
		
		var result2 = result.toFixed(2);
			
		return result2;
	}
	

function enableButtons() { 
	
	/*
	 jQuery('#twitterBtn').click(function(){ 
		window.open("https://www.twitter.com/");
 	 });*/
	 
	 jQuery('#navMobileMenu').click(function(){ 
	 	if(jQuery("#nav-menu").css('display') == 'none' || jQuery("#nav-menu").css('display') == '') {
			jQuery("#nav-menu").stop().fadeIn(300);
		} else {
			jQuery("#nav-menu").stop().fadeOut(150);	
		} 
 	 });  

	jQuery('#nav-menu li').click(function(){ 
		if(jQuery("#nav-menu").css('display') == 'none' || jQuery("#nav-menu").css('display') == '') {
		   jQuery("#nav-menu").stop().fadeIn(300);
	   } else {
		   jQuery("#nav-menu").stop().fadeOut(150);	
	   }
	 });  
	
} 

function goTo(url, target) {
	if(target) {
		window.open(url);	
	} else {
		window.location.href = url;
	}
}

function toggleObj(objID) {
	
	var obj = document.getElementById(objID);
		
	if(obj.style.display == '' || obj.style.display == 'none') {
		jQuery(obj).stop().fadeIn(300);
	} else {
		jQuery(obj).stop().fadeOut(300);
	}
		
}

function initResizers() {
	
	 
  	// Resize Colorbox when resizing window or changing mobile device orientation
	jQuery(window).resize(resizeColorBox);
	jQuery(window).resize(resizeExperiences);
	window.addEventListener("orientationchange", resizeColorBox, false);
	window.addEventListener("orientationchange", resizeExperiences, false);  
	/* Colorbox resize function */
	var resizeTimer;
	function resizeColorBox() {
		if (resizeTimer){
			 clearTimeout(resizeTimer);
		}
		
		resizeTimer = setTimeout(function() {
				if (jQuery('#cboxOverlay').is(':visible')) {
						if(window.innerWidth < 450) {
							jQuery.colorbox.resize({width:'98%', height:'98%'});
						} else if(window.innerWidth < 1280) {
							jQuery.colorbox.resize({width:'80%', height:'90%'});
						} else {
							jQuery.colorbox.resize({width:'50%', height:'80%'}); 
						}
				}
		}, 300)
	}
	

	var resizeTimerEx;
	function resizeExperiences() {
		
		if (resizeTimerEx){
			 clearTimeout(resizeTimerEx);
		}
				
		resizeTimerEx = setTimeout(function() {
		  if(window.innerWidth > 767) {
			 jQuery("#mobile-nav").fadeOut(200);
			}

		}, 300)

		}
	
	jQuery(document).ready(function($) {	
		resizeExperiences();
	});
	

}

function smoothScroll() {
		//smooth anchor scroll
		jQuery("html, body").animate({ scrollTop: 0 }, 300);
		
		//auto smooth anchor scroll;
	
		  jQuery('a[href*=#]:not([href=#])').click(function() {
			if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
			  var target = jQuery(this.hash);
			  target = target.length ? target : jQuery('[name=' + this.hash.slice(1) +']');
			  if (target.length) {
				jQuery('html,body').animate({
				  scrollTop: target.offset().top
				}, 1000);
				return false;
			  }
			}
		  });

}



//sticky nav on scroll
function setNavScroll() {
    var pos = jQuery("#header").position();                   
    jQuery(window).scroll(function() {
		//if(window.innerWidth < 767) {
			var windowpos = jQuery(window).scrollTop();
			if (windowpos >= parseInt(pos.top)) {
				jQuery("#header").addClass("stick"); 
				jQuery("#content").addClass("stick");
			} else {
				jQuery("#header").removeClass("stick");
				jQuery("#content").removeClass("stick");
			}
			/*
		} else {
				jQuery("#header").removeClass("stick");
				jQuery("#content").removeClass("stick");
			}*/
    });
}


function parallaxBackground(element) {
	  var yPos = -(jQuery(window).scrollTop() / 8); 
	 // if(window.innerWidth > 650) {
		 var coords = '50% '+ yPos + 'px';
	 // } else {
		//  var coords = '50% 0';
	 // }
	  jQuery(element).css({ backgroundPosition: coords });
  }


function tagAnimation(item){
	
	const observer = new IntersectionObserver(entries => {
	
	entries.forEach(entry => {
		if (entry.isIntersecting) {
			item.addClass('animated');
			return;
		}
		item.removeClass('animated');
		});
	});

	observer.observe(item.parent().get(0));
}