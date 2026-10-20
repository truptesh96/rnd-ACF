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

        if (
            ! empty($item->menu_item_parent) &&
            isset($indexed[$item->menu_item_parent])
        ) {
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
 * Supports up to 5 menu levels.
 *
 * Usage:
 *
 * $items = get_menu_items_by_identifier('primary');
 * $menu_tree = build_menu_tree($items);
 * render_accessible_menu($menu_tree, 0, 'e-head-nav');
 */
function render_accessible_menu(
    array $items,
    $depth = 0,
    $menu_prefix = 'c-nav'
) {

    // Level 5 = depth 4.
    // Stop anything deeper than level 5.
    if (empty($items) || $depth > 5) {
        return;
    }

    $level = $depth + 1;

    $role = ($depth === 0)
        ? 'menubar'
        : 'menu';

    $ul_classes = [
        $menu_prefix . '__level',
        $menu_prefix . '__level--' . $level,
    ];

    if ($level > 1) {
        $ul_classes[] = $menu_prefix . '__submenu';
    }

    echo '<ul class="' .
        esc_attr(implode(' ', $ul_classes)) .
        '" role="' .
        esc_attr($role) .
        '">';

    foreach ($items as $item) {

        $has_children = ! empty($item->children);

        /**
         * WordPress custom classes
         *
         * These are the classes entered under:
         *
         * Appearance → Menus → CSS Classes
         */
        $classes = is_array($item->classes)
            ? array_filter($item->classes)
            : [];

        /**
         * Current item / ancestor
         */
        $is_current =
            in_array('current-menu-item', $classes, true) ||
            in_array('current-menu-ancestor', $classes, true);

        /**
         * --------------------------------
         * <li> classes
         * --------------------------------
         */
        $li_classes = [
            $menu_prefix . '__item',
            $menu_prefix . '__item--level-' . $level,
        ];

        /**
         * Optional:
         * Add a class to the <li> when it has children.
         */
        if ($has_children) {
            $li_classes[] = $menu_prefix . '__item--has-children';
        }

        echo '<li class="' .
            esc_attr(implode(' ', $li_classes)) .
            '" role="none">';


        /**
         * --------------------------------
         * <a> classes
         * --------------------------------
         */
        $link_classes = [
            $menu_prefix . '__link',
            $menu_prefix . '__link--level-' . $level,
        ];

        if ($is_current) {
            $link_classes[] = 'is-active';
        }

        /**
         * Add custom classes from:
         *
         * Appearance → Menus → CSS Classes
         */
        $link_classes = array_merge(
            $link_classes,
            $classes
        );

        $link_classes = array_unique(
            array_filter($link_classes)
        );


        /**
         * --------------------------------
         * Link attributes
         * --------------------------------
         */
        $target = ! empty($item->target)
            ? ' target="' . esc_attr($item->target) . '"'
            : '';

        $title = ! empty($item->attr_title)
            ? ' title="' . esc_attr($item->attr_title) . '"'
            : '';

        $rel = ! empty($item->xfn)
            ? ' rel="' . esc_attr($item->xfn) . '"'
            : '';

        $aria_attributes = '';

        if ($has_children) {
            $aria_attributes =
                ' aria-haspopup="true"' .
                ' aria-expanded="false"';
        }


        /**
         * --------------------------------
         * Link
         * --------------------------------
         */
        echo '<a
            class="' . esc_attr(implode(' ', $link_classes)) . '"
            href="' . esc_url($item->url) . '"
            role="menuitem"' .
            $target .
            $title .
            $rel .
            $aria_attributes .
        '>';


        /**
         * --------------------------------
         * Label
         * --------------------------------
         */
        echo '<span class="' .
            esc_attr($menu_prefix) .
            '__label">' .
            esc_html($item->title) .
            '</span>';

        echo '<span hidden class="hover-state ' .
            esc_attr($menu_prefix) .
            '__label">' .
            esc_html($item->title) .
            '</span>';


        echo '</a>';


        /**
         * --------------------------------
         * Description
         * --------------------------------
         *
         * WordPress stores the menu item's
         * Description separately from CSS classes.
         */
        if (! empty($item->description)) {

            /**
             * Base description classes.
             */
            $description_classes = [
                $menu_prefix . '__description',
                $menu_prefix . '__description--level-' . $level,
            ];

            /**
             * Optional custom description classes.
             *
             * You can modify these with:
             *
             * add_filter(
             *     'accessible_menu_description_classes',
             *     function ($classes, $item, $level) {
             *         ...
             *     },
             *     10,
             *     3
             * );
             */
            $description_classes = apply_filters(
                'accessible_menu_description_classes',
                $description_classes,
                $item,
                $level
            );

            echo '<div class="' .
                esc_attr(implode(' ', array_unique(array_filter($description_classes)))) .
                '">';

            echo wp_kses_post($item->description);

            echo '</div>';
        }


        /**
         * --------------------------------
         * Children
         * --------------------------------
         *
         * Recursively render up to level 5.
         */
        if ($has_children && $depth < 4) {
            render_accessible_menu(
                $item->children,
                $depth + 1,
                $menu_prefix
            );
        }

        echo '</li>';
    }

    echo '</ul>';
}
?>
