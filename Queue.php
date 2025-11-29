<?php
declare(strict_types=1);

class Queue
{
    private int $count = 0;
    private array|Node $elements;
    
    public function __construct(array|Node $type) {
        $this->elements = $type;
    }

    public function enqueue($element): void
    {
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
    }

    public function dequeue()
    {
        $last = null;
        switch(get_debug_type($this->elements))
        {
            case 'array':
                $last = $this->elements[0];
                $temp = [];
                for($i = 1; $i < $this->count; $i++){
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

    public function peek()
    {
        return match(get_debug_type($this->elements))
        {
            'array' => $this->elements[0],
            'Node' => $this->elements->first()->value,
        };
    }
    
    public function end()
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

    public function count(): int
    {
        return $this->count;
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