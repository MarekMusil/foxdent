<?php

namespace App\Models\Insurance;

use CodeIgniter\Model;
use App\Models\System\SystemUpdateModel;

class InsuranceModel extends Model
{   
    private $data = NULL;
    private $showInactive = FALSE;
    protected $table = 'insurances';

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function setShowInactive($bool)
    {
        $this->showInactive = $bool;
    }


    public function updateRecord()
    { 
        $this->db->transStart();

        foreach ($this->data as $insurance)
        {
            $insurances[] = [
                'id' => $insurance['id'],
                'rank' => $insurance['rank'],
                'active' => $insurance['active'],
            ];
        }
        $builder = $this->db->table($this->table);
        $builder->updateBatch($insurances, 'id');

        $__systemUpdate = new SystemUpdateModel;
        $__systemUpdate->updateRecord();

        $this->db->transComplete();
        if ($this->db->transStatus() === FALSE)
        {          
            return FALSE;
        }

        return TRUE; 
    }

    public function getRecord()
    {
        $insurance = [];
        $builder = $this->db->table($this->table);
        $builder->select('*');
        $builder->orderBy('rank', 'ASC');    

        if ($this->showInactive == FALSE)
        {
            $builder->where('active', 1);
        }

        $q = $builder->get()->getResultArray();

        foreach ($q as $row)
        {
            $insurances[] = [
                'id' => (int)$row['id'],
                'rank' => (int)$row['rank'],
                'name' => $row['name'],
                'imgUrl' => base_url() . $row['img_url'],
                'active' => (int)$row['active'],
            ];
        }

        return $insurances;
    }
}