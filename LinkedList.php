<?php
declare(strict_types=1);

class Node
{
    public private(set) ?int $value;
    private ?Node $next = null;
    
    public function __construct(?int $v = null)
    {
        $this->value = $v;
    }

    public function isEmpty(): bool
    {
        return $this->value === null ? true : false;
    }

    public function push(int $new): void
    {
        if($this->fillFirstIfEmpty($new)){
            return;
        }
        $n = &$this;
        while($n->next !== null) $n = $n->next;
        $newNode = new Node($new);
        $n->next = $newNode;
    }

    public function pushStart(int $new): void
    {
        if($this->fillFirstIfEmpty($new)){
            return;
        }
        $n = &$this;
        $newNode = new Node($this->value);
        $newNode->next = $this->next;
        $n->value = $new;
        $n->next = $newNode;
    }

    public function first(): Node
    {
        if($this->isEmpty()){
            throw new UnderflowException("The Stack is empty!\n");
        }
        return $this;
    }

    public function last(): Node
    {
        if($this->isEmpty()){
            throw new UnderflowException("The Stack is empty!\n");
        }
        $n = $this;
        while($n->next !== null) $n = &$n->next;
        return $n;
    }

    public function popEnd(): int
    {
        $n = $this->last();
        $val = $n->value;
        $n = null;
        return $val;
    }

    public function popStart(): int
    {
        $val = $this->first()->value;
        $this->value = $this->next->value;
        $this->next = $this->next->next;
        return $val;
    }

    public function at(int $index): Node|null
    {
        $n = $this;
        for($i = 0; $i <= $index && $n?->next !== null; $i++){
            $n = &$n->next;
        }
        return $n;
    }

    private function fillFirstIfEmpty(int $new): bool
    {
        if($this->isEmpty()){
            $this->value = $new;
            return true;
        }
        return false;
    }

    public function __toString(): string
    {
        $s = "";
        $node = $this;
        while($node !== null) {
            $s .= $node->value;
            if($node->next !== null) $s .= "->";
            $node = $node->next;
        }
        return $s . "\n";
    }
}

