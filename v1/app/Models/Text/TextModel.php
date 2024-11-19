<?php

namespace App\Models\Text;

use CodeIgniter\Model;
use App\Models\System\SystemUpdateModel;
use DateTime;
use App\Helpers\CustomHelper;
use App\Models\System\SingleFileModel;
helper('filesystem');
helper('file');

//use App\Helpers\CustomHelper;

class TextModel extends Model
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
    private $textTranslationId = NULL;
    private $textId = NULL;
    private $textsId = NULL;
    private $textType = NULL;
    private $data = NULL;
    private $debugMode = FALSE;
    private $localization = 'cs_CZ';
    private $format = NULL;
    private $onlyCount = FALSE;
    private $pageLimit = 10;
    private $pageNumber = 1;
    private $removed = NULL;
    private $searchQuery = NULL;
    private $sortBy = 'id';
    private $sortOrder = 'ASC';
    private $withRemoved = FALSE;
    protected $sortByOptions = ['texts_translations.id','texts.rank'];
    protected $sortOrderOptions = ['ASC', 'DESC'];
    protected $table = 'texts';
    protected $tblTextTrans = 'texts_translations';

    public function getPageLimit()
    {
        return $this->pageLimit;
    }
    
    public function getPageNumber()
    {
        return $this->pageNumber;
    }

    public function getTextId()
    {
        return $this->textId;
    }

    public function setActive($bool)
    {
        $this->active = $bool;
    }

    public function setAppType($bool)
    {
        $this->appType = $bool;
    }

    public function setTextTranslationId($textTranslationId)
    {
        $this->textTranslationId = $textTranslationId;
    }

    public function setTextId($textId)
    {
        $this->textId = $textId;
    }

    public function setTextsId($textsId)
    {
        $this->textsId = $textsId;
    }

    public function setTextType($textType)
    {
        $this->textType = $textType;
    }

    public function setLocalization($localization)
    {
        $this->localization = $localization;
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
        $this->sortBy = $by;
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
    
    public function existsId($textId, $removed = 0)
    {
        $builder = $this->db->table($this->table);
        $builder->select('id');
        $builder->where('id', $textId);
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

    public function existsTransaltionForText($textId, $localization)
    {
        $builder = $this->db->table($this->tblTextTrans);
        $builder->select('id');
        $builder->where('text_id', $textId);
        $builder->where('localization', $localization);
        $q = $builder->get()->getResult();

        if ($this->debugMode === TRUE)
        {
            echo $builder->getCompiledSelect();
        }
        
        if (count($q) > 0)
        {
            return TRUE;
        }
        
        return FALSE;        
    }

    public function isValidTypeForText($textId, $textType)
    {
        $builder = $this->db->table($this->table);
        $builder->select('id');
        $builder->where('id', $textId);
        $builder->where('type', $textType);
        $q = $builder->get()->getResult();

        if ($this->debugMode === TRUE)
        {
            echo $builder->getCompiledSelect();
        }
        
        if (count($q) > 0)
        {
            return TRUE;
        }
        
        return FALSE;        
    }

    public function existsTextTranslationId($textTranslationId)
    {
        $builder = $this->db->table($this->tblTextTrans);
        $builder->select('id');
        $builder->where('id', $textTranslationId);

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

    public function isTextTransaltionIdTechnology($textTranslationId , $removed = NULL)
    {    
        $builder = $this->db->table($this->table);
        $builder->select($this->table.'.id as textId');
        $builder->join($this->tblTextTrans, $this->table . '.id = ' . $this->tblTextTrans . '.text_id');

        if (!is_null($removed))
        {
            $builder->where($this->table.'.removed', $removed);
        }

        $builder->where($this->tblTextTrans.'.id', $textTranslationId);
        $builder->where($this->table.'.type', 2);
        $q = $builder->get()->getResult();

        if ($this->debugMode === TRUE)
        {
            echo $builder->getCompiledSelect();
        }
        
        if (count($q) > 0)
        {
            return TRUE;
        }
        
        return FALSE;
    }


    public function getRecord()
    {
        $builder = $this->db->table($this->table);
        $texts = [];
        $serviceTexts = [];
        $technologyTexts = [];
        $otherTexts = [];

        if ($this->onlyCount === FALSE)
        {
            $builder->select('
                '.$this->table.'.id,
                '.$this->table.'.slug,
                '.$this->table.'.rank,
                '.$this->table.'.type,
                '.$this->table.'.name,
                '.$this->table.'.note,
                '.$this->table.'.active,
                '.$this->table.'.create_time,
                '.$this->table.'.update_time,
                '.$this->tblTextTrans.'.id AS translationTextId,
                '.$this->tblTextTrans.'.localization,
                '.$this->tblTextTrans.'.title,
                '.$this->tblTextTrans.'.subtitle,
                '.$this->tblTextTrans.'.content,
                '.$this->tblTextTrans.'.meta_title,
                '.$this->tblTextTrans.'.meta_description,
                '.$this->tblTextTrans.'.meta_keywords
            ');          
        }

        else
        {
            $builder->select('COUNT('.$this->table.'.id) AS count');
        } 
        
        if ($this->format == 'only-texts' || $this->format == 'only-id-for-texts' || $this->format == 'select-option-group-by-type')
        {
            $builder->join($this->tblTextTrans, $this->table . '.id = ' . $this->tblTextTrans . '.text_id', 'left');
        }
        else
        {
            $builder->join($this->tblTextTrans, $this->table . '.id = ' . $this->tblTextTrans . '.text_id');
        }
        
        if (!is_null($this->localization))
        {
            $builder->where($this->tblTextTrans.'.localization', $this->localization);
        }
        
        if (!is_null($this->textTranslationId))  
        {
            $builder->where($this->tblTextTrans.'.id', $this->textTranslationId);
        }

        if (!is_null($this->textId))  
        {
            $builder->where($this->table.'.id', $this->textId);
        }

        if (!is_null($this->textsId))  
        {
            $builder->whereIn($this->table.'.id', $this->textsId);
        }

        if (!is_null($this->textType))  
        {
            $builder->where($this->table.'.type', $this->textType);
        }

        if (!is_null($this->searchQuery))
        {
            $builder->like($this->table.'.name', $this->searchQuery);
        }

        if (!is_null($this->active))
        {
            $builder->where($this->table.'.active', $this->active);
        }

        if ($this->accessRules === TRUE && !is_null($this->textsId))
        {
            $builder->whereIn($this->table.'.id', $this->textsId);
        }

        if (!is_null($this->removed))
        {
            $builder->where($this->table.'.removed', $this->removed);
        }
        else
        {
            if ($this->withRemoved === FALSE)
            {
                $builder->where($this->table.'.removed', 0);
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
            if ($this->format === 'select-option-group-by-type')
            {
                foreach ($q as $row)
                {
                    $text = [
                        'id' => (int)$row->id,
                        'name' => $row->name,   
                    ];

                    if ($row->type == 1)
                    {
                        $serviceTexts[] = $text;
                    }
                    elseif($row->type == 2)
                    {
                        $technologyTexts[] = $text;
                    }
                    else
                    {
                        $otherTexts[] = $text;
                    }

                    $texts[$row->id] = $text;
                }

                $groupedTexts['services'] = $serviceTexts;
                $groupedTexts['technologies'] = $technologyTexts;
                $groupedTexts['others'] = $otherTexts;
                $groupedTexts['all'] = array_values($texts);
                return $groupedTexts;

                return $texts;
            }

            if ($this->format === 'select-option')
            {
                foreach ($q as $row)
                {
                    $text = [
                        'id' => (int)$row->id,
                        'name' => $row->name,   
                    ];

                    $texts[$row->id] = $text;
                }

                return $texts;
            }

            if ($this->format == 'only-id' || $this->format == 'only-id-for-texts')
            {               
                foreach ($q as $row)
                {
                    $texts[] = $row->id;
                }

                return $texts;
            }



            if ($this->format == 'only-texts')
            {          
                foreach ($q as $i => $row)
                {
                    $__createTime = new DateTime($row->create_time);
                    $__updateTime = new DateTime($row->update_time);
    
                    $text = [
                        'id' => (int)$row->id,
                        'rank' => (int)$row->rank,
                        'slug' => $row->slug,
                        'type' => ['value' => (int)$row->type],
                        'name' => $row->name,
                        'note' => $row->note,
                        'active' => [
                            'value' => (int)$row->active
                        ]       
                    ];

                    if (!is_null($row->translationTextId) && $row->localization == 'cs_CZ')
                    {
                        $text['linkForCrm'] = '/texts/'.$row->translationTextId;
                    }
                    else
                    {
                        $text['linkForCrm'] = '/texts/create?typeId='.$row->type.'&textId='.$row->id;
                    }

                    if ($row->type == 1)
                    {
                        $text['type']['text'] = 'Služby';
                        $text['imgUrl'] = base_url() . '../assets/images/services/'.$row->slug.'.svg';

                    }
                    elseif($row->type == 2)
                    {
                        $text['type']['text'] = 'Technologie';
                    }
                    else
                    {
                        $text['type']['text'] = 'Ostatní';
                    }
    
                    $texts[$row->id] = $text;
                }


                return $texts;
            }

            foreach ($q as $i => $row)
            {
                $__createTime = new DateTime($row->create_time);
                $__updateTime = new DateTime($row->update_time);

                $text = [
                    'id' => (int)$row->translationTextId,
                    'rank' => (int)$row->rank,
                    'slug' => $row->slug,
                    'type' => ['value' => (int)$row->type],
                    'textId' => (int)$row->id,
                    'name' => $row->name,
                    'note' => $row->note,
                    'localization' => $row->localization,
                    'title' => $row->title,
                    'subtitle' => $row->subtitle,
                    'content' => htmlspecialchars_decode($row->content),
                    'meta' => [],
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

                if ($row->type == 1)
                {
                    $text['type']['text'] = 'Služby';
                    $text['meta']['title'] = $row->meta_title;
                    $text['meta']['description'] = $row->meta_description;
                    $text['meta']['keywords'] = $row->meta_keywords;
                    $text['imgUrl'] = base_url() . '../assets/images/services/'.$row->slug.'.svg';
                    $serviceTexts[$row->translationTextId] = $text;
                }
                elseif($row->type == 2)
                {
                    $text['type']['text'] = 'Technologie';
                    $text['meta']['title'] = $row->meta_title;
                    $text['meta']['description'] = $row->meta_description;
                    $text['meta']['keywords'] = $row->meta_keywords;
                    $text['photoImgUrl'] = '';
                    $technologyTexts[$row->translationTextId] = $text;
                }
                else
                {
                    $text['type']['text'] = 'Ostatní';
                    $otherTexts[$row->slug] = $text;
                }

                $texts[$row->translationTextId] = $text;
            }

            if (!is_null($this->textTranslationId) && array_key_exists($this->textTranslationId, $texts))
            {
                $textId = $texts[$this->textTranslationId]['textId'];

                $__singleFile = new SingleFileModel;
                $__singleFile->setTechnologyId($textId);
                $singleFileData = $__singleFile->getRecord();

                if(!empty($singleFileData))
                {
                    $texts[$this->textTranslationId]['photoImgUrl'] = str_replace('v1/', '', base_url()) . $singleFileData['path'] . $singleFileData['name'] . $singleFileData['type'];
                }

                return $texts[$this->textTranslationId];
            }

            if ($this->format == 'groupByType')
            {
                $groupedTexts['services'] = $serviceTexts;
                $groupedTexts['technologies'] = $technologyTexts;
                $groupedTexts['others'] = $otherTexts;
                return $groupedTexts;
            }
        }        

        return $texts;
    }

    public function createRecord()
    {
        $this->db->transStart();

        $builder = $this->db->table($this->tblTextTrans);

        if (!is_null($this->data))
        {
            $texts[]=$this->data;

            foreach ($texts as $i => $row)
            {
                $builder->insert($row);
                $this->textId = $this->insertId();
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

        $builder = $this->db->table($this->tblTextTrans);

        if (!is_null($this->textTranslationId))
        {
            $builder->where('id', $this->textTranslationId);

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

        $this->db->transComplete();
        if ($this->db->transStatus() === FALSE)
        {          
            return FALSE;
        }

        return TRUE;   
    }

    public function updateTextRecord()
    {
        $this->db->transStart();

        $builder = $this->db->table($this->table);

        if (!is_null($this->textId))
        {
            $builder->where('id', $this->textId);

            if (!is_null($this->data))
            {
                $this->data['update_time'] = date('Y-m-d H:i:s');
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

    public function updateTextRecordByType($typeId)
    {
        $builder = $this->db->table($this->table);
        $today = date('Y-m-d H:i:s');
        $this->setPageLimit(NULL);
        $this->setTextType($typeId);
        $this->setFormat('only-id-for-texts');
        $itemsInTable = $this->getRecord();
        $itemsToUpdate = [];
        $itemsToCreate = [];
        $itemsToRemove = $itemsInTable;

        foreach ($this->data as $key => $data)
        {
            if (!in_array($data['id'], $itemsInTable))
            {
                $itemsToCreate[] = [
                    'rank'      => $data['rank'],
                    'name'        => $data['name'],
                    'active'        => $data['active'],
                    'type'        => $typeId,
                    'slug'        => CustomHelper::createSlug($data['name']),
                ];
            }
            else
            {
                $key = array_search($data['id'], $itemsToRemove);
    
                if ($key !== FALSE)
                {
                    unset($itemsToRemove[$key]);

                    $itemsToUpdate[] = [
                        'id'          => $data['id'],
                        'rank'      => $data['rank'],
                        'name'        => $data['name'],
                        'active'        => $data['active'],
                        'type'        => $typeId,
                        'slug'        => CustomHelper::createSlug($data['name']),
                    ];
                } 
            }
        }
        if (!empty($itemsToCreate))
        {
            $builderCreate = $this->db->table($this->table);

            foreach ($itemsToCreate as $i => $row)
            {
                $builderCreate->insert($row);
                $textId = $this->insertId();

                $builderCreateTrans = $this->db->table($this->tblTextTrans);
                $builderCreateTrans->insert([
                    'text_id' => $textId,
                    'localization' => 'cs_CZ',
                    'title' => $row['name'],
                ]);
            }
        }

        if (!empty($itemsToRemove))
        {
            /* $builderRemove = $this->db->table($this->table);
            $builderRemove->whereIn('id', $itemsToRemove);
            $builderRemove->delete(); */
        }

        if (!empty($itemsToUpdate))
        {
            $builder->updateBatch($itemsToUpdate, 'id');
        }
        
        $__systemUpdate = new SystemUpdateModel;
        $__systemUpdate->updateRecord();
        
        return TRUE;
    }

    public function getCacheData($type)
    {
        helper('filesystem');
        $texts = [];
        $loadtexts = FALSE;

        if ($type === 'select-option-group-by-type')
        {
            $filetexts = CACHE_PATH . 'texts.json';

            if (file_exists($filetexts) === TRUE)
            {
                $filetextsDate = filemtime($filetexts);
                if (time() - $filetextsDate <= CACHE_MAX_TIME)
                {
                    $dataJson = file_get_contents($filetexts);
                    $dataArray = FALSE;

                    if (!empty($dataJson))
                    {

                        $dataArray = json_decode($dataJson, TRUE);
                    }
                    
                    if (is_array($dataArray) === TRUE)
                    {

                        foreach ($dataArray as $typeName => $textType)
                        {
                            foreach ($textType as $data)
                            {
                                $text = [
                                    'id' => $data['id'],
                                    'name' => $data['name'],
                                ];
                                $texts[$typeName][] = $text;
                            }

                        }
                        $loadtexts = TRUE;
                    }
                }
            }
        }
        else if ($type === 'data')
        {
            $filetexts = CACHE_PATH . 'texts_data.json';

            if (file_exists($filetexts) === TRUE)
            {
                $filetextsDate = filemtime($filetexts);
                if (time() - $filetextsDate <= CACHE_MAX_TIME)
                {
                    $dataJson = get_filenames($filetexts);
                    $dataArray = FALSE;
                    if (!empty($dataJson))
                    {
                        $dataArray = json_decode($dataJson, TRUE);
                    }

                    if (is_array($dataArray) === TRUE)
                    {
                        foreach ($dataArray as $data)
                        {
                            $texts[$data['id']] = $data;
                        }
                        
                        $loadtexts = TRUE;
                    }
                }

            }
        }

        if ($loadtexts === FALSE)
        {
            $__text = new TextModel;
            $__text->setFormat($type);
            $__text->setPageLimit(NULL);
            $texts = $__text->getRecord();

            $data_texts = json_encode(($texts), JSON_UNESCAPED_UNICODE);
            write_file($filetexts, $data_texts);
        }

        return $texts;
    }
}