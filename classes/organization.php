<?php

class Organization {
    public static $table = "organizations";
    
    public $organization_id = 0;
    
    public $FIPST = NULL;
    public $LEAID = NULL;
    public $SCHNO = NULL;
    public $STID = NULL;
    public $SEASCH = NULL;
    public $LEANM = NULL;
    public $SCHNAM = NULL;
    public $PHONE = NULL;
    public $MSTREE = NULL;
    public $MCITY = NULL;
    public $MSTATE = NULL;
    public $MZIP = NULL;
    public $MZIP4 = NULL;
    public $LSTREE = NULL;
    public $LCITY = NULL;
    public $LSTATE = NULL;
    public $LZIP = NULL;
    public $LZIP4 = NULL;
    public $TYPE = NULL;
    public $STATUS = NULL;
    public $UNION = NULL;
    public $ULOCAL = NULL;
    public $LATCOD = NULL;
    public $LONCOD = NULL;
    public $CONUM = NULL;
    public $CONAME = NULL;
    public $CDCODE = NULL;
    public $GSLO = NULL;
    public $GSHI = NULL;
    public $CHARTR = NULL;
    
    public function __construct($row = array())
    {
        $this->instantiate($row);
    }
    
    public function instantiate($row = array())
    {
        foreach($row AS $key => $content)
        {
            if(property_exists($this, $key))
                $this->$key = $content;
        }
    }
    
    public static function insert($array = array())
    {
        $organization = new self();
        
        global $wpdb;
        
        $fields = array_keys(get_object_vars($organization));
        
        $sqlstart = "INSERT INTO " . $wpdb->prefix . self::$table . " (`" . implode("`, `", $fields) . "`) VALUES ";
        
        $organizations = array();
        $count = count($array);
        
        $cnt = 0;
        
        $sql = $sqlstart;
        
        foreach($array AS $element)
        {
            $organization = new self($element);
            
            $contents = array_values(get_object_vars($organization));
            
            foreach($contents AS &$content)
                $content = addslashes($content);
            
            $organizations[] = "('" . implode("', '", $contents) . "')";
            
            //process batch insert in every 1000 records
            if ($count>1000 && $cnt>=1000){
                
                $sql .= implode(", ", $organizations);
                
                $wpdb->query( $sql );
                
                $sql = $sqlstart;
                
                unset($organizations);
                
                $organizations = array();
                
                $cnt = 0;
            } 
            
            $cnt++;
        }
        
        $sql .= implode(", ", $organizations);
        $wpdb->query( $sql );
        
        
    }
}
