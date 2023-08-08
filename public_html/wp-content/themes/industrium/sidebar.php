<?php
/*
 * Created by Artureanec
*/

$sidebar_args              = industrium_get_sidebar_args();
$industrium_sidebar_name      = $sidebar_args['sidebar_name'];
$industrium_sidebar_position  = $sidebar_args['sidebar_position'];
$additional_class          = $sidebar_args['additional_class'];

if ($industrium_sidebar_position !== 'none' && is_active_sidebar($industrium_sidebar_name) ) {
    echo '<div class="sidebar sidebar-position-' . esc_attr($industrium_sidebar_position) . esc_attr($additional_class) . '">';
        dynamic_sidebar($industrium_sidebar_name);
        echo '<div class="shop-hidden-sidebar-close"></div>';
    echo "</div>";
    if ( $additional_class == ' simple-sidebar' ) {
        echo '<div class="simple-sidebar-trigger"></div>';
    }
}