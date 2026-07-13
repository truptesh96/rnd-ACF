<?php
/**
 * Get menu items by menu ID, slug, or name
 */
function get_menu_items_by_identifier($menu) {

    // Numeric → menu ID
    if (is_numeric($menu)) {
        return wp_get_nav_menu_items((int) $menu);
    }

    // Theme location support
    $locations = get_nav_menu_locations();
    if (isset($locations[$menu])) {
        return wp_get_nav_menu_items((int) $locations[$menu]);
    }

    // Slug or menu name
    $menu_obj = wp_get_nav_menu_object($menu);
    if ($menu_obj && ! is_wp_error($menu_obj)) {
        return wp_get_nav_menu_items((int) $menu_obj->term_id);
    }

    return false;
}

/**
 * Convert flat menu list into tree structure
 */
function build_menu_tree(array $items) {

    $tree    = [];
    $indexed = [];

    // Index items
    foreach ($items as $item) {
        $item->children = [];
        $indexed[$item->ID] = $item;
    }

    // Build hierarchy
    foreach ($indexed as $item) {
        if (! empty($item->menu_item_parent) && isset($indexed[$item->menu_item_parent])) {
            $indexed[$item->menu_item_parent]->children[] = $item;
        } else {
            $tree[] = $item;
        }
    }

    return $tree;
}

/**
 * Render accessible menu
 *
 * Usage:
 * render_accessible_menu($menu_tree, 0, 'e-head-nav');
 * render_accessible_menu($menu_tree, 0, 'c-foot-nav');
 */
function render_accessible_menu(array $items, $depth = 0, $menu_prefix = 'c-nav') {

    if (empty($items) || $depth > 3) {
        return;
    }

    $level = $depth + 1;
    $role  = ($depth === 0) ? 'menubar' : 'menu';

    $ul_classes = [
        $menu_prefix . '__level',
        $menu_prefix . '__level--' . $level,
    ];

    if ($level > 1) {
        $ul_classes[] = $menu_prefix . '__submenu';
    }

    echo '<ul class="' . esc_attr(implode(' ', $ul_classes)) . '" role="' . esc_attr($role) . '">';

    foreach ($items as $item) {

        $has_children = ! empty($item->children);
        $classes      = is_array($item->classes) ? $item->classes : [];

        $is_current = in_array('current-menu-item', $classes, true)
            || in_array('current-menu-ancestor', $classes, true);

        /* ---------------------------
         * <li> classes (unchanged)
         * --------------------------- */
        $li_classes = [
            $menu_prefix . '__item',
            $menu_prefix . '__item--level-' . $level,
        ];

        echo '<li class="' . esc_attr(implode(' ', $li_classes)) . '" role="none">';

        /* ---------------------------
         * <a> classes
         * --------------------------- */
        $link_classes = [
            $menu_prefix . '__link',
            $menu_prefix . '__link--level-' . $level,
        ];

        if ($is_current) {
            $link_classes[] = 'is-active';
        }

        // Add custom classes from WP menu admin
        $custom_link_classes = array_filter($classes);
        $link_classes        = array_merge($link_classes, $custom_link_classes);

        /* ---------------------------
         * Optional link attributes
         * --------------------------- */
        $target = ! empty($item->target)
            ? ' target="' . esc_attr($item->target) . '"'
            : '';

        $title = ! empty($item->attr_title)
            ? ' title="' . esc_attr($item->attr_title) . '"'
            : '';

        $rel = ! empty($item->xfn)
            ? ' rel="' . esc_attr($item->xfn) . '"'
            : '';

        echo '<a
            class="' . esc_attr(implode(' ', array_unique($link_classes))) . '"
            href="' . esc_url($item->url) . '"
            role="menuitem"' .
            $target .
            $title .
            $rel .
            ($has_children ? ' aria-haspopup="true" aria-expanded="false"' : '') .
        '>';

        
        echo '<span class="' . esc_attr($menu_prefix) . '__label">' . esc_html($item->title) . '</span>';
        echo '<span hidden class=" hover-state ' . esc_attr($menu_prefix) . '__label">' . esc_html($item->title) . '</span>';
    

        echo '</a>';

        // Children
        if ($has_children) {
            render_accessible_menu($item->children, $depth + 1, $menu_prefix);
        }

        echo '</li>';
    }

    echo '</ul>';
}
?>
