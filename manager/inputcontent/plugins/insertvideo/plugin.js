(function(){
	var wmplayerCmd={
		exec:function(editor){editor.openDialog('insertvideo');
		return;
	}
};
CKEDITOR.plugins.add('insertvideo',
	{
		lang:['vn','en'],requires:['dialog'],
		requires:['dialog'],
		init:function(editor){
			var commandName='insertvideo';editor.addCommand(commandName,wmplayerCmd);
			editor.ui.addButton('insertvideo',{
				label:editor.lang.insertvideo.button,
				command:commandName,
				icon:this.path+"icons/mediaembed.png"
			});
			CKEDITOR.dialog.add(commandName,CKEDITOR.getUrl(this.path+'insertvideo.js'))
		}
	})
	})();
