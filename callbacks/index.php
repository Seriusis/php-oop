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



//anonymous user function
$logger = function ($product){
  print "writing {$product->name}</br>";
};

//class method
class Actions{
    public function someAction(Product $product){
        print "some action with {$product->name}</br>";
    }
}

//class, which observs for amount of product sales
class PriceCounter{
    private static $maxAmount;

    public static function setMaxAmountForDiscount($amt){
        self::$maxAmount = $amt;
    }
    public static function calculateAmount(){
        $realAmount = 0;
        return function ($product) use (&$realAmount){ //use variable of parent closure inside callback
            $realAmount += $product->price;
            print "total: {$realAmount}";
            if($realAmount > self::$maxAmount) {
                print "</br>Products were sold in the amount of {$realAmount}, you may ask for the discount";
            }
        };
    }
}

$processor = new ProcessSale();

//register user function
$processor->registerCallback($logger);

//register class method
$processor->registerCallback([new Actions(), "someAction"]);

PriceCounter::setMaxAmountForDiscount(15000);

//register static method, which calculates amount of selling
$processor->registerCallback(PriceCounter::calculateAmount());

//user fuctions will be execute as callbacks
$processor->sale(new Product('PS4', 7800));

print_r('</br>');

$processor->sale(new Product('MacBook Pro', 10000));


