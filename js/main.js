console.log('swi loaded...');

function loadSWI(val) {
  const num = Number(val) || 0;
  if (num < 1 || num > 80) {
    console.error('range is wrong');
    return false;
  }
  const endpoint = `https://swapi.dev/api/people/${num}`;

  // retrieve data from API
  fetchData(endpoint)
    .then(data => {
      // output name of character
      document.querySelector('#sw-dashboard').innerHTML = 
        `Star Wars character set to this page is: ${data.name}`;
  });

  /**
   * Fetches data from a given API endpoint.
   * @param {string} url - URL of the API endpoint.
   * @return {Promise} - Promise that resolves as a JSON object of the response.
   */
  async function fetchData(url) {
    const resp = await fetch(url);
    return await resp.json();
  }
}
