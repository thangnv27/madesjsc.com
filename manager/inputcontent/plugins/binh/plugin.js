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
CKEDITOR.plugins.add( 'binh', { 
  init: function( editor ) {
    editor.addCommand( 'insertCustomText', { 
      exec : function( editor ) {    
        if(CKEDITOR.env.ie) {
          editor.getSelection().unlock(true); 
          var selected_text = editor.getSelection().getNative().createRange().text; 
        } else { 
          var selected_text = editor.getSelection().getNative();
        }
        editor.insertHtml('[before]' + selected_text + '[after]'); 
      } 
    }); 
    editor.ui.addButton( 'binh', { 
      label: 'Insert [My Plugin]', 
      command: 'insertCustomText', 
      icon: this.path + 'icons/nav-add.png'
    } ); 
  } 
} );
} )();