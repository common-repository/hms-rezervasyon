<?php

/**
 * @package HMS_Rezervasyon
 * @version 1.0
 */
/*
Plugin Name: HMS Rezervasyon
Plugin URI: http://wordpress.org/plugins/hms-rezervasyon/
Description: Hms Otel Programi Rezervasyon Modulu
Author: HMS Otel Programi
Version: 1.0
Author URI: https://hmsotel.com/
*/

function hmsreservation_register_widget()
{
    register_widget('hmsreservation_widget');
}


add_action('wp_enqueue_scripts', 'hmsreservation_register_scripts');
function hmsreservation_register_scripts()
{

    wp_register_style('fa_style_css',plugins_url( '/assets/css/fa/css/all.min.css', __FILE__ ),false,"",false);

    wp_register_style('jquery-ui-script',plugins_url( '/assets/css/jquery-ui.css', __FILE__ ),false,"1.9.0",false);
    wp_enqueue_style('fa_style_css');
    wp_enqueue_style('jquery-ui-script'); 

    wp_enqueue_style('all');

    wp_enqueue_script('jquery-ui-datepicker');
    wp_enqueue_script( 'hms_dp_script', plugins_url( '/assets/js/customs-dp.js', __FILE__ ) , array('jquery'), '', true);

}


add_action('widgets_init', 'hmsreservation_register_widget');

class hmsreservation_widget extends WP_Widget
{
    function __construct()
    {
        parent::__construct(
            // widget ID
            'hmsreservation_widget',
            // widget name
            __('HMS Rezervasyon Modulu', 'hms_widget_domain'),
            // widget description
            array('description' => __('Online Rezervasyon Modulu', 'hms_widget_domain'),)
        );
    }



    public function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);

        $hms_url = apply_filters('hms_url', $instance['hms_url']);
        echo $args['before_widget'];

        if (!empty($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        echo '
        <form action="' . $hms_url . '" method="get">
        <input name="utm_source" type="hidden" value="' . $_SERVER["HTTP_HOST"] . '">
        <input name="utm_medium" type="hidden" value="">
        <input name="timestep" type="hidden" value="HMS">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-icon-right">
                    <label>Giriş</label>
                    <input name="arrival" class="form-control mb-0 form-control-sm" id="dpd1" placeholder="Check-in" type="text" value="06.04.2021" readonly>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group form-icon-right">
                    <label>Çıkış</label>
                    <input name="departure" class="form-control mb-0 form-control-sm" id="dpd2" placeholder="Check-out" type="text" value="07.04.2021" readonly>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Yetişkin</label>
                    <input name="adult" class="form-control mb-0  form-control-sm" type="number" value="2" min="0" max="40">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Çocuk</label>
                    <input name="child" class="form-control mb-0  form-control-sm" type="number" value="0" min="0" max="10">
                </div>
            </div>
            <div class="col-md-12">
                <div class="row childfull" style="text-align: center;">
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <button class="btn btn-block btn-primary btn-icon">Ara <span class="icon"><i class="fa fa-search"></i></span></button>
        </div>
        <div class="clear mb-10"></div>
        <div class="tooltip-light">
            <p class="price-guarantee text-center hoover-help mb-0" data-toggle="tooltip" data-placement="top" title="Otel Sistemine bağlı olduğu için komisyonsuz direk fiyat alırsınız">
                <i class="fas fa-check-circle text-success"></i>
                <small>En İyi Fiyat Garantisi.</small>
            </p>
        </div>
        <div class="clear"></div>
    </form>
    
    
    
    

    
    
    ';
        echo $args['after_widget'];
    }





    
    public function form($instance)
    {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('Default Title', 'hms_widget_domain');
        }

        if (isset($instance['hms_url'])) {
            $hms_url = $instance['hms_url'];
        } else {
            $hms_url = __('HMS URL', 'hms_widget_domain');
        }
?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
            <label for="<?php echo $this->get_field_id('hms_url'); ?>"><?php _e('HMS Link:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('hms_url'); ?>" name="<?php echo $this->get_field_name('hms_url'); ?>" type="text" value="<?php echo esc_attr($hms_url); ?>" />
        </p>
<?php
    }
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['hms_url'] = (!empty($new_instance['hms_url'])) ? strip_tags($new_instance['hms_url']) : '';
        return $instance;
    }
}
