<?php
declare(strict_types=1);

require_once './shared.php';

class Stack
{
    public int $capacity;
    private int $count = 0;
    private array|Node $elements;

    public function __construct(int $s, $type) {
        $this->capacity = $s;
        $this->elements = $type;
    }

    public function push(int $element): void
    {
        if($this->count < $this->capacity) {
            switch(get_debug_type($this->elements)){
                case 'array': 
                    $this->elements = [$element, ...$this->elements];
                    break;
                
                case 'Node':
                    $this->elements->pushStart($element);
                    break;
                
                default: throw new UnexpectedValueException("UNREACHABLE!!");
            }
            $this->count++;
        }else {
            throw new OverflowException(sprintf("Stack(%d) is full. Cannot add elements.\n", $this->capacity));
        }        
    }

    public function pop(): int 
    {
        if ($this->count <= 0) {
            throw new UnderflowException("Stack is empty\n");
        }
        
        $first = null;
        
        switch(get_debug_type($this->elements)){
            case 'array': 
                $first = $this->elements[0];
                $temp = [];
                for ($i = 1; $i < $this->count; $i++) {
                    $temp[] = $this->elements[$i];
                }
                $this->elements = $temp;
                break;
            
            case 'Node':
                $first = $this->elements->popStart();
                break;

            default: throw new UnexpectedValueException("UNREACHABLE!!");
        }
                
        $this->count--;
        
        return $first;
    }

    public function size()
    {
        return $this->count;
    }

    public function isEmpty()
    {
        return match (get_debug_type($this->elements)) {
            'array' => empty($this->elements),
            'Node' => $this->elements->isEmpty(),
        };
    }

    public function top(): int
    {
        return match (get_debug_type($this->elements)) {
            'array' => $this->elements[0],
            'Node' => $this->elements->first()->value,
        };
    }

    public function __toString(): string
    {
        $s = '';
        switch(get_debug_type($this->elements)){
            case 'array':
                $s = "[";
                for($i = 0; $i < $this->count; $i++) {
                    $s .= $this->elements[$i];
                    if($i !== $this->count - 1) $s .= ",";
                }
                $s .= "]\n";
                break;
            
            case 'Node':
                $s = $this->elements->__toString();
                break;
            
            default: throw new UnexpectedValueException("UNREACHABLE!!");
        }
        return $s;
    }
}