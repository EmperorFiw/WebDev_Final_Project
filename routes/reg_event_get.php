<?php
$eid = $_GET['eid'];
$name = $_GET['name'];
$image = $_GET['image'];
renderView('reg_event_get', ["eid" => $eid, "event_name" => $name, "image" => $image]);