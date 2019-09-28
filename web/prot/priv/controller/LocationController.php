<?php
namespace AstroApp\Web\Prot\Priv\Controller;
use AstroApp\Web\Prot\Priv\Entities;

class LocationController extends Location {
public $_country = $_GET["country"];
public $_state = $_GET["state"];
public $_city = $_GET["city"];

}
?>