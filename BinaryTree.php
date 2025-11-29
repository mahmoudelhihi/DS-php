<?php
declare(strict_types=1);

class TreeNode
{
    public ?int $data = null;
    private ?TreeNode $left = null;
    private ?TreeNode $right = null;

    public function __construct()
    {
        $this->data = $this->left = $this->right = null;
    }

    public function setValue(int $d): TreeNode
    {
        $this->data = $d;
        return $this;
    }

    public function getValue(): int
    {
        return $this->data;
    }

    public function setRight(int $data): TreeNode
    {
        $n = &$this;
        $this->right = (new TreeNode)->setValue($data);
        $n = &$this->right;
        return $n;
    }
    
    public function setLeft(int $data): TreeNode
    {
        $n = &$this;
        $this->left = (new TreeNode)->setValue($data);
        $n = &$this->left;
        return $n;
    }

    /**
     * Left -> Node -> Right
     */
    public function inOrderTraversal(): array
    {
        // Using Morris Traversal:
        $n = $this;
        $r = [];
        while($n !== null){
            if($n->left === null){
                $r[] = $n->data;
                $n = $n->right;
            }else{
                $prev = $n->left;
                while($prev->right !== null && $prev->right !== $n) $prev = $prev->right;
                if($prev->right === null){
                    $prev->right = $n;
                    $n = $n->left;
                }else{
                    $prev->right = null;
                    $r[] = $n->data;
                    $n = $n->right;
                }
            }
        }
        return $r;
    }
    
    /**
     * Node -> Left -> Right
     */
    public function preOrderTraversal()
    {
        $n = $this;
        $r = [];
        while($n !== null){
            if($n->left === null){
                $r[] = $n->data;
                $n = $n->right;
            }else{
                $prev = $n->left;
                while($prev->right !== null && $prev->right !== $n) $prev = $prev->right;
                if($prev->right === null){
                    $prev->right = $n;
                    $r[] = $n->data;
                    $n = $n->left;
                }else{
                    $prev->right = null;
                    $n = $n->right;
                }
            }
        }
        return $r;
    }
    
    /**
     * Left -> Right -> Node
     */
    public function postOrderTraversal(): array
    {
        $n = $this;
        $r = [];
        while($n !== null){
            if($n->right === null){
                $r = [$n->data, ...$r];
                $n = $n->left;
            }else{
                $prev = $n->right;
                while($prev->left !== null && $prev->left !== $n) $prev = $prev->left;
                if($prev->left === null){
                    $r = [$n->data, ...$r];
                    $prev->left = $n;
                    $n = $n->right;
                }else{
                    $prev->left = null;
                    $n = $n->left;
                }
            }
        }
        return $r;
    }

    /**
     * each level from left to right
     * @return array<array>
     */
    public function levelOrderTraversal(): array
    {
        $q = new Queue([]);
        $r = [];
        $q->enqueue($this);
        $level = 0;
        while(!$q->isEmpty()){
            $count = $q->count();
            $r[] = [];
            for($_ = 0; $_ < $count; $_++){
                $n = $q->dequeue();
                $r[$level][] = $n->data;
                if($n->left !== null) $q->enqueue($n->left);
                if($n->right !== null) $q->enqueue($n->right);
            }
            $level++;
        }
        return $r;
    }

    public function __toString()
    {
        $s = '';
        $len = 1;
        $elements = $this->levelOrderTraversal();
        for($i = 0; $i < count($elements); $i++){
            $c = count($elements);
            $co = count($elements[$c - $i - 1]) - 1;
            echo str_repeat(" ", $co * $c * $len);
            for($j = 0; $j < count($elements[$i]); $j++){
                if($j > 0) echo str_repeat(" ", $c * (count($elements[$c - $i]) - 1) * $len);
                echo $elements[$i][$j] . " ";
            }
            echo PHP_EOL;
        }
        return $s;
    }
}