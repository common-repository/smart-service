<?php 

function smart_service_shortcode($atts){
    extract( shortcode_atts( array(
        'theme' => 1,
    ), $atts) );
   
    $q = new WP_Query(array(
        'posts_per_page' => -1,
        'post_type'      => 'service',
        'orderby'        => 'menu_order',
        'order'          => 'ASC'
        ));
                 
    $list = '<div class="row app_service_info">';
                while($q->have_posts()) : $q->the_post();
                    $idd                 = get_the_ID();
                    $icon                = get_post_meta($idd, 'smart_icon', true);
                    $learnmore           = get_post_meta($idd, 'learn_more_text', true);
                    $servicelink         = get_post_meta($idd, 'learn_more_link', true);
                    $servicebgcolor      = get_post_meta($idd, 'service_bg_c', true);
                    $serviceiconcolor    = get_post_meta($idd, 'service_icon_c', true);
                    $serviceheadingcolor = get_post_meta($idd, 'service_head_c', true);
                    $servicebodycolor    = get_post_meta($idd, 'service_body_c', true);
                    $servicelinkcolor    = get_post_meta($idd, 'service_link_c', true);
                    $post_content        = get_the_content();
                    
                $list .= '
                    <div class="col-lg-4 col-sm-6">
                        <div class="app_service_item" style="background-color: '.esc_attr($servicebgcolor).'; color: '.esc_attr($serviceiconcolor).'">
                            <i class="fa fa-'.esc_attr( $icon ).'"></i>
                            <h5 class="f_p f_size_18 f_600 t_color3 mt_40 mb-30" style="color: '.esc_attr($serviceheadingcolor).'">'.do_shortcode( get_the_title() ). '</h5>
                            <p class="f_300 f_size_15 mb-30" style="color: '.esc_attr($servicebodycolor).'">'.$post_content.'</p>
                            <a href="'.esc_url( $servicelink ).'" class="learn_btn_two c_violet" style="color: '.esc_attr($servicelinkcolor).'">'.esc_html( $learnmore ).' <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                ';
                        
                endwhile;
                $list.= '
                    </div>';
            wp_reset_query();
        return $list;
}
add_shortcode('smart-service', 'smart_service_shortcode');  
