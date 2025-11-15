<?php
declare(strict_types=1);

class Queue
{
    public int $size;
    private int $count = 0;
    private array|Node $elements;
    
    public function __construct(int $s, array|Node $type) {
        $this->size = $s;
        $this->elements = $type;
    }

    public function enqueue(int $element): void
    {
        if($this->count < $this->size) {
            switch(get_debug_type($this->elements)){
                case 'array': 
                    $this->elements = [...$this->elements, $element];
                    break;
                
                case 'Node':
                    $this->elements->push($element);
                    break;
                
                default: throw new UnexpectedValueException("UNREACHABLE!!");
            }
            $this->count++;
        }else {
            throw new OverflowException(sprintf("Queue(%d) is full. Cannot add elements.", $this->size));
        }        
    }

    public function dequeue(): int
    {
        $last = null;
        switch(get_debug_type($this->elements))
        {
            case 'array':
                $last = $this->elements[$this->count - 1];
                $temp = [];
                for($i = 0; $i < $this->count - 1; $i++){
                    $temp[] = $this->elements[$i];
                }
                $this->elements = $temp;
                break;

            case 'Node':
                $last = $this->elements->popEnd();
                break;
            
            default: throw new UnexpectedValueException("UNREACHABLE!!\n");
        }

        $this->count--;

        return $last;
    }

    public function peek(): int
    {
        return match(get_debug_type($this->elements))
        {
            'array' => $this->elements[0],
            'Node' => $this->elements->first()->value,
        };
    }
    
    public function end(): int
    {
        return match(get_debug_type($this->elements))
        {
            'array' => $this->elements[$this->count - 1],
            'Node' => $this->elements->last()->value,
        };
    }

    public function isEmpty(): bool
    {
        return match(get_debug_type($this->elements))
        {
            'array' => empty($this->elements),
            'Node' => $this->elements->isEmpty(),
        };
    }

    public function isFull(): bool
    {
        return match(get_debug_type($this->elements))
        {
            'array' => count($this->elements) === $this->count,
            'Node' => $this->elements->count() === $this->count,
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