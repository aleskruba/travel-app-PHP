<?php
//$baseUri = '/travel/';
//$uri = parse_url($_SERVER['REQUEST_URI'])["path"];

    
$popularCountryNames = [
    'Česká republika',
    'Chorvatsko',
    'Itálie',
    'Rakousko',
    'Španělsko',
    'Řecko',
    'Turecko',
    'Francie',
    'Německo',
    'Thajsko',
    'Spojené arabské emiráty',
    'Egypt',
    'Bulharsko',
    'Velká Británie',
    'Portugalsko',
    'Spojené státy',
    'Dominikánská republika',
    'Tunisko',
    'Maďarsko',
    'Švýcarsko',
    'Indie'
  ];

  function compareCzechStrings($a, $b) {
    $collator = new \Collator('cs_CZ.utf8');
    return $collator->compare($a, $b);
}

uasort($popularCountryNames, 'compareCzechStrings');

foreach ($popularCountryNames as $country) {
  $encodedCountry = urlencode($country);
  //echo '<a href="' . $baseUri . 'traveltips/' . $encodedCountry . '">' . $country . '</a><br>';

  echo '<a href="' . getUrl('traveltips/' . $encodedCountry) . '">' . $country . '</a><br>';

}
