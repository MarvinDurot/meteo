<?php 

namespace Core\Model;

class Model {

    // Field names and values
    protected $fields = [];

    /**
     * Constructor
     */ 
    public function __construct($fields) {
        $this->fields = $fields;        
    }

    /**
     * Properties to string
     * @return string
     */ 
    public function __tostring()
    {
         return implode("\t", $this->fields);
    }

    /**
     * Magic getter
     * @param string $field
     * @return string
     */
    public function __get($field) {
        if (isset($this->fields[$field]))
            return $this->fields[$field];
        throw new ModelException("Invalid field name $field in ". get_class($this));
    }

    /**
     * Magic setter
     * @param string $field
     * @param string $value    
     */
    public function __set($field, $value) {
        if (isset($this->fields[$field]))
            $this->fields[$field] = $value;
        else 
            throw new ModelException("Invalid field name $field in ". get_class($this));
    }
    
    /**
     * Test if property is set
     * @param string $field
     * @return bool
     */
    public function __isset($field) {
        return isset($this->fields[$field]);
    }
    
}
?>
