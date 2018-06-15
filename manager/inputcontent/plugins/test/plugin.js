/*
* Embed Media Dialog based on http://www.fluidbyte.net/embed-youtube-vimeo-etc-into-ckeditor
*
* Plugin name:      mediaembed
* Menu button name: MediaEmbed
*
* Youtube Editor Icon
* http://paulrobertlloyd.com/
*
* @author Fabian Vogelsteller [frozeman.de]
* @version 0.5
*/
( function() {
    CKEDITOR.plugins.add( 'test',
    {
       // icons: 'icon/mediaembed.png', // %REMOVE_LINE_CORE%
		icons:'tools',
        hidpi: true, // %REMOVE_LINE_CORE%
        init: function( editor )
        {
           var me = this;
           CKEDITOR.dialog.add( 'testDialog', function (instance)
           {
              return {
                 title : 'tool',
                 minWidth : 550,
                 minHeight : 200,
                 contents :
                       [
                          {
                             id : 'iframe',
                             expand : true,
                             elements :[{
                                id : 'embedArea',
                                type : 'file',
                                label : 'Paste Embed Code Here',
                                'autofocus':'autofocus',
                                setup: function(element){
                                },
                                commit: function(element){
                                }
                              }]
                          }
                       ],
                  onOk: function() {
                        var div = instance.document.createElement('div');
                        div.setHtml(this.getContentElement('iframe', 'embedArea').getValue());
                        instance.insertElement(div);
                  }
              };
           } );

            editor.addCommand( 'test', new CKEDITOR.dialogCommand( 'testDialog',
                { allowedContent: 'iframe[*]' }
            ) );

            editor.ui.addButton( 'test',
            {
				
                label: 'test',
                command: 'test',
                toolbar: 'test',
				icon: this.path + 'icons/tools.png'
            } );
        }
    } );
} )();
