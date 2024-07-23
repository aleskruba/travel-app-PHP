<h1>TEST</h1>

<?php
    
    class Product
    {
        public $name = 'Soup';
        public $price ;
    
    public function getPrice($tax){
        return $this->price / 100 + $tax;
    }
    }

    $product =  new Product();
    $product->name  = 'dinner';
    $product->price  = 200;

 $productPrice = $product->getPrice(20);
 var_dump($productPrice).PHP_EOL;
 echo 'test';
?>