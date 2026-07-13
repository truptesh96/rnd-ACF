<?php 
    $menu_items = get_menu_items_by_identifier('site-menu');
    if ($menu_items) {
        $menu_tree = build_menu_tree($menu_items);
        render_accessible_menu($menu_tree, 0, 'c-nav');
    }
?>