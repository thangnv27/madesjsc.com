(function(){CKEDITOR.dialog.add('insertvideo',
	function(editor)
	{return{
		title:'Chèn video',
		minWidth:CKEDITOR.env.ie&&CKEDITOR.env.quirks?368:350,
		minHeight:240,
	onShow:function(){
		this.getContentElement('general','content').getInputElement().setValue('');
		this.getContentElement('general','icon').getInputElement().setValue('')
		this.getContentElement('general','width1').getInputElement().setValue('600');
		this.getContentElement('general','height1').getInputElement().setValue('400')
	},
	onOk:function(){
		       		var val = this.getContentElement('general','content').getInputElement().getValue();
					var icon = this.getContentElement('general','icon').getInputElement().getValue();
					var width1 = this.getContentElement('general','width1').getInputElement().getValue();
					var height1 = this.getContentElement('general','height1').getInputElement().getValue();
					
					
					
					if(width1<=0 || width1 =='') {
						width1=400;	
					}
					if(height1<=0 || height1 =='') {
						height1=400;	
					}
					var path ='';
					var codeyoutube = val.split("=");
					var urlyoutube = val.split(".");
					if(val[1] == 'youtube' || icon==''){
						icon = 'http://img.youtube.com/vi/' + codeyoutube[1] + '/0.jpg';
						this.getContentElement('general','icon').getInputElement().setValue(icon);
					}else{
						
					}
					var player = '<div id="mediaplayer1" style="width:'+width1+'px; height:' + height1 + 'px; border:solid #CCC 1px">&nbsp;</div><br />'
						+ '<script type="text/javascript" src="'+ path +'/manager/inputcontent/plugins/insertvideo/player/jwplayer.js"></script><script type="text/javascript">'
						+ 'jwplayer("mediaplayer1").setup({'
						+ 'flashplayer: "'+ path +'/manager/inputcontent/plugins/insertvideo/player/player.swf",'
						+ 'file: "'+ val +'",'
						+ 'image: "' + icon + '", height: '+ height1 +', width: '+width1
						+ '});'
						+ '</script>';
						
				
							this.getParentEditor().insertHtml(player)},
							contents:[{label:editor.lang.common.generalTab,id:'general',elements:
												[
												{
												type:'html',
												id:'pasteMsg',
												html:'<div style="white-space:normal;width:500px;">'
													+'Đường dẫn video'
													+'</div>'},
												{type:'hbox',
												widths:['280px','110px'],
												align:'right',
													children:[
													{
														id:'content',
														type:'html',
														label:editor.lang.common.url,
														style:'width:340px;height:90px;',
														html:'<input size="60" style="'+'border:1px solid black;'+'background:white">',
														focus:function(){this.getElement().focus()},
													},
													{
														type:'button',
														id:'browse',
														filebrowser:'general:content',
														hidden:true,
														style:'display:inline-block;margin-top:-5px;',
														label:editor.lang.common.browseServer
													}]},
												{
												type:'html',
												id:'icontext',
												html:'<div style="white-space:normal;width:500px;">'
													+'Hình ảnh đại diện'
													+'</div>'},
													{type:'hbox',
													widths:['280px','110px'],
													align:'right',
													children:[
													{
														id:'icon',
														type:'html',
														style:'width:340px;height:90px',																				
														html:'<input size="60" style="'+'border:1px solid black;'+'background:white">',
														//label:'Hình ảnh đại diện'
													},
													{
														type:'button',
														id:'browse2',
														filebrowser:'general:icon',
														hidden:true,
														style:'display:inline-block;margin-top:-5px;',
														label:editor.lang.common.browseServer
													}]},
													{
												type:'html',
												id:'widthtext',
												html:'Width'},
													{type:'hbox',
													widths:['280px','110px'],
													align:'right',
													children:[
													{
														id:'width1',
														type:'html',
														style:'width:340px;height:90px',																				
														html:'<input  style="'+'border:1px solid black;'+'background:white; width:100px">',
														//label:'Hình ảnh đại diện'
													}]},
													
												{
												type:'html',
												id:'heighttext',
												html:'Height'},
													{type:'hbox',
													widths:['280px','110px'],
													align:'right',
													children:[
													{
														id:'height1',
														type:'html',
														style:'width:340px;height:90px',																				
														html:'<input  style="'+'border:1px solid black;'+'background:white; width:100px;">',
														//label:'Hình ảnh đại diện'
													}]}
													
												     
												]}]}})})();

// {width:480, height:425}
// for jquery media: var text ='<a class="media" href="'
//for shadowbox use: var text ='<a rel="shadowbox" href="'