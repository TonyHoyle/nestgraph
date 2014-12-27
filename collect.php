<?php

require 'inc/config.php';
require 'nest-api-master/nest.class.php';

define('USERNAME', $config['nest_user']);
define('PASSWORD', $config['nest_pass']);

date_default_timezone_set($config['local_tz']);

function get_nest_data($config) {
  $nest = new Nest();
  $info = $nest->getDeviceInfo();
  $weather = $nest->getWeather($config['weather_location']);
  $data = array('heating'      => ($info->current_state->heat == 1 ? 1 : 0),
		'timestamp'    => $info->network->last_connection,
		'target_temp'  => sprintf("%.02f", (preg_match("/away/", $info->current_state->mode) ? 
						    $info->target->temperature[0] : $info->target->temperature)),
		'current_temp' => sprintf("%.02f", $info->current_state->temperature),
		'humidity'     => $info->current_state->humidity,
		'outside_temp' => sprintf("%02f", $weather->outside_temperature),
		'outside_humidity' => $weather->outside_humidity
		);
  return $data;
}

?>
