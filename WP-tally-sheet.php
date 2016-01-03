<?php

require_once 'Form/TallyInitForm.php';
require_once "Service/TallySheetAdminService.php";

/**
  Plugin Name: Tally sheet
  Plugin URI: https://github.com/wilvers/WP-tally-sheet
  Description: Wordpress  plugin. tally sheet to save daily work.
  Version: 1.0.0
  Author: Patrice Wilvers
  Author URI: http://www.wilvers.net/
 */
add_action("widgets_init", "tally_sheet_init");

function tally_sheet_init() {
    register_widget("tally_sheet");
}

add_action('admin_menu', 'register_my_custom_menu_page');

function register_my_custom_menu_page() {
    add_menu_page('Tally Sheet', 'Tally Sheet', 'manage_options', 'TallySheetAdmin', 'my_custom_menu_page', plugins_url('WP-tally-sheet/assets/images/icon.png'), 99);
}

function my_custom_menu_page() {
    $p = new tally_sheet_admin();
    echo $p->getPage();
}

function pw_load_scripts($hook) {
    wp_enqueue_script('wxcw', plugins_url('jquery-updater/js/jquery-2.1.4.min.js', dirname(__FILE__)));
    wp_enqueue_script('custom-js', plugins_url('WP-tally-sheet/assets/js/custom.js', dirname(__FILE__)));
}

add_action('admin_enqueue_scripts', 'pw_load_scripts');
// Same handler function...
add_action('wp_ajax_nopriv_save_tallysheet', 'my_action_callback');
add_action('wp_ajax_save_tallysheet', 'my_action_callback');

function my_action_callback() {
    $p = new tally_sheet_admin();

    echo $p->saveJson();
}

class tally_sheet extends WP_widget {

    public function tally_sheet() {
        $options = array(
            "classname" => "tally-sheet",
            "description" => "tally sheet to save daily work."
        );
        $this->WP_widget("Wilvers-tally-sheet", "Feuille de pointage", $options);
    }

    public function widget($param, $instance) {
        extract($param);
        echo $before_widget;
        echo $before_title . $instance["title"] . $after_title;
        echo the_permalink();
        echo $after_widget;
    }

    public function form($instance) {
        $default = array("value");
        $instance = wp_parse_args($instance, $default);

        $instance["id"] = $this->get_field_id("title");
        $instance["name"] = $this->get_field_name("title");

        $form = new TallySheet\Form\TallyInitForm();
        echo $form->render($instance);
    }

    public function update($new, $old) {
        return $new;
    }

}

class tally_sheet_admin {

    public function getPage() {
        $service = new TallySheet\Service\TallySheetAdminService();
        return $service->render(array(
        ));
    }

    public function saveJson() {
        $service = new TallySheet\Service\TallySheetAdminService();
        return $service->saveJson();
    }

}
