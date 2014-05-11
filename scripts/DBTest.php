<?php

include '../config/autoload.php';

$c = Base::getConnection();

echo "connexion established<br/>";

$res = Base::doSelect("select * from utilisateur");

foreach ($res as $row) {
  foreach ($row as $k=>$v)
  echo "$k : $v <br/>";
};

?>