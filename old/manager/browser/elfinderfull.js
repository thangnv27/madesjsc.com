function include(script_filename) {
    document.write('<' + 'script');
    document.write(' language="javascript"');
    document.write(' type="text/javascript"');
    document.write(' src="' + script_filename + '">');
    document.write('</' + 'script' + '>');
}
 var pathfilejs ='browser/';
include(pathfilejs + 'js/elFinder.js');
include(pathfilejs + 'js/jquery.elfinder.js');
include(pathfilejs + 'js/elFinder.resources.js');
include(pathfilejs + 'js/elFinder.options.js');
include(pathfilejs + 'js/elFinder.history.js');
include(pathfilejs + 'js/elFinder.command.js');
include(pathfilejs + 'js/ui/overlay.js');
include(pathfilejs + 'js/ui/workzone.js');
include(pathfilejs + 'js/ui/navbar.js');
include(pathfilejs + 'js/ui/dialog.js');

include(pathfilejs + 'js/ui/tree.js');
include(pathfilejs + 'js/ui/cwd.js');
include(pathfilejs + 'js/ui/toolbar.js');
include(pathfilejs + 'js/ui/button.js');
include(pathfilejs + 'js/ui/uploadButton.js');
include(pathfilejs + 'js/ui/viewbutton.js');
include(pathfilejs + 'js/ui/searchbutton.js');
include(pathfilejs + 'js/ui/sortbutton.js');
include(pathfilejs + 'js/ui/panel.js');
include(pathfilejs + 'js/ui/contextmenu.js');
include(pathfilejs + 'js/ui/path.js');
include(pathfilejs + 'js/ui/stat.js');
include(pathfilejs + 'js/ui/places.js');
<!-- elfinder commands -->
include(pathfilejs + 'js/commands/reload.js');
include(pathfilejs + 'js/commands/up.js');
include(pathfilejs + 'js/commands/open.js');
include(pathfilejs + 'js/commands/getfile.js');
include(pathfilejs + 'js/commands/mkdir.js');
include(pathfilejs + 'js/commands/upload.js');
include(pathfilejs + 'js/commands/download.js');
include(pathfilejs + 'js/commands/rm.js');
include(pathfilejs + 'js/commands/quicklook.js');
include(pathfilejs + 'js/commands/quicklook.plugins.js');
include(pathfilejs + 'js/commands/search.js');
include(pathfilejs + 'js/commands/view.js');
include(pathfilejs + 'js/commands/resize.js');
include(pathfilejs + 'js/commands/duplicate.js');
include(pathfilejs + 'js/commands/info.js');
include(pathfilejs + 'js/commands/sort.js');

include(pathfilejs + 'js/commands/netmount.js');	
<!-- elfinder languages -->
include(pathfilejs + 'js/i18n/elfinder.vi.js');
<!-- elfinder dialog -->
include(pathfilejs + 'js/jquery.dialogelfinder.js');
<!-- elfinder 1.x connector API support -->
<!-- elfinder custom extenstions -->