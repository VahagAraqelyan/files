<?php

require 'core/constants.php';
require 'autoload.php';
require 'core/Controller.php';
require 'core/View.php';
require 'core/Model.php';

$controller = new Controller();

$controller->index();
