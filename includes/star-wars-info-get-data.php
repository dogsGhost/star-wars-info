<?php

/**
 * Make request to Star Wars API
 * @param string $id Numeric value corresponding to id of person in SW API
 * @return array|null
 */
function swi_get_data($id)
{
  // trailing slash is important!
  $urlEnding = $id ? $id . '/' : '';
  $url = 'https://swapi.dev/api/people/' . $urlEnding;
  $client = curl_init($url);
  curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($client);
  curl_close($client);

  return json_decode($response);
}
