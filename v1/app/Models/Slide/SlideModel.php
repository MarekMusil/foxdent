<?php

namespace App\Models\Slide;

use CodeIgniter\Model;
use App\Models\System\SystemUpdateModel;
use DateTime;
helper('filesystem');
helper('file');
//use App\Helpers\CustomHelper;

class SlideModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function __destruct()
    {
        
    }

    private $accessRules = FALSE;
    private $active = NULL;
    private $appType = NULL;
    private $slideId = NULL;
    private $slidesId = NULL;
    private $data = NULL;
    private $debugMode = FALSE;
    private $format = NULL;
    private $onlyCount = FALSE;
    private $pageLimit = 10;
    private $pageNumber = 1;
    private $removed = NULL;
    private $searchQuery = NULL;
    private $sortBy = 'id';
    private $sortOrder = 'ASC';
    private $withRemoved = FALSE;
    protected $sortByOptions = ['id', 'rank'];
    protected $sortOrderOptions = ['ASC', 'DESC'];
    protected $table = 'slides';

    public function getPageLimit()
    {
        return $this->pageLimit;
    }
    
    public function getPageNumber()
    {
        return $this->pageNumber;
    }

    public function getSlideId()
    {
        return $this->slideId;
    }

    public function setActive($bool)
    {
        $this->active = $bool;
    }

    public function setAppType($bool)
    {
        $this->appType = $bool;
    }

    public function setSlideId($slideId)
    {
        $this->slideId = $slideId;
    }

    public function setSlidesId($slidesId)
    {
        $this->slidesId = $slidesId;
    }
    
    public function setData($data)
    {
        $this->data = $data;
    }
    
    public function setDebugMode($bool)
    {
        $this->debugMode = $bool;
    }
    
    public function setFormat($format)
    {
        $this->format = $format;
    }
    
    public function setOnlyCount($bool)
    {
        $this->onlyCount = $bool;
    }
    
    public function setPageLimit($pageLimit)
    {
        $this->pageLimit = $pageLimit;
    }
    
    public function setPageNumber($pageNumber)
    {
        $this->pageNumber = $pageNumber;
    }
    
    public function setRemoved($bool)
    {
        $this->removed = $bool;
    }
    
    public function setSearchQuery($searchQuery)
    {
        $this->searchQuery = $searchQuery;
    }
    
    public function setSortBy($by)
    {
        if (in_array($by, $this->sortByOptions))
        {
            $this->sortBy = $by;
        }
    }
    
    public function setSortOrder($order)
    {
        if (in_array($order, $this->sortOrderOptions))
        {
            $this->sortOrder = $order;
        }
    }
    
    public function setWithRemoved($bool)
    {
        $this->withRemoved = $bool;
    }
    
    public function existsId($slideId, $removed = 0)
    {
        $builder = $this->db->table($this->table);
        $builder->select('id');
        $builder->where('id', $slideId);
        $builder->where('removed', $removed);
        $q = $builder->get()->getResult();

        if ($this->debugMode === TRUE)
        {
            echo $builder->getCompiledSelect();
        }
        
        if (count($q) == 1)
        {
            return TRUE;
        }
        
        return FALSE;        
    }

    public function getRecord()
    {
        $builder = $this->db->table($this->table);
        $slides = [];

        if ($this->onlyCount === FALSE)
        {
            $builder->select('*');            
        }
        else
        {
            $builder->select('COUNT(id) AS count');
        }        

        if (!is_null($this->slideId))  
        {
            $builder->where('id', $this->slideId);
        }

        if (!is_null($this->slidesId))  
        {
            $builder->whereIn('id', $this->slidesId);
        }

        if (!is_null($this->searchQuery))
        {
            $builder->like('title', $this->searchQuery);
        }

        if (!is_null($this->active))
        {
            $builder->where('active', $this->active);
        }

        if ($this->accessRules === TRUE && !is_null($this->slidesId))
        {
            $builder->whereIn('id', $this->slidesId);
        }

        if (!is_null($this->removed))
        {
            $builder->where('removed', $this->removed);
        }
        else
        {
            if ($this->withRemoved === FALSE)
            {
                $builder->where('removed', 0);
            }
        }

        if ($this->onlyCount === FALSE && !is_null($this->pageLimit))
        {
            $builder->limit($this->pageLimit, ($this->pageNumber * $this->pageLimit) - $this->pageLimit);
        }

        $builder->orderBy($this->sortBy, $this->sortOrder);    

        if ($this->debugMode === TRUE)
        {
            echo $builder->getCompiledSelect();
        }

        $q = $builder->get()->getResult();

        if ($this->onlyCount === TRUE)
        {
            return $q[0]->count;
        }

        if (count($q) > 0)
        {
            if ($this->format === 'select-option')
            {
                foreach ($q as $row)
                {
                    $slidee = [
                        'id' => (int)$row->id,
                        'name' => $row->name,
                        'shortname' => $row->shortname,
                    ];

                    $slides[$row->id] = $slidee;
                }

                return $slides;
            }

            if ($this->format == 'only-id')
            {               
                foreach ($q as $row)
                {
                    $slides[] = $row->id;
                }

                return $slides;
            }

            foreach ($q as $i => $row)
            {
                $__createTime = new DateTime($row->create_time);
                $__updateTime = new DateTime($row->update_time);

                $slide = [
                    'id' => (int)$row->id,
                    'rank' => (int)$row->rank,
                    'title' => $row->title,
                    'button1' => $row->button_1,
                    'button2' => $row->button_2,
                    'text' => [
                        'html' => ($row->text) != NULL ? htmlspecialchars_decode($row->text): "",
                        'plain' => ($row->text) != NULL ? strip_tags(htmlspecialchars_decode($row->text)) : "",
                        'plainShort' => ($row->text) != NULL ? mb_substr(strip_tags(htmlspecialchars_decode($row->text)), 0, 100) . '...' : "",
                    ],
                    'photoImgUrl' => str_replace(API_VERSION_SLUG, '', base_url()) . '/assets/images/slides/slide' . $row->id . '.jpg?t='.time(),
                    'updateTime' => [
                        'format' => $__updateTime->format('d.m.Y H:i:s'),
                        'formatDate' => $__updateTime->format('d.m.Y'),
                        'formatShort' => $__updateTime->format('d.m.Y H:i'),
                        'formatSystem' => $__updateTime->format('Y-m-d\TH:i:s.v\Z')
                    ],
                    'createTime' => [
                        'format' => $__createTime->format('d.m.Y H:i:s'),
                        'formatDate' => $__createTime->format('d.m.Y'),
                        'formatShort' => $__createTime->format('d.m.Y H:i'),
                        'formatSystem' => $__createTime->format('Y-m-d\TH:i:s.v\Z')
                    ],          
                ];

                $slides[$row->id] = $slide;
            }

            if (!is_null($this->slideId) && array_key_exists($this->slideId, $slides))
            {
                return $slides[$this->slideId];
            }
        }        

        return $slides;
    }

    public function createRecord()
    {
        $this->db->transStart();

        $builder = $this->db->table($this->table);

        if (!is_null($this->data))
        {
            $slides[]=$this->data;

            foreach ($slides as $i => $row)
            {
                $builder->insert($row);
                $this->slideId = $this->insertId();
            }
        }

        $__systemUpdate = new SystemUpdateModel;
        $__systemUpdate->updateRecord();
        
        $this->db->transComplete();
        if ($this->db->transStatus() === FALSE)
        {          
            return FALSE;
        }

        return TRUE;     
    }

    public function updateRecord()
    {
        $this->db->transStart();

        $builder = $this->db->table($this->table);

        if (!is_null($this->slideId))
        {
            $builder->where('id', $this->slideId);

            if (!is_null($this->data))
            {
                $builder->update($this->data);
            }
        }
        else
        {
            if (!is_null($this->data))
            {
                $builder->updateBatch($this->data, 'id');
            }
        }

        $__systemUpdate = new SystemUpdateModel;
        $__systemUpdate->updateRecord();

        $this->db->transComplete();
        if ($this->db->transStatus() === FALSE)
        {          
            return FALSE;
        }

        return TRUE;   
    }
}