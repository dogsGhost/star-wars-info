<?php
/**
 * Adds dropdown to bottom of page editor for setting character on a page
 * @todo save meta data correctly
 */

function swi_custom_box_html($post)
{
  // see if value is already saved in metadata
  $savedVal = get_post_meta($post->ID, '_swi_meta_key', true);

  // get data from API
  $url = 'https://swapi.dev/api/people/';
  $client = curl_init($url);
  curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($client);
  $data = json_decode($response);
  curl_close($client);
  
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

add_action('add_meta_boxes', 'swi_add_custom_box');

?>