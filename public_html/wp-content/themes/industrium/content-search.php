<?php
$paged = !empty($_POST['paged']) ? (int)$_POST['paged'] : (!empty($_GET['paged']) ? (int)$_GET['paged'] : ( get_query_var("paged") ? get_query_var("paged") : 1 ) );
$posts_per_page = (int)get_option('posts_per_page');
$search_terms = get_query_var( 'search_terms' );

if($search_terms == '') {
    $search_terms = array();
}

global $wp_query;
$total_post_count = $wp_query->found_posts;
$max_paged = ceil( $total_post_count / $posts_per_page );



$content = get_the_content();
$content = strip_shortcodes($content);
$content = wp_strip_all_tags($content);
$content = apply_filters( 'the_content', $content );
$content = preg_replace( '/\[.*?(\"title\":\"(.*?)\").*?\]/', '$2', $content );
$content = preg_replace( '/\[.*?(|title=\"(.*?)\".*?)\]/', '$2', $content );
$content = strip_tags( $content );
$content = preg_replace( '|\s+|', ' ', $content );

$cont = '';
$bFound = false;
$contlen = strlen( $content );

foreach ($search_terms as $term) {
    $pos = 0;
    $term_len = strlen($term);
    do {
        if ( $contlen <= $pos ) {
            break;
        }
        $pos = stripos( $content, $term, $pos );
        if ( $pos ) {
            $start = ($pos > 150) ? $pos - 150 : 0;
            $temp = substr( $content, $start, $term_len + 300 );
            $cont .= ! empty( $temp ) ? $temp . ' ... ' : '';
            $pos += $term_len + 150;
        }
    } while ($pos);
}

$cont = strip_shortcodes($cont);
$cont = wp_strip_all_tags($cont);

if( strlen($cont) > 0 ){
    $bFound = true;
} else {
    $cont = mb_substr( $content, 0, $contlen < 300 ? $contlen : 300 );
    if ( $contlen > 300 ){
        $cont .= '...';
    }
    $bFound = true;
}

$pattern = "#\[[^\]]+\]#";
$replace = "";
$cont = preg_replace($pattern, $replace, $cont);

$cont = preg_replace('/('.implode('|', $search_terms) .')/iu', '<mark>\0</mark>', $cont);
$title = get_the_title();
$title = preg_replace( '/('.implode( '|', $search_terms ) .')/iu', '<mark>\0</mark>', $title );
?>

<div <?php post_class('standard-blog-item-wrapper'); ?>>
    <div class="blog-item">
        <?php
            if ( !empty(industrium_post_date_output()) || !empty(industrium_post_author_output()) ) {
                echo '<div class="post-meta-header">';
                    if ( !empty(industrium_post_date_output()) ) {
                        echo industrium_post_date_output(true);
                    }
                    if ( !empty(industrium_post_author_output()) ) {
                        echo industrium_post_author_output(true);
                    }
                echo '</div>';
            }

            if ( !empty(get_the_title()) ) {
                echo '<h3 class="post-title"><a href="' . esc_url(get_the_permalink()) . '">' . sprintf('%s', $title) . '</a></h3>';
            }

            echo '<div class="post-content">';
                echo wp_kses($cont, array(
                    'mark'  => array(),
                    'p'     => array()
                ));
            echo '</div>';

            if ( !empty(industrium_post_tags_output()) ) {
                echo industrium_post_tags_output(', ');
            }

            echo '<div class="post-more-button">';
                echo '<a href="' . esc_url(get_the_permalink()) . '">' . esc_html__('Read More', 'industrium') . '</a>';
            echo '</div>';
        ?>
    </div>
</div>