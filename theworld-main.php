<?php
class TheWorld {
  var $validCodeList = '';
  var $hasBeenColour = '';
  var $notBeenColour = '';

  function __construct() {
    $this->loadData();
  }

  function loadData(){
    if ( get_option('theworld_Colour_has_been') == "" )
      update_option('theworld_Colour_has_been', 'FF0000');
    if ( get_option('theworld_Colour_not_been') == "" )
      update_option('theworld_Colour_not_been', '999999');

    $this->setValidCodeList(get_option('theworld_select'));
    $this->setHasBeenColour(get_option('theworld_Colour_has_been'));
    $this->setNotBeenColour(get_option('theworld_Colour_not_been'));
  }

  function setValidCodeList($data){
    $this->validCodeList = $data;
  }

  function setHasBeenColour($data){
    $this->hasBeenColour = $data;
  }

  function setNotBeenColour($data){
    $this->notBeenColour = $data;
  }

  function getHasBeenColour(){
    return $this->hasBeenColour;
  }

  function getNotBeenColour(){
    return $this->notBeenColour;
  }

  function getCountryNum(){
    return count(explode("|", $this->validCodeList));
  }

  function chartImg(){
    $params = self::$chartDafault;
    $params["chld"] = $this->validCodeList;
    $params["chco"] = "$this->notBeenColour|$this->hasBeenColour";
    $url = $this->chartURL($params);
    return "<img src='$url' style='width:100%; height:auto;'>";
  }

  function chartURL($data) {
    $baseURL = "http://chart.apis.google.com/chart?";
    $params = array();
    while(list ($key, $val) = each($data)) {
      array_push ($params, htmlspecialchars($key)."=".htmlspecialchars($val));
    }
    return $baseURL . implode("&", $params);
  }

  function country_inputs($codes){
    $inputs = array();
    foreach( $codes as $code ){
      $inputs[] = $this->echo_country_input($code);
    }
    return (implode(" | ", $inputs));
  }

  function echo_country_input($cd) {
    $pos = strpos( $this->validCodeList, $cd );
    $countryName = self::$codeList[$cd];
    $checked = $pos === false ? "" : "checked='checked'";
    return "<input type='checkbox' name='country[]' value='$cd' id='checkbox_$cd' $checked> <label for='checkbox_$cd'>$countryName</label>";
  }

  function codeMap() {
    return self::$codeMap;
  }

  private static $chartDafault = array(
    'cht' => 'map:fixed=-60,-180,80,180',
    'chs' => '750x400',
    'chco' => '999999|FF0000',
    'chld' => ''
  );

  private static $codeMap = array(
    "Northern Africa" => array( "DZ", "EG", "EH", "LY", "MA", "SD", "TN" ),
    "Western Africa" => array( "BF", "BJ", "CI", "CV", "GH", "GM", "GN", "GW", "LR", "ML", "MR", "NE", "NG", "SH", "SL", "SN", "TG" ),
    "Middle Africa" => array( "AO", "CD", "ZR", "CF", "CG", "CM", "GA", "GQ", "ST", "TD" ),
    "Eastern Africa" => array( "BI", "DJ", "ER", "ET", "KE", "KM", "MG", "MU", "MW", "MZ", "RE", "RW", "SC", "SO", "TZ", "UG", "YT", "ZM", "ZW" ),
    "Southern Africa" => array( "BW", "LS", "NA", "SZ", "ZA" ),
    "Northern Europe" => array( "GG", "JE", "AX", "DK", "EE", "FI", "FO", "GB", "IE", "IM", "IS", "LT", "LV", "NO", "SE", "SJ" ),
    "Western Europe" => array( "AT", "BE", "CH", "DE", "DD", "FR", "FX", "LI", "LU", "MC", "NL" ),
    "Eastern Europe" => array( "BG", "BY", "CZ", "HU", "MD", "PL", "RO", "RU", "SU", "SK", "UA" ),
    "Southern Europe" => array( "AD", "AL", "BA", "ES", "GI", "GR", "HR", "IT", "ME", "MK", "MT", "CS", "RS", "PT", "SI", "SM", "VA", "YU" ),
    "Northern America" => array( "BM", "CA", "GL", "PM", "US" ),
    "Caribbean" => array( "AG", "AI", "AN", "AW", "BB", "BL", "BS", "CU", "DM", "DO", "GD", "GP", "HT", "JM", "KN", "KY", "LC", "MF", "MQ", "MS", "PR", "TC", "TT", "VC", "VG", "VI" ),
    "Central America" => array( "BZ", "CR", "GT", "HN", "MX", "NI", "PA", "SV" ),
    "South America" => array( "AR", "BO", "BR", "CL", "CO", "EC", "FK", "GF", "GY", "PE", "PY", "SR", "UY", "VE" ),
    "Central Asia" => array( "TM", "TJ", "KG", "KZ", "UZ" ),
    "Eastern Asia" => array( "CN", "HK", "JP", "KP", "KR", "MN", "MO", "TW" ),
    "Southern Asia" => array( "AF", "BD", "BT", "IN", "IR", "LK", "MV", "NP", "PK" ),
    "South-Eastern Asia" => array( "BN", "ID", "KH", "LA", "MM", "BU", "MY", "PH", "SG", "TH", "TL", "TP", "VN" ),
    "Western Asia" => array( "AE", "AM", "AZ", "BH", "CY", "GE", "IL", "IQ", "JO", "KW", "LB", "OM", "PS", "QA", "SA", "NT", "SY", "TR", "YE", "YD" ),
    "Australia and New Zealand" => array( "AU", "NF", "NZ" ),
    "Melanesia" => array( "FJ", "NC", "PG", "SB", "VU" ),
    "Micronesia" => array( "FM", "GU", "KI", "MH", "MP", "NR", "PW" ),
    "Polynesia" => array( "AS", "CK", "NU", "PF", "PN", "TK", "TO", "TV", "WF", "WS" )
  );

  private static $codeList = array(
    "AD" => "Andorra",
    "AE" => "United Arab Emirates",
    "AF" => "Afghanistan",
    "AG" => "Antigua and Barbuda",
    "AI" => "Anguilla",
    "AL" => "Albania",
    "AM" => "Armenia",
    "AO" => "Angola",
    "AQ" => "Antarctica",
    "AR" => "Argentina",
    "AS" => "American Samoa",
    "AT" => "Austria",
    "AU" => "Australia",
    "AW" => "Aruba",
    "AX" => "Åland Islands",
    "AZ" => "Azerbaijan",
    "BA" => "Bosnia and Herzegovina",
    "BB" => "Barbados",
    "BD" => "Bangladesh",
    "BE" => "Belgium",
    "BF" => "Burkina Faso",
    "BG" => "Bulgaria",
    "BH" => "Bahrain",
    "BI" => "Burundi",
    "BJ" => "Benin",
    "BL" => "Saint Barthélemy",
    "BM" => "Bermuda",
    "BN" => "Brunei Darussalam",
    "BO" => "Bolivia, Plurinational State of",
    "BQ" => "Bonaire, Sint Eustatius and Saba",
    "BR" => "Brazil",
    "BS" => "Bahamas",
    "BT" => "Bhutan",
    "BV" => "Bouvet Island",
    "BW" => "Botswana",
    "BY" => "Belarus",
    "BZ" => "Belize",
    "CA" => "Canada",
    "CC" => "Cocos (Keeling) Islands",
    "CD" => "Congo, the Democratic Republic of the",
    "CF" => "Central African Republic",
    "CG" => "Congo",
    "CH" => "Switzerland",
    "CI" => "Côte d'Ivoire",
    "CK" => "Cook Islands",
    "CL" => "Chile",
    "CM" => "Cameroon",
    "CN" => "China",
    "CO" => "Colombia",
    "CR" => "Costa Rica",
    "CU" => "Cuba",
    "CV" => "Cape Verde",
    "CW" => "Curaçao",
    "CX" => "Christmas Island",
    "CY" => "Cyprus",
    "CZ" => "Czech Republic",
    "DE" => "Germany",
    "DJ" => "Djibouti",
    "DK" => "Denmark",
    "DM" => "Dominica",
    "DO" => "Dominican Republic",
    "DZ" => "Algeria",
    "EC" => "Ecuador",
    "EE" => "Estonia",
    "EG" => "Egypt",
    "EH" => "Western Sahara",
    "ER" => "Eritrea",
    "ES" => "Spain",
    "ET" => "Ethiopia",
    "FI" => "Finland",
    "FJ" => "Fiji",
    "FK" => "Falkland Islands (Malvinas)",
    "FM" => "Micronesia, Federated States of",
    "FO" => "Faroe Islands",
    "FR" => "France",
    "GA" => "Gabon",
    "GB" => "United Kingdom",
    "GD" => "Grenada",
    "GE" => "Georgia",
    "GF" => "French Guiana",
    "GG" => "Guernsey",
    "GH" => "Ghana",
    "GI" => "Gibraltar",
    "GL" => "Greenland",
    "GM" => "Gambia",
    "GN" => "Guinea",
    "GP" => "Guadeloupe",
    "GQ" => "Equatorial Guinea",
    "GR" => "Greece",
    "GS" => "South Georgia and the South Sandwich Islands",
    "GT" => "Guatemala",
    "GU" => "Guam",
    "GW" => "Guinea-Bissau",
    "GY" => "Guyana",
    "HK" => "Hong Kong",
    "HM" => "Heard Island and McDonald Islands",
    "HN" => "Honduras",
    "HR" => "Croatia",
    "HT" => "Haiti",
    "HU" => "Hungary",
    "ID" => "Indonesia",
    "IE" => "Ireland",
    "IL" => "Israel",
    "IM" => "Isle of Man",
    "IN" => "India",
    "IO" => "British Indian Ocean Territory",
    "IQ" => "Iraq",
    "IR" => "Iran, Islamic Republic of",
    "IS" => "Iceland",
    "IT" => "Italy",
    "JE" => "Jersey",
    "JM" => "Jamaica",
    "JO" => "Jordan",
    "JP" => "Japan",
    "KE" => "Kenya",
    "KG" => "Kyrgyzstan",
    "KH" => "Cambodia",
    "KI" => "Kiribati",
    "KM" => "Comoros",
    "KN" => "Saint Kitts and Nevis",
    "KP" => "Korea, Democratic People's Republic of",
    "KR" => "Korea, Republic of",
    "KW" => "Kuwait",
    "KY" => "Cayman Islands",
    "KZ" => "Kazakhstan",
    "LA" => "Lao People's Democratic Republic",
    "LB" => "Lebanon",
    "LC" => "Saint Lucia",
    "LI" => "Liechtenstein",
    "LK" => "Sri Lanka",
    "LR" => "Liberia",
    "LS" => "Lesotho",
    "LT" => "Lithuania",
    "LU" => "Luxembourg",
    "LV" => "Latvia",
    "LY" => "Libya",
    "MA" => "Morocco",
    "MC" => "Monaco",
    "MD" => "Moldova, Republic of",
    "ME" => "Montenegro",
    "MF" => "Saint Martin (French part)",
    "MG" => "Madagascar",
    "MH" => "Marshall Islands",
    "MK" => "Macedonia, the former Yugoslav Republic of",
    "ML" => "Mali",
    "MM" => "Myanmar",
    "MN" => "Mongolia",
    "MO" => "Macao",
    "MP" => "Northern Mariana Islands",
    "MQ" => "Martinique",
    "MR" => "Mauritania",
    "MS" => "Montserrat",
    "MT" => "Malta",
    "MU" => "Mauritius",
    "MV" => "Maldives",
    "MW" => "Malawi",
    "MX" => "Mexico",
    "MY" => "Malaysia",
    "MZ" => "Mozambique",
    "NA" => "Namibia",
    "NC" => "New Caledonia",
    "NE" => "Niger",
    "NF" => "Norfolk Island",
    "NG" => "Nigeria",
    "NI" => "Nicaragua",
    "NL" => "Netherlands",
    "NO" => "Norway",
    "NP" => "Nepal",
    "NR" => "Nauru",
    "NU" => "Niue",
    "NZ" => "New Zealand",
    "OM" => "Oman",
    "PA" => "Panama",
    "PE" => "Peru",
    "PF" => "French Polynesia",
    "PG" => "Papua New Guinea",
    "PH" => "Philippines",
    "PK" => "Pakistan",
    "PL" => "Poland",
    "PM" => "Saint Pierre and Miquelon",
    "PN" => "Pitcairn",
    "PR" => "Puerto Rico",
    "PS" => "Palestine, State of",
    "PT" => "Portugal",
    "PW" => "Palau",
    "PY" => "Paraguay",
    "QA" => "Qatar",
    "RE" => "Réunion",
    "RO" => "Romania",
    "RS" => "Serbia",
    "RU" => "Russian Federation",
    "RW" => "Rwanda",
    "SA" => "Saudi Arabia",
    "SB" => "Solomon Islands",
    "SC" => "Seychelles",
    "SD" => "Sudan",
    "SE" => "Sweden",
    "SG" => "Singapore",
    "SH" => "Saint Helena, Ascension and Tristan da Cunha",
    "SI" => "Slovenia",
    "SJ" => "Svalbard and Jan Mayen",
    "SK" => "Slovakia",
    "SL" => "Sierra Leone",
    "SM" => "San Marino",
    "SN" => "Senegal",
    "SO" => "Somalia",
    "SR" => "Suriname",
    "SS" => "South Sudan",
    "ST" => "Sao Tome and Principe",
    "SV" => "El Salvador",
    "SX" => "Sint Maarten (Dutch part)",
    "SY" => "Syrian Arab Republic",
    "SZ" => "Swaziland",
    "TC" => "Turks and Caicos Islands",
    "TD" => "Chad",
    "TF" => "French Southern Territories",
    "TG" => "Togo",
    "TH" => "Thailand",
    "TJ" => "Tajikistan",
    "TK" => "Tokelau",
    "TL" => "Timor-Leste",
    "TM" => "Turkmenistan",
    "TN" => "Tunisia",
    "TO" => "Tonga",
    "TR" => "Turkey",
    "TT" => "Trinidad and Tobago",
    "TV" => "Tuvalu",
    "TW" => "Taiwan, Province of China",
    "TZ" => "Tanzania, United Republic of",
    "UA" => "Ukraine",
    "UG" => "Uganda",
    "UM" => "United States Minor Outlying Islands",
    "US" => "United States",
    "UY" => "Uruguay",
    "UZ" => "Uzbekistan",
    "VA" => "Holy See (Vatican City State)",
    "VC" => "Saint Vincent and the Grenadines",
    "VE" => "Venezuela, Bolivarian Republic of",
    "VG" => "Virgin Islands, British",
    "VI" => "Virgin Islands, U.S.",
    "VN" => "Viet Nam",
    "VU" => "Vanuatu",
    "WF" => "Wallis and Futuna",
    "WS" => "Samoa",
    "YE" => "Yemen",
    "YT" => "Mayotte",
    "ZA" => "South Africa",
    "ZM" => "Zambia",
    "ZW" => "Zimbabwe",
    "AC" => "Ascension Island",
    "CP" => "Clipperton Island",
    "DG" => "Diego Garcia",
    "EA" => "Ceuta, Melilla",
    "EU" => "European Union",
    "FX" => "France, Metropolitan",
    "IC" => "Canary Islands",
    "SU" => "USSR",
    "TA" => "Tristan da Cunha",
    "UK" => "United Kingdom",
    "AX" => "Åland",
    "GG" => "Guernsey",
    "IM" => "Isle of Man",
    "JE" => "Jersey",
    "AN" => "Netherlands Antilles",
    "BU" => "Burma",
    "CS" => "Serbia and Montenegro",
    "NT" => "Neutral Zone",
    "SF" => "Finland",
    "TP" => "East Timor",
    "YU" => "Yugoslavia",
    "ZR" => "Zaire",
    "CS" => "Czechoslovakia",
    "DY" => "Benin",
    "EW" => "Estonia",
    "FL" => "Liechtenstein",
    "JA" => "Jamaica",
    "LF" => "Libya Fezzan",
    "PI" => "Philippines",
    "RA" => "Argentina",
    "RB" => "Bolivia [cf. Botswana: identical code element]",
    "RB" => "Botswana [cf. Bolivia: identical code element]",
    "RC" => "China",
    "RH" => "Haiti",
    "RI" => "Indonesia",
    "RL" => "Lebanon",
    "RM" => "Madagascar",
    "RN" => "Niger",
    "RP" => "Philippines",
    "WG" => "Grenada",
    "WL" => "Saint Lucia",
    "WV" => "Saint Vincent",
    "YV" => "Venezuela",
    "LT" => "Libya Tripoli",
    "ME" => "Western Sahara",
    "RU" => "Burundi",
    "AI" => "French Afar and Issas",
    "BQ" => "British Antarctic Territory",
    "CT" => "Canton and Enderbury Islands",
    "DD" => "German Democratic Republic",
    "DY" => "Dahomey",
    "FQ" => "French Southern and Antarctic Territories",
    "GE" => "Gilbert and Ellice Islands",
    "HV" => "Upper Volta",
    "JT" => "Johnston Island",
    "MI" => "Midway Islands",
    "NH" => "New Hebrides",
    "NQ" => "Dronning Maud Land",
    "PC" => "Pacific Islands, Trust Territory of the",
    "PU" => "U.S. Miscellaneous Pacific Islands",
    "PZ" => "Panama Canal Zone",
    "RH" => "Southern Rhodesia",
    "SK" => "Sikkim",
    "VD" => "Viet-Nam, Democratic Republic of",
    "WK" => "Wake Island",
    "YD" => "Yemen, Democratic"
  );
}
