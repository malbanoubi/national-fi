            <?php
                defined( 'ABSPATH' ) or die();

                if ( industrium_get_prefered_option('footer_status') == 'on' ) {

                    $footer_classes = 'footer';
                    $footer_classes .= !empty(industrium_get_prefered_option('footer_style')) ? ' footer-' . esc_attr(industrium_get_prefered_option('footer_style')) : '';
                    $footer_classes .= industrium_get_prefered_option('footer_decoration_status') == 'on' ? ' footer-decorated' : '';
                    ?>

                    <!-- Footer -->
                    <?php
                    echo '<footer class="' . esc_attr($footer_classes) . '">';
                        echo '<div class="footer-bg"></div>';                                                
                        switch (industrium_get_prefered_option('footer_style')) {
                            case 'type-2' :
                                get_template_part('templates/footer/footer-2');
                                break;
                            case 'type-3' :
                                get_template_part('templates/footer/footer-3');
                                break;
                            default :
                                get_template_part('templates/footer/footer-1');
                                break;
                        }
                    echo '</footer>';
                } 
                if(industrium_get_prefered_option('footer_scrolltop_status') == 'on') {
	                echo '<div class="footer-scroll-top">';
	                    echo '<button class="fontello icon-arrow-up" aria-label="Scroll Up"></button>';
	                echo '</div>';
	            }               
            ?>
        </div>
        <?php
            wp_footer();
        ?>
    </body>
</html>