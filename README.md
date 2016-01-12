Append the "morphing" possibility to relations
=====================

INSTALLATION
------------

### Install via Composer

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

Append repository to `composer.json`:

```json
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/IuriiP/yii2-morph-relation.git"
        }
        ],
```

Run update:

~~~
composer require iuriip/yii2-morph-relation
~~~

Using
-----

Add trait to your `ActiveRecord` class and define 
getter (and optionally setter) for the "morphed" relation.

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
