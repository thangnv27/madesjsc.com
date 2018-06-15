// JavaScript Document



function check_all(obj){

	var ch = $("." + $(obj).attr('data-check'));

	if($(obj).is(':checked')){

		 ch.attr('checked',true);

	}else{

		 ch.attr('checked',false);			 

	}

};



function check_null(){

	var ok=true;

	$('.spanalert').remove();

	$('.notNull').each(function(){

		if($(this).val()==''){

			$('<br><span class="spanalert">' + $(this).attr('data-alert') + '</span>').insertAfter($(this)); 

			ok=false;

		}		

	});

	return ok;

}

$(function(){

if($('#autourl').is(':checked'))	{

		$('#url').attr('disabled',true);	

	}else{

		$('#url').attr('disabled',false);		

	}

	// change auto url

	$('#autourl').change(function(){

		if($(this).is(':checked'))	{

			$('#url').attr('disabled',true);	

		}else{

			$('#url').attr('disabled',false);		

		}

	});

});

$(function(){

	$('#choose_datatype input').change(function(){

		action_select_type($(this).val());

		var mes = '<select name="parentid" style="WIDTH: 300px" ><option value="0">Đang tải...</option></select>';

		$("#cls_category").html(mes);

		$("#cls_category").load('index4.php?page=action_ajax&code=loadcommbo&data_type='+$(this).val()+'&lang=' + lang, function(response, status, xhr) {

		  if (status == "error") {

		    var msg = "Sorry but there was an error: ";

		    alert(msg + xhr.status + " " + xhr.statusText);

		  }

		});

	});

	

	

});



//show message

	function show_mes($msg){

		$.blockUI({ 

            message: $msg, 

            fadeIn: 700, 

            fadeOut: 700, 

            timeout: 2000, 

            showOverlay: false, 

            centerY: false, 

            css: { 

                width: '350px', 

                top: '60px', 

                left: '', 

                right: '10px', 

                border: 'none', 

                padding: '5px', 

                backgroundColor: '#000', 

                '-webkit-border-radius': '10px', 

                '-moz-border-radius': '10px', 

                opacity: .6, 

                color: '#fff' 

            } 

        }); 	

	}

	

$().ready(function() {

	$('#browserimage').click(function() {

		var fm = $('<div/>').dialogelfinder({

			url : 'browser/php/connector.php',

			lang : 'vi',

			width : 840,

			destroyOnClose : true,

			getFileCallback : function(files, fm) {

				$('#imageurl').attr('value',files.url);

				$('#pic_avatar').html('<img src="image.php?w=150&src=' +  files.url + '" class="img-polaroid marginright5" align="left" id="avatar" />');

			},			

			commandsOptions : {

				getfile : {

					oncomplete : 'close',

					folders : true

				}

			}

		}).dialogelfinder('instance');

	});

$('#browserimage360').click(function() {

		var fm = $('<div/>').dialogelfinder({

			url : 'browser/php/connector.php',

			lang : 'vi',

			width : 840,

			destroyOnClose : true,

			getFileCallback : function(files, fm) {

				$('#imageurl360').attr('value',files.url);

				

			},			

			commandsOptions : {

				getfile : {

					oncomplete : 'close',

					folders : true

				}

			}

		}).dialogelfinder('instance');

	});

	$('#browserfile').click(function() {

		var fm = $('<div/>').dialogelfinder({

			url : 'browser/php/connector.php',

			lang : 'vi',

			width : 840,

			destroyOnClose : true,

			getFileCallback : function(files, fm) {

				console.log(files);

				$('#fileurl').attr('value',files.url);

			

			},			

			commandsOptions : {

				getfile : {

					oncomplete : 'close',

					folders : true

				}

			}

		}).dialogelfinder('instance');

	});



	$('#videobrowse').click(function() {

		var fm = $('<div/>').dialogelfinder({

			url : 'browser/php/connector.php',

			lang : 'vi',

			width : 840,

			destroyOnClose : true,

			getFileCallback : function(files, fm) {

				console.log(files);

				$('#videourl').attr('value',files.url);

				

			},			

			commandsOptions : {

				getfile : {

					oncomplete : 'close',

					folders : true

				}

			}

		}).dialogelfinder('instance');

	});

});



function removeFile(obj){

		obj.parent().remove();

}







function dropdownList(obj){

	$(obj).click(function(){

		$('ul',this).slideToggle();

		

	});

	

}