<?php 
function get_slug($text) {
    $text = strtolower($text);
    $text = strip_tags($text);
    $text = preg_replace('~[^\\pL\\d]+~u', '-', $text);
    $text = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text);
    $text = preg_replace('~[^-\\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    return $text ?: 'n-a';
}
?>