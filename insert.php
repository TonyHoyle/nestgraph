<?php

require 'inc/config.php';
require 'inc/class.db.php';
require 'collect.php';

try {
  $db = new DB($config);
  $data = get_nest_data($config);
  if (!empty($data['timestamp'])) {
    if ($stmt = $db->res->prepare("REPLACE INTO data (timestamp, heating, target, current, humidity, outside_temp, outside_humidity, updated) VALUES (?,?,?,?,?,?,?,NOW())")) {
      $stmt->bind_param("siddidi", $data['timestamp'], $data['heating'], $data['target_temp'], $data['current_temp'], $data['humidity'], $data['outside_temp'], $data['outside_humidity']);
      $stmt->execute();
      $stmt->close();
    }
  }
  $db->close();
} catch (Exception $e) {
  $errors[] = ("DB connection error! <code>" . $e->getMessage() . "</code>.");
}

?>
