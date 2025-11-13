<?php
declare(strict_types=1);

require_once './shared.php';

class Queue
{
    public int $size;
    private int $count = 0;
    private array|Node $elements;
    
    public function __construct(int $s) {
        $this->size = $s;
        $this->elements = new Node();
    }

    public function push(int $element): void
    {
        if($this->count < $this->size) {
            switch(get_debug_type($this->elements)){
                case 'array': 
                    $this->elements = [$element, ...$this->elements];
                    break;
                
                case 'Node':
                    $this->elements->push($element);
                    break;
                
                default: throw new UnexpectedValueException("UNREACHABLE!!");
            }
            $this->count++;
        }else {
            throw new OverflowException(sprintf("Stack(%d) is full. Cannot add elements.", $this->size));
        }        
    }

    public function pop()
    {
        // First in First out
    }
}