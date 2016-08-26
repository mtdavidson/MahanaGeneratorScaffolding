<?php
/**
 * Created by PhpStorm.
 * User: jmadsen
 * Date: 8/25/2016
 * Time: 5:25 PM
 */

namespace jrmadsen67\MahanaScaffolding\Parsers;

use Illuminate\Support\Collection;

class ModelParser extends BaseParser
{
    public $tableName;

    public $primaryKey;

    public $fillable;

    public $dates;

    function __construct($itemArray)
    {
        parent::__construct($itemArray);

        $this->setTableName($this->itemArray->get('table', ''));
        $this->setPrimary($this->itemArray->get('primary_key', ''));

        $this->parseFields($this->itemArray->get('fields', []));

    }

    function getTableName(){
        return $this->tableName;
    }

    function setTableName($item){
        $this->tableName = $item;
    }

    function getPrimary(){
        return $this->primaryKey;
    }

    function setPrimary($item){
        $this->primaryKey = $item;
    }

    function getFillable(){
        if (empty($this->fillable)){
            return '';
        }

        return implode(',', $this->fillable);
    }

    function setFillable($item){
        $this->fillable[] = $item;
    }

    function getDates(){
        if (empty($this->dates)){
            return '';
        }

        return implode(',', $this->dates);
    }

    function setDates($item){
        $this->dates[] = $item;
    }

    public function parseFields($items)
    {
        (new Collection($items))->each(function($field, $key){
            if (!empty($field['fillable'])){
                $this->setFillable($key);
            }

            if (!empty($field['dates'])){
                $this->setDates($key);
            }
        });
    }
}