<?php

/**
 * Audit_mr module class
 *
 * @package munkireport
 * @author AvB
 **/
class Audit_mr_controller extends Module_controller
{
    public function __construct()
    {
        // Store module path
        $this->module_path = dirname(__FILE__);
    }

    public function index()
    {
        echo "You've loaded the audit_mr module!";
    }
    
    public function admin()
    {
        // Check if the user is authorized and has admin role
        if (! $this->authorized()) {
            die('Authenticate first.');
        }

        if (! $this->authorized('global')) {
            die('You need to be admin');
        }

        $obj = new View();
        $obj->view('audit_mr_admin', [], $this->module_path.'/views/');
    }


     /**
     * Retrieve adming data in json format for admin page
     *
     * @author tuxudo
     **/
    public function get_data_admin()
    {
        // Check if the user is authorized and has admin role
        if (! $this->authorized()) {
            jsonView(['error' => 'Authenticate first.']);
            return;
        }

        if (! $this->authorized('global')) {
            jsonView(['error' => 'You need to be admin']);
            return;
        }
        
        $sql = "SELECT `username`, `timestamp`, `ip_address`, `action`, `role`, `user_agent`
                FROM audit_mr";
            
        $queryobj = new Audit_mr_model();
        jsonView($queryobj->query($sql));
    }
} // End class Audit_mr_controller
