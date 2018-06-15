

<?php

defined('_VALID_NVB') or die('Direct Access to this location is not allowed.');



$idc = intval($_GET['idc']);

$id = intval($_GET['id']);



require_once('modules/db.provider/db.download.php');

$download = new dbDownload;





if ($_GET['code'] == 'download') {
    $dl = new Download($idc);

    $dl->act_download($id);
} else {

    $tpl = new TemplatePower($CONFIG['template_dir'] . "/download.htm");

    $tpl->prepare();





    $tpl->assignGlobal("dir_path", $dir_path);

    $tpl->assignGlobal("pathpage", Get_Main_Cat_Name_path($idc));

    $catinfo = Category::categoryInfo($idc);

    $tpl->assignGlobal("catname", $catinfo['name']);



    $dl = new Download($idc);

    $dl->list_download($idc);





    $tpl->printToScreen();
}

class Download {

    function list_download() {

        global $DB, $idc, $tpl, $download, $dir_path;

        $dl = $download->selectList($idc, 40);

        foreach ($dl as $rs) {

            if ($rs['id_download'] > 0) {

                $tpl->newBlock("listDownload");

                $tpl->assign(array(
                    name => $rs['name'],
                    intro => $rs['content'],
                    link_download => $rs['files'],
                    //link_download => $dir_path.'/index4.php?page=download&code=download&idc='.$rs['id_category'].'&id='.$rs['id_download'],
                    id => $rs['id_download']
                ));
            }
        }
    }

    function act_download($id) {

        global $DB, $download;

        $rs = $download->selectById($id);

        if ($rs['files'] == '' || empty($rs['files'])) {

            exit;
        }



        $filename = $rs['files']; //the file is 2 folder down. e.g. data/stack/bla.xlsx

        $file = $filename;

        $extension = end(explode('.', $filename));

        error_reporting(E_ALL);

        ini_set("display_errors", 1);

        //  echo $filename;
        //  echo "<br/>";
        //  echo $extension;
        //  echo filesize($filename);
        //  echo "<br/>";

        include('./lib/upload_definitions.php');

        $mimeType = $mime_type_match[$extension];

        //  echo $mimeType;

        header('Content-Description: File Transfer');

        header('Content-Type: ' . $mimeType);

        header('Content-Disposition: attachment; filename=' . basename($file));

        header('Content-Transfer-Encoding: binary');

        header('Expires: 0');

        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

        header('Pragma: public');

        header('Content-Length: ' . filesize($file));

        ob_clean();

        flush();

        readfile($filename);

        exit;
    }

}
?>