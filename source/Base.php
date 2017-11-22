<?php
/**
*
*/
class Base
{
    function __construct($dbname){
        $capsule = (unserialize(CAPSULE));
        $capsule->addConnection($dbname);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

}
