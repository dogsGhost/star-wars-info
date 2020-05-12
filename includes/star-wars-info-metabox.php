<?php

require_once(plugin_dir_path(__FILE__) . 'star-wars-info-get-data.php');

/**
 * Adds dropdown to bottom of page editor for setting character on a page
 */

function swi_custom_box_html($post)
{
  // see if value is already saved in metadata
  $savedVal = get_post_meta($post->ID, '_swi_meta_key', true);
  // get data from API
  $data = swi_get_data('');
  // convert data for use in dropdown
  $people = array();
  foreach ($data->results as $key => $result) {
    array_push($people, array(
      'name' => $result->name,
      'id' => $key + 1,
    ));
  }
?>
  <div>
    <label for="swi_field">Select a character to associate with this page</label>
    <br>
    <select name="swi_field" id="swi_field" class="postbox">
      <option value="">No character set</option>
      <?php
      // loop through people and generate dropdown
      foreach ($people as $person) { ?>
        <option value="<?php echo $person['id'] ?>" <?php selected($savedVal, $person['id']); ?>>
          <?php echo $person['name'] ?>
        </option>
      <?php } ?>
    </select>
  </div>
<?php
}

// display the metabox on the page
function swi_add_custom_box()
{
  add_meta_box(
    'swi_box_id',           // Unique ID
    'Star Wars Info Character',  // Box title
    'swi_custom_box_html',  // Content callback, must be of type callable
    'page',                   // Post type
    'normal', // location
  );
}

// save the value set in the dropdown to the page metadata in the database
function swi_save_postdata($post_id)
{
  // make sure value passed exists and is a valid number
  if (
    array_key_exists('swi_field', $_POST) &&
    is_numeric($_POST['swi_field']) &&
    ($_POST['swi_field'] * 1 > 0 &&
      $_POST['swi_field'] * 1 < 81)
  ) {
    update_post_meta(
      $post_id,
      '_swi_meta_key',
      $_POST['swi_field']
    );
  }
}

add_action('add_meta_boxes', 'swi_add_custom_box');
add_action('save_post', 'swi_save_postdata');

?>