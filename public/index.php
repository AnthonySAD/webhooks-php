<?php

require_once '../Kernel.php';
require_once '../Log.php';

$config = require_once '../config.php';

$webHooks = new Kernel($config);

$webHooks->pull();














