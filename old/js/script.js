// JavaScript Document
$(function(){
	$('#nav li').hover(function(){
		$(this).addClass('active');
	},function(){
		$(this).removeClass('active');
	});
	
	$('.tabdetail li').click(function(){
		$('.contentTab').hide();
		$('.tabdetail li').removeClass('active');
		$(this).addClass('active');
		$($(this).attr('rel')).fadeIn();
	});
});