$(function(){
	
	
	var menubarfix = $('#menubarfix').position();
	var menubar = $('#menubar').position();
	$(window).scroll(function (event) {
		if ($(this).scrollTop() > (menubar.top + 60)) {
			$('#menubarfix').css( { 'position' : 'fixed', 'top' : '0px','z-index' : '9999999' } );
			$('#menubarfix').fadeIn();
		}else{
			$('#menubarfix').css( { 'position' : '', 'top' : '' } );
			$('#menubarfix').fadeOut();
		} 
	}); 
	
	
	$('#nav li').hover(function(){
		$('ul',this).stop().slideDown(200);
	},function(){
		$('ul',this).stop().slideUp(100);	
	});
	
	$("#button-btt").click(function() {
	  $("html, body").animate({ scrollTop: 0 }, "slow");
	  return false;
	});
	
	$('.tab-detail-pro a.pro_tab_detail1').click(function(){
		$('html, body').animate({
			scrollTop: $('#pro_tab_detail1').offset().top -50
		}, 1000);
		return false;
	});

	$('.tab-detail-pro a.pro_tab_detail2').click(function(){
		$('html, body').animate({
			scrollTop: $('#pro_tab_detail2').offset().top -50
		}, 1000);
		return false;
	});
	
	$('.menuright li').hover(function(){
		$('a',this).stop().animate({
			paddingLeft:'11px'
		},100);
		$('ul',this).stop().show();
		
	},function(){
		$('a',this).stop().animate({
			paddingLeft:'15px'
		},100);
		$('ul',this).stop().hide();
	});
	
	$('.btn-check-out').hover(function(){
		$(this).animate({ width: '100px' }, 300);
	},function(){
		$(this).animate({ width: '46px' }, 300);	
	});
	
	$('.col-1-4').hover(function(){
		$('.image-pro-cell',this).addClass('image-pro-cell-active');
		$('.view-now',this).stop().fadeIn(400);
	},function(){
		$('.image-pro-cell',this).removeClass('image-pro-cell-active');
		$('.view-now',this).stop().fadeOut(100);
	});
	
	$('.main-menu-drop').hover(function(){
		$('ul',this).stop().slideDown(200);
	},function(){
		$('ul',this).stop().slideUp(100);	
	});
	
	$(window).scroll(function (event) {
		if ($(this).scrollTop() > 10) {
			$('#button-btt').fadeIn(); 
		} else { 
			$('#button-btt').fadeOut(); 
		}
	});
	$('#mobile_nav_icon').click(function(e){
		jQuery('#container').bind('touchmove', function(e){e.preventDefault()});
		 jQuery('#contentLayer').css('display', 'block');
		jQuery("#container").animate({"margin-left": "70%"}, {
            duration: 700
        });
		e.stopPropagation();
	});
	$(document).click(function() {
		jQuery('#container').unbind('touchmove');
		jQuery("#container").animate({"margin-left": "0"}, {
            duration: 700,
			complete: function() {
                jQuery('#contentLayer').css('display', 'none');
            }
        });
		
		
	});
	
	if($(window).width()<=900){
		var rel = "useWrapper: false, showTitle: false, zoomWidth:'100%', zoomHeight:'100%', adjustY:3, adjustX:3";
		$('.cloud-zoom').attr('rel',rel + ",position: 'inside'");
	}else{
	
		var rel = "useWrapper: false, showTitle: false, zoomWidth:'415', zoomHeight:'400', adjustY:0, adjustX:10";
		$('.cloud-zoom').attr('rel',rel);
	}
	$(window).resize(function(){
	
		if($(window).width()<=900){
			var rel = "useWrapper: false, showTitle: false, zoomWidth:'415', zoomHeight:'400', adjustY:3, adjustX:3";
			$('.cloud-zoom').attr('rel',rel + ",position: 'inside'");
		}
	});
	
	$('.hd-mua-hang-top').hover(function(){
		$('.drop',this).stop().slideDown(200);
	},function(){
		$('.drop',this).stop().hide();	
	});
});

