<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['migration_enabled'] = TRUE; // Enable or disable migrations
$config['migration_type'] = 'sequential'; // 'sequential' or 'timestamp'
$config['migration_table'] = 'migrations'; // Name of the migrations table in the database
$config['migration_auto_latest'] = FALSE; // If TRUE, the system will try to automatically migrate to the latest version
$config['migration_version'] = 0; // The migration version to migrate to if migration_auto_latest is set to FALSE
$config['migration_path'] = APPPATH . 'migrations/'; 