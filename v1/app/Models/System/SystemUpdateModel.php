<?php

namespace App\Models\System;

use CodeIgniter\Model;

class SystemUpdateModel extends Model
{   
    protected $table = 'system_updates';

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function updateRecord()
    { 
        $this->db->transStart();

        $builder = $this->db->table($this->table);
        $builder->set('update_time', date('Y-m-d H:i:s'));
        $builder->update();

        $this->db->transComplete();
        if ($this->db->transStatus() === FALSE)
        {          
            return FALSE;
        }

        return TRUE; 
    }

    public function getRecord()
    {
        $systemUpdateTime = date('Y-m-d H:i:s');
        $builder = $this->db->table($this->table);
        $builder->select('*');
        $builder->limit(1);
        $systemUpdateTime = $builder->get()->getResultArray()[0]['update_time'];
        return $systemUpdateTime;
    }
}