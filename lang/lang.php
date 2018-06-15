<?php

//Binh Minh
//suongmumc@gmail.com
defined('_VALID_NVB') or die('Direct Access to this location is not allowed.');

function langsite($tplLang = '') {
    global $lang, $tpl, $LANG;
    if ($tplLang == '')
        $tplLang = $tpl;
    if ($lang == '') {
        if ($LANG) {
            foreach ($LANG as $lg => $l) {
                $tplLang->assignGlobal($lg, $l['default']);
            }
        }
    } else {
        if ($LANG) {
            foreach ($LANG as $lg => $l) {
                $tplLang->assignGlobal($lg, $l['en']);
            }
        }
    }
}