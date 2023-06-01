<?php
namespace App\classes;

use App\Entity\Type;
class SearchAdvanced
{
    /**
     * @var mark
     */
    public $mark="";
    /**
     * @var Type[]
     */
    public $type=[];
    /**
     * @var vintage
     */
    public $vintage;
    /**
     * @var climatisation
     */
    public $climatisation;
    /**
     * @var decapotable
     */
    public $decapotable;
    /**
     * @var toit_ouvrant
     */
    public $toit_ouvrant;
}