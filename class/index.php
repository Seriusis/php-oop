<?php

trait PriceUtils{
    private $taxrate = 20;
    public  function double():string {
        return 'double function from PricelUtils';
    }

    public function calculateTax(float $price):float {
        return $this->taxrate/100*$price;
    }
}

trait generalUtils{
    public static  function double():string {
        return 'double function from generalUtils';
    }
     public function debug($data){
        print_r('<pre>');
        print_r($data);
        print_r('</pre>');
    }
    abstract function test1():string;
}

abstract class ShopProduct{
    use PriceUtils, GeneralUtils{
        PriceUtils::double insteadof GeneralUtils; //if method collisions - choouse main
        GeneralUtils::double as generalDouble; //alias
    }
    public $type;
    public $price;
    public $name;

    public function __construct(string $type, string $name, float $price)
    {

        $this->type = $type;
        $this->name = $name;
        $this->price = $price;
    }

    public static function create($type, $name, $price){
        return new static($type, $name, $price);
    }

    public function getPrice():float {// >= php 7.1
        return $this->price+$this->calculateTax($this->price);
    }
    public function test1()
    {
        // TODO: Implement test1() method.

    }

}

    interface ProductPhone{
        //write all methods (interface)
        public function getArrtibutes();
    }





class Phone extends ShopProduct implements ProductPhone {
    public function __construct($type, $name, $price)
    {
        parent::__construct($type, $name, $price);
    }


    public function getArrtibutes()
    {
        // TODO: Implement getArrtibutes() method.
    }


}
class Book extends ShopProduct{

}

//$phone = new Phone('phone', 'iPhone 5c', 600);
$phone = Phone::create('phone', 'iPhone 5c', 600);
$book = Book::create('book', 'PHP OOP Zandstra 2019', 680);
function printPhone(ProductPhone $phone){
    var_dump($phone);
}


//var_dump($phone);
//var_dump($phone->double());
//var_dump($phone->generalDouble());
//
//
//var_dump($book->getPrice());




?>