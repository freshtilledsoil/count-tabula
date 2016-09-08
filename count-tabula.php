<?php
/*
* Plugin Name: Count Tabula
* Plugin URI: https://github.com/freshtilledsoil/count-tabula
* Description: Create accessible, responsive tabs using the Wordpress WYSIWYG editor.
* Version: 0.1
* Author: Fresh Tilled Soil
* Author URI: http://www.freshtilledsoil.com/
*/

/*
[tabgroup (id)]
    [tab (label=Tab 1)]
        Tab Content 1
    [/tab]
    [tab (label=Tab 2)]
        Tab Content 2
    [/tab]
    [tab (label=Tab 3)]
        Tab Content 3
    [/tab]
[/tabgroup]
*/

class CountTabula {
    static $load_assets;

    //***************************************************************************
    //
    //***************************************************************************
    static function init() {
        add_shortcode( 'tabgroup', array(__CLASS__, 'tabgroup_shortcode') );
        add_shortcode( 'tab', array(__CLASS__, 'tab_shortcode') );

        add_action( 'wp_enqueue_scripts', array(__CLASS__, 'enqueue_scripts_styles') );
    }

    //***************************************************************************
    // Tab Group: Wrapper element around tab elements
    //***************************************************************************
    static function tabgroup_shortcode($atts, $content = '') {

        wp_enqueue_style('count-t-styles');
        wp_enqueue_script('count-t-js');

        extract(shortcode_atts(array( 'id' => '' ), $atts));

        return
        '<div class="tab-container" data-action="a11y-tabs" id="' . esc_attr($id) . '">' .
            do_shortcode( $content ) .
        '</div>';
    }

    //***************************************************************************
    // Tab: Individual tab element
    //***************************************************************************
    static function tab_shortcode($atts, $content = '') {
        extract(shortcode_atts(array( 'label' => '' ), $atts));

        return
        '<section class="tab-panel js-tabs__panel" data-tab-label="' . esc_attr( $label ) . '">' .
            '<div class="content-area">' . $content . '</div>' .
        '</section>';
    }

    //***************************************************************************
    //
    //***************************************************************************
    static function enqueue_scripts_styles() {
        wp_register_style( 'count-t-styles', plugins_url('static/assets/css/styles.css', __FILE__) );
        wp_register_script( 'count-t-js', plugins_url('static/assets/js/a11ytabs.js', __FILE__), array('jquery'), '', true );
    }
}
CountTabula::init();
