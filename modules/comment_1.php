<?php

defined('_VALID_NVB') or die('Direct Access to this location is not allowed.');

$table_name = 'product';
$id_item_name = 'id_product';

function getComments($id, $table_name = 'product', $id_item_name = 'id_product') {
    global $DB, $dir_path, $cache_image_path, $CONFIG;
    //$tpl1 = new TemplatePower("plugins/comment/comment.htm");
    $tpl1 = new TemplatePower($CONFIG['template_dir'] . "/comment.htm");
    $tpl1->prepare();
    $id = intval($id);
    $idc = intval($_GET['idc']);
    $tpl1->assignGlobal("dir_path", $dir_path);

    $tpl1->assignGlobal("table_name", $table_name);
    $tpl1->assignGlobal("id_item_name", $id_item_name);
    $tpl1->assignGlobal($id_item_name, $id);

    $tpl1->newBlock("show_comment");

    $sql = "SELECT * FROM comments WHERE active=1 AND table_name = '$table_name' AND id_item='$id_item_name' AND id_value=$id AND (parentid is null OR parentid = '' OR parentid = 0) ORDER BY createdate DESC ";
    $db = $DB->query($sql);
    $tpl1->assignGlobal("number_comment", mysql_num_rows($db));
    while ($rs = mysql_fetch_array($db)) {
        $tpl1->newBlock("lstComment");
        $tpl1->assign("name", $rs['name']);
        $tpl1->assign("comment", $rs['comment']);
        $tpl1->assign("id_comment", $rs['id_comment']);
        $tpl1->assign("like", intval($rs['user_like']));
        //$tpl1->assign("createdate", date('d/m/Y - H:i', $rs['createdate']));
        $tpl1->assign("createdate", showDays($rs['createdate']));
        
        $sql = "SELECT * FROM comments WHERE active=1 AND parentid= $rs[id_comment] ORDER BY createdate ASC ";
        $db_sub = $DB->query($sql);
        while ($rs_sub = mysql_fetch_array($db_sub)) {
            $tpl1->newBlock("lstSubComment");
            $tpl1->assign("sub_id_comment", $rs_sub['id_comment']);
            $tpl1->assign("sub_name", $rs_sub['name']);
            $tpl1->assign("sub_comment", $rs_sub['comment']);
            $tpl1->assign("sub_like", intval($rs_sub['user_like']));
            //$tpl1->assign("sub_createdate", date('d/m/Y - H:i', $rs_sub['createdate']));
            $tpl1->assign("sub_createdate", showDays($rs_sub['createdate']));
            if (intval($rs_sub['id_admin']) > 0){
                $tpl1->assign("isadmin", "isadmin");
                $db_user = $DB->query("SELECT * FROM users WHERE id_users = $rs_sub[id_admin]");
                if ($rs_user = mysql_fetch_array($db_user)){
                    if ($rs_user['image']) 
                        $tpl1->assign("avatar", '<img  src="' . $cache_image_path . cropimage(40, 40, $dir_path . '/' . $rs_user['image']) . '" alt="' . $rs_user['name'] . '" width="100%"/>');
                
                }
                
            }
        }
    }

    return $tpl1->getOutputContent();
}

function showDays($createdate) {
    global $CONFIG;
    $strReturn = "";
    $now = time() + $CONFIG['time_offset'];
    $datediff = $now - $createdate;
    
    if ($datediff > (60 * 60 * 24 * 30 * 12)){
        $days = floor($datediff / (60 * 60 * 24 * 30 * 12));
        $strReturn = "$days năm trước";
    }elseif ($datediff > (60 * 60 * 24 * 30)) {
        $days = floor($datediff / (60 * 60 * 24 * 30));
        $strReturn = "$days tháng trước";
    }elseif ($datediff > (60 * 60 * 24)) {
        $days = floor($datediff / (60 * 60 * 24));
        $strReturn = "$days ngày trước";
    }elseif ($datediff > (60 * 60)) {
        $days = floor($datediff / (60 * 60));
        $strReturn = "$days giờ trước";
    }else{
        $days = ceil($datediff / (60));
        $strReturn = "$days phút trước";
    }
    return $strReturn;
    //return $now . '---' . $createdate;
    
    
}

if ($_GET['v'] == 1) {
    $idcomment = intval($_GET['idcomment']);
    $sql = "UPDATE comments SET user_like = user_like+1 WHERE id_comment=$idcomment";
    $DB->query($sql);
    $sql1 = "SELECT user_like FROM comments WHERE id_comment = $idcomment";
    $db1 = $DB->query($sql1);
    $rs = mysql_fetch_array($db1);
    echo '<a href="#"  onClick="return false" style="margin-left:20px;" class="liked-comment"><i class="fa fa-thumbs-up"></i> Thích (' . intval($rs['user_like']) . ')</a>';
}


if (compile_post('commentpost') == 1) {
    if (strtolower(compile_post('captcha')) == $_SESSION['imagesercurity']) {
        $a = array();
        $a['comment'] = compile_post('inputcomment');
        $a['email'] = compile_post('inputemail');
        $a['table_name'] = $table_name;
        $a['id_item'] = $id_item_name;
        $a['id_value'] = intval(compile_post("id_product"));
        $a['name'] = compile_post('inputname');

        $a['parentid'] = compile_post('parentid');

        $a['createdate'] = time() + $CONFIG['time_offset'];
        $a['id_admin'] = 0;
        $a['active'] = 0;

        $b = $DB->compile_db_insert_string($a);
        $sql = "INSERT INTO comments(" . $b['FIELD_NAMES'] . ") VALUES (" . $b['FIELD_VALUES'] . ")";
        $db = $DB->query($sql);

        if ($db)
            echo '<div class="message-success"><i class="fa fa-check fa-2x"></i> Bình luận của bạn đã gửi thành công !</div>';
        else
            echo '<div class="alert-error" id="message_error" ><i class="fa fa-warning"></i> Đăng bình luận không thành công, Bạn hãy thử lại</div>';
    }else {
        echo '<div class="alert-error" ><i class="fa fa-warning fa-2x"></i> Mã captcha không đúng !</div>';
    }
} else {

    getComments(intval(compile_post("id_product")));

    /*
      $id_item = intval($_REQUEST['id_product']);
      $tpl = new TemplatePower("templates/comment.htm");
      $tpl->prepare();


      $tpl->printToScreen();

     */
}
?>