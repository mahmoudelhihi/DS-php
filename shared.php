<?php 
declare(strict_types=1);
// Useless file for now :)

require_once './LinkedList.php';

trait ArrayBas
{
    public static function check($value, $propertyName)
    {
        if(!is_array($value)){
            throw new TypeError(sprintf("This Stack instance should use Array to hold \$%s, but it uses %s", $propertyName,  get_debug_type($value)));
        }
    }
}

trait LinkedListBas
{
    public static function check($value, $propertyName)
    {
        if(!($value instanceof Node)){
            throw new TypeError(sprintf("This Stack instance should use LinkedList to hold \$%s, but it uses %s", $propertyName,  get_debug_type($value)));
        }
    }
}