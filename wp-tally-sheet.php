<?php

/*
  Plugin Name: wp-tally-sheet
  Plugin URI: https://github.com/wilvers/WP-tally-sheet
  Description: Wordpress  plugin. tally sheet to save daily work.
  Version: 0.0.1
  Author: Patrice Wilvers
  Author URI: http://www.wilvers.net/
 */
add_action("widgets_init", "tally_sheet_init");

function tally_sheet_init() {
    register_widget("");
}

class tally_sheet extends WP_widget {

    public function tally_sheet() {
        $this->WP_widget("Wilvers-tally-sheet", "Feuille de pointage");
    }

    public function widget($param, $instance) {

    }

    public function form($instance) {

    }

    public function update($p1, $p2) {

    }

}
