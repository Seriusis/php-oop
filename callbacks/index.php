<?php


class Product{
    public $name;
    public $price;

    public function __construct($name, $price)
    {
        $this->name = $name;
        $this->price = $price;
    }
}

class ProcessSale{
    private $callbacks;

    public function registerCallback(callable $func){
        if (is_callable($func)){
            $this->callbacks[] = $func;
        }
    }

    public function sale(Product $product){
        print "{$product->name} is handling now </br>";
        foreach ($this->callbacks as $callback){
            call_user_func($callback, $product);
        }
    }
}


//declare anonymous user function
$logger = function ($product){
  print "writing {$product->name}\r\n</br>";
};

$processor = new ProcessSale();

//register user function to class Product
$processor->registerCallback($logger);

//user fuction will be executiong as callback
$processor->sale(new Product('PS4', 7800));


