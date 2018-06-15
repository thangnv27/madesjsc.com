<?php

//Nguyen Van Binh
//suongmumc@gmail.com
defined('_VALID_NVB') or die('Direct Access to this location is not allowed.');
$tpl = new TemplatePower($CONFIG['template_dir'] . "/product.htm");
$tpl->prepare();
$tpl->assignGlobal("dir_path", $dir_path);
$id = intval($_GET['id']);


if ($_GET['idcgr']) {
    $idc = intval($_GET['idcgr']);
} else {
    $idc = intval($_GET['idc']);
}

$tpl->assignGlobal("pathpage", Get_Main_Cat_Name_path($idc));
//$catinfo = Category::categoryInfo($idc);
//$tpl->assignGlobal("catname", $catinfo['name']);
//$tpl->assignGlobal("catcontent", $catinfo['content']);
//$tpl->assignGlobal("catlink",$dir_path.'/'.$catinfo['url']);
$objProduct = new dbProduct();
$product = new clsProduct();
$tpl->printToScreen();

class clsProduct {

    private $numberpage = 8;
    private $numberitempage = 15;

    public function __construct() {
        global $DB, $tpl, $dir_path, $idc, $id;
        $tpl->assignGlobal("dir_path", $dir_path);
        if ($id) {
            $this->proDetail($id);
            // $this->otherProduct($idc);
        } else {
            $tpl->newBlock("proCat");
            $catinfo = Category::categoryInfo($idc);
            $tpl->assignGlobal("catname", $catinfo['name']);
            $tpl->assignGlobal("catlink", $dir_path . '/' . $catinfo['url']);
            if (strlen($catinfo['content']) > 7) {
                $tpl->assignGlobal("catcontent", '<div style="padding:10px 0px">' . $catinfo['content'] . '</div>');
            }
            $this->proCat();
        }
    }

    public function proCat() {
        global $DB, $idc, $tpl, $objProduct, $dir_path, $cache_image_path, $SETTING, $clsUrl;

        if ($idc > 0)
            $tpl->assign("sub_category", subCategory($idc));
        if (isset($_GET['pr']) && $_GET['pr'] != '') {
            $pr = $_GET['pr'];
            $price = explode("-", $pr);

            if ($price) {
                foreach ($price as $pri) {
                    if (is_number($pri)) {
                        $price1 = $pri * 1000000;
                    }
                }
            }
            if ($price[0] == 'tren') {
                $filter = " AND price > " . $price1 . " ";
            } else {
                $filter = " AND price < " . $price1 . " ";
            }
        }

        if (isset($_GET['s']) && $_GET['s'] != '') {
            $s = $_GET['s'];
            if ($s == 'gia-thap-den-cao') {
                $orderby = "ORDER BY price ASC";
            } else if ($s == 'gia-cao-den-thap') {
                $orderby = "ORDER BY price DESC";
            }
        }

        $tpl->assign("proCat.url_query", $_SERVER['QUERY_STRING']);

        $db = $objProduct->itemList($idc, intval($SETTING->productinpage), $filter, $orderby);
        $i = 0;
        foreach ($db as $rs) {
            if ($rs['id_product'] > 0) {
                $i++;
                $tpl->newBlock("products");

                $tpl->assign("name", $rs['name']);
                if ($rs['icon']) {
                    $tpl->assign("km", '<div class="' . $rs['icon'] . '">' . $rs['texticon'] . '</div>');
                }

                if (intval($rs['pricekm']) > 0) {
                    $tpl->assign("price", "Giá KM: " . number_format($rs['pricekm']) . ' đ');
                    $tpl->assign("pricekm", "Giá: " . number_format($rs['price']) . ' đ');
                } else {
                    if (intval($rs['price']) > 0) {
                        $tpl->assign("price", "Giá: " . number_format($rs['price']) . ' đ');
                    } else {
                        $tpl->assign("price", $rs['price']);
                    }
                }


                if ($rs['image']) {
                    $image = $cache_image_path . cropimage(250, 250, $dir_path . '/' . $rs['image']);

                    $tpl->assign("image", '<img src="' . $image . '" alt="' . $rs['name'] . '" width="100%">');
                }
                if ($rs['icon']) {
                    $tpl->assign("icon", '<div class="' . $rs['icon'] . '">' . $rs['texticon'] . '</div>');
                }
                $tpl->assign("ttkhuyenmai", strstrim(strip_tags($rs['ttkhuyenmai']), 20));
                //$tpl->assign("attribute",$objProduct->getAttr(intval($rs['id_category']),$rs['attr']));
                //$tpl->assign("link_detail",$clsUrl->getUrl('product',$rs['id_category'],$rs['id_product']));
                $tpl->assign("link_detail", $dir_path . '/' . url_process::getUrlCategory($rs['id_category']) . $rs['url']);
                if ($i % 4 == 0) {
                    $tpl->assign("pc_break", '<div class="c20 pc-break"></div>');
                }
                if ($i % 3 == 0) {
                    $tpl->assign("pc_break_30", '<div class="c20 mobile-break-30"></div>');
                }
                if ($i % 2 == 0) {
                    $tpl->assign("pc_break_50", '<div class="c20 pc-break-50"></div>');
                }
            }
        }
        $tpl->assign("proCat.pages", $db['pages']);
    }

    function proDetail($id) {

        global $DB, $idc, $tpl, $objProduct, $dir_path, $cache_image_path, $static, $SETTING, $clsUrl, $site_address;

        $id = intval($id);
        $tpl->newBlock("proDetail");
        $catinfo = Category::categoryInfo($idc);
        $tpl->assignGlobal("catname", $catinfo['name']);
        $tpl->assignGlobal("catlink", $dir_path . '/' . $catinfo['url']);
        $rs = $objProduct->itemDetail($id);

        $btnorder = explode("<br>", $SETTING->btn_order);
        $tpl->assign("btn_order", $btnorder[0]);
        $tpl->assign("btn_order_note", $btnorder[1]);

        $btnorder = explode("<br>", $SETTING->btn_payment_detail_pro);
        $tpl->assign("btn_payment_detail_pro", $btnorder[0]);
        $tpl->assign("btn_payment_detail_pro_note", $btnorder[1]);

        $btnorder = explode("<br>", $SETTING->btn_vanchuyen_detail_pro);
        $tpl->assign("btn_vanchuyen_detail_pro", $btnorder[0]);
        $tpl->assign("btn_vanchuyen_detail_pro_note", $btnorder[1]);

        $btnorder = explode("<br>", $SETTING->btn_doitra_detail_pro);
        $tpl->assign("btn_doitra_detail_pro", $btnorder[0]);
        $tpl->assign("btn_doitra_detail_pro_note", $btnorder[1]);

        if (intval($rs['id_product']) > 0) {
            $tpl->assign("name", $rs['name']);
            if (intval($rs['pricekm']) > 0) {
                $tpl->assign("price", "Giá KM: " . number_format($rs['pricekm']) . ' đ');
                $tpl->assign("pricekm", "Giá: " . number_format($rs['price']) . ' đ');
            } else {
                if (intval($rs['price']) > 0) {
                    $tpl->assign("price", "Giá: " . number_format($rs['price']) . ' đ');
                } else {
                    $tpl->assign("price", $rs['price']);
                }
            }
            if ($rs['icon']) {
                $tpl->assign("km", '<div class="' . $rs['icon'] . '">' . $rs['texticon'] . '</div>');
            }
            $tpl->assign("ttkhuyenmai", $rs['ttkhuyenmai']);
			$tpl->assign("description", $rs['description']);
            $tpl->assign("content", $rs['content']);
            $tpl->assign("intro", $rs['intro']);
            if ($rs['tabname0']) {
                $tpl->assign("tabname0", '<a href="#pro_tab_detail2" class="pro_tab_detail2">' . $rs['tabname0'] . '</a>');
                $tpl->assign("tabname01", '<a href="#pro_tab_detail2" class="pro_tab_detail2 active">' . $rs['tabname0'] . '</a>');
                $tpl->assign("contenttab0", '<div class="content-detail" id="pro_video" style="padding:10px 0px">' . $rs['contenttab0'] . '</div>');
            }

            $tpl->assign("intro", $rs['intro']);
            if ($rs['image']) {

                //$tpl->assign("image1",'<img src="'.$cache_image_path.  resizeimage(530, 800, $dir_path . '/' . $rs['image']).'" alt="'.$rs['name'].'" width="100%" />');
                $tpl->assign("image", $cache_image_path . resizeimage(530, 800, $dir_path . '/' . $rs['image']));
                $tpl->assign("thumb_image", $cache_image_path . cropimage(66, 66, $dir_path . '/' . $rs['image']));
                $tpl->assign("bigimage", $cache_image_path . resizeimage(1200, 1200, $dir_path . '/' . $rs['image']));
            }
            //$tpl->assign("linkcart",$dir_path.'/addcart/?idp='.$rs['id_product'].'&s=');
            $tpl->assign("linkcart", $dir_path . '/addcart/' . $rs['url']);

            $tpl->assignGlobal("id_product", $rs['id_product']);

			$colo = '';
            $color = json_decode($rs['color']);
            foreach ($color as $cl) {
				$tpl->newBlock("color");
				$tpl->assign("color",$cl);
				//$tpl->assign("color1",$cl);
				$tpl->assign("color1",substr($cl,1, strlen($cl)));
			}

            $muahangtuxa = $static->muahangtuxa();
            $tpl->assignGlobal("muahangtuxaname", $muahangtuxa['name']);
            $tpl->assignGlobal("muahangtuxa", $muahangtuxa['content']);
            $thanhtoan_hotro = $static->thanhtoan_hotro();
            $tpl->assignGlobal("thanhtoan_hotro", $thanhtoan_hotro['content']);

            $generalproduct = $static->generalproduct();
            $tpl->assignGlobal("generalproduct", $generalproduct["content"]);
			$sqls = "SELECT * FROM comments WHERE active=1 AND table_name = 'product' AND id_item='id_product' AND id_value=$rs[id_product] AND (parentid is null OR parentid = '' OR parentid = 0) AND star_rate>0 ORDER BY createdate DESC ";
    		$dbs = $DB->query($sqls);
			$number_star = intval(mysql_num_rows($dbs));
			if($number_star>0){
				$tpl->newBlock("starrate");
				$tpl->assign("number_star",$number_star);
				$star = 0;
				while($rss = mysql_fetch_array($dbs)){
					$star = $star+$rss['star_rate'];	
				}
				$tpl->assign("name",$rs['name']);
				$tpl->assign("image", $cache_image_path . resizeimage(530, 800, $dir_path . '/' . $rs['image']));
				$tpl->assign("starrate",($star/$number_star));
			}

            $this->sliderImage($rs['id_product']);

            $attr = $objProduct->getAttrDetail($rs['id_category'], $rs['attr']);
            foreach ($attr as $key => $val) {
                $tpl->newBlock("attr");
                $tpl->assign("attrname", $key);
                $tpl->assign("attrvalue", $val);
                $i++;
            }


            
            include_once("modules/comment.php");
            $tpl->assignGlobal("comment",getComments($id));

            $tpl->assignGlobal("link_detail_pro", $site_address . $dir_path . '/' . url_process::getUrlCategory($rs['id_category']) . $rs['url']);
            $tpl->assignGlobal("spcungloainame", $rs['spcungloainame']);

            $this->sp_cungloai($rs['spcungloai']);
        }
    }

    private function sp_cungloai($spcungloai) {
        global $DB, $idc, $tpl, $objProduct, $dir_path, $cache_image_path, $clsUrl;
        $db = $objProduct->spcungloai($spcungloai);
        $i = 0;
        foreach ($db as $rs) {
            if ($rs['id_product'] > 0) {
                $i++;

                $tpl->newBlock("other_products");

                $tpl->assign("name", $rs['name']);
                if ($rs['icon']) {
                    $tpl->assign("km", '<div class="' . $rs['icon'] . '">' . $rs['texticon'] . '</div>');
                }

                if (intval($rs['pricekm']) > 0) {
                    $tpl->assign("price", "Giá KM: " . number_format($rs['pricekm']) . ' đ');
                    $tpl->assign("pricekm", "Giá: " . number_format($rs['price']) . ' đ');
                } else {
                    if (intval($rs['price']) > 0) {
                        $tpl->assign("price", "Giá: " . number_format($rs['price']) . ' đ');
                    } else {
                        $tpl->assign("price", $rs['price']);
                    }
                }


                if ($rs['image']) {
                    $tpl->assign("image", '<img src="' . $cache_image_path . cropimage(250, 250, $dir_path . '/' . $rs['image']) . '" alt="' . $rs['name'] . '" width="100%">');
                }
                if ($rs['icon']) {
                    $tpl->assign("icon", '<div class="' . $rs['icon'] . '">' . $rs['texticon'] . '</div>');
                }
                $tpl->assign("ttkhuyenmai", strstrim(strip_tags($rs['ttkhuyenmai']), 20));
                //$tpl->assign("attribute",$objProduct->getAttr(intval($rs['id_category']),$rs['attr']));
                //$tpl->assign("link_detail",$clsUrl->getUrl('product',$rs['id_category'],$rs['id_product']));
                $tpl->assign("link_detail", $dir_path . '/' . url_process::getUrlCategory($rs['id_category']) . $rs['url']);
                if ($i % 4 == 0) {
                    $tpl->assign("pc_break", '<div class="c20 pc-break"></div>');
                }
                if ($i % 3 == 0) {
                    $tpl->assign("pc_break_30", '<div class="c20 mobile-break-30"></div>');
                }
                if ($i % 2 == 0) {
                    $tpl->assign("pc_break_50", '<div class="c20 pc-break-50"></div>');
                }
            }
        }
    }

    private function videoDetail($video_url, $thumb_img, $name, $content) {
        global $DB, $tpl, $dir_path, $cache_image_path;
        $tpl->newBlock("videodetail");
        $tpl->assign("name", $name);
        $tpl->assign("content", $content);
        $tpl->assign("autostart", ",'autostart': 'false'");
        $parse = parse_url($video_url);
        if ($parse['host'] == 'youtube.com' || $parse['host'] == 'www.youtube.com') {
            $tpl->assign("video", $video_url);
            $tpl->assign("image", 'http://img.youtube.com/vi/' . getVideoCode($video_url) . '/0.jpg');
            if (getVideoCode($video_url)) {
                $tpl->assignGlobal("video_thumb", '<img src="http://img.youtube.com/vi/' . getVideoCode($video_url) . '/1.jpg" width="86" height="47"  />');
            }
        } else {
            $tpl->assign("video", $dir_path . '/' . $video_url);
            if ($thumb_img) {
                $tpl->assign("image", $cache_image_path . resizeimage(628, '400', $dir_path . '/' . $thumb_img));
                $tpl->assignGlobal("video_thumb", '<img src="' . $cache_image_path . resizeimage(86, 47, $dir_path . '/' . $thumb_img) . '" alt="' . $rs['name'] . '" />');
            }
        }
    }

    private function sliderImage($id_product) {
        global $DB, $tpl, $dir_path, $cache_image_path;
        $id_value = $id_product;
        include_once ('manager/dataprovider/db_sys_image.php');
        $sysImage = new dbSysImage();
        $db = $sysImage->getList('', "product", "id_product", $id_value, "");

        foreach ($db as $rs) {


            if ($rs['image']) {
                $tpl->newBlock("slider_image");
                $tpl->assign("image", $cache_image_path . resizeimage(500, 400, $dir_path . '/' . $rs['image']));
                $tpl->assign("thumb_image", $cache_image_path . cropimage(66, 66, $dir_path . '/' . $rs['image']));
                $tpl->assign("bigimage", $cache_image_path . resizeimage(3000, 3000, $dir_path . '/' . $rs['image']));
                //$tpl->assign("image1",$cache_image_path.resizeimage(477,358,$dir_path.'/'.$rs['image']))	;
            }
        }
    }

}

?>