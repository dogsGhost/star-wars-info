<?php
// add front end files
function swi_add_scripts()
{
  wp_enqueue_style(
    'swi-main-style',
    plugins_url() . '/star-wars-info/css/style.css'
  );
  wp_enqueue_script(
    'swi-main-js',
    plugins_url() . '/star-wars-info/js/main.js'
  );
}

// call swi_add_scripts during wp_enqueue_scripts action
add_action('wp_enqueue_scripts', 'swi_add_scripts');
