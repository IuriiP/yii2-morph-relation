Append the "morphing" possibility to relations
=====================

Using
-----

Add trait to your `ActiveRecord` class and define 
the "morphed" relation.

### Example:

```php
class MorphedRecord extends ActiveRecord {

    use \iuriip\yii2\Morphed;

    /**
     * Getter
     */
    public function getSomething() {
        return $this->morphTo('something');
    }

    /**
     * Setter
     * optionally for use direct assigning.
     * else you must use direct `link()` call
     */
    public function setSomething($toRecord) {
        return $this->link('something',$toRecord);
    }

}
```

Table with the "morphed" relation must has the predefine named fields:

~~~
 `something_model` string NOT NULL,
 `something_id` integer NOT NULL,
~~~

You can easy use the linked relation:

```php
    // get related record
    $theMorphed = $record->something;

    // set related record
    $newMorphed = new SomeModel();
    // ...
    $newMorphed->save();
    $record->something = $newMorphed;
    // or
    // $record->link('something',$newMorphed);
```

### Namespace

All morphed models use the parent model namespace on default.

If you need use the models from other namespace just define the protected/public 
`$morphReflect` array property. I.e.:

```php
    protected $morphReflect = [
        'alias1' => 'full\\namespaced\\Model',
        'alias2' => 'other\\namespaced\\Model',
        'aliasX' => 'other\\available\\Model',
    ];
```
