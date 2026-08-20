<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Install extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('migration');
    }

    public function index(){
        $create_db = $this->createDatabase();
        
    }

    public function createDatabase() {
        // Load the database library
        $this->load->database();

        // Specify the new database name
        
    }

     
}