<?php namespace iuriip\yii2;

use yii\db\ActiveRecord;

trait Morphed {
    
//    public $morphReflect = [];
    
    /**
     * 
     * @param string $morphed prefix to fields names. 
     * Fields must have names $morphed.'_model', $morphed.'_id'
     */
    public function morphTo($morphed) {
        $class = $this->{$morphed.'_model'};
        if($class) {
            if(isset($this->morphReflect) && isset($this->morphReflect[$class])) {
                $class = $this->morphReflect[$class];
            } else {
                $class = (new \ReflectionClass($this))->getNamespaceName()."\\{$class}";
            }
            return $this->hasOne($class,['id'=>$morphed.'_id']);
        }
        return false;
    }
    
    /**
     * 
     * @param string $name the case sensitive name of the relationship.
     * @param ActiveRecordInterface $model the model to be linked with the current one.
     * @param array $extraColumns additional column values to be saved into the junction table.
     */
    public function link($name, $model, $extraColumns = []) {
        if($model) {
            $reflect = null;
        
            if(isset($this->morphReflect) && $this->morphReflect) {
                $class = $model->classname();
                $flip = array_flip($this->morphReflect);
                if(isset($flip[$class])) {
                    $reflect = $flip[$class];
                }
            }
            if(!$reflect) {
                $reflect = (new \ReflectionClass($model))->getShortName();
            }
            $this->{$name.'_model'} = $reflect;
            parent::link($name, $model, $extraColumns); 
        } else {
            $this->{$name.'_model'} = '';
            parent::unlink($name); 
        }
    }
    
}
