<?php
session_start();

// Autoloader
require_once '../vendor/autoload.php';

// Load Config
require_once '../config/config.php';

// Load Helper
require_once '../app/Helper/mainHelper.php';

// Load ORM
require_once '../app/EntityUtilities/Entity.php';

// Session Handler
require_once '../app/SessionHandler.php';

// Routes
require_once '../routes/web.php';
require_once '../app/Router.php';