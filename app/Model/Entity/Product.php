<?php

namespace App\Model\Entity;

use App\Utils\Utilities;
use WilliamCosta\DatabaseManager\Database;

class Product
{

    /**
     * Product id
     * @var integer
     */
    public $id;

    /**
     * Product name
     * @var string
     */
    public $name;

    /**
     * Product description
     * @var string
     */
    public $description;

    /**
     * Product real price
     * @var integer
     */
    public $price;

    /**
     * Product price with discount
     * @var integer
     */
    public $discount_price;

    /**
     * Category of this product
     * @var integer
     */
    public $cat_id;

    /**
     * Product image name
     * @var string
     */
    public $img;

    /**
     * Product creation date
     */
    public $date;

    /**
     * Method to return an Product obj using the id
     * @param integer $id
     * @return Product
     */
    public static function getProductById($id)
    {
        return (new Database('`tb_products`'))->select('id = "' . $id . '"')->fetchObject(self::class);
    }

    /**
     * Method to return an Product obj using the name
     * @param string $name
     * @return Product
     */
    public static function getProductByName($name)
    {
        return (new Database('`tb_products`'))->select('name = "' . $name . '"')->fetchObject(self::class);
    }

    /**
     * Method to register a product
     * @return boolean
     */
    public function register()
    {
        // INSERT PRODUCT IN DB
        $this->id = (new Database('`tb_products`'))->insert([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'discount_price' => $this->discount_price,
            'cat_id' => $this->cat_id,
            'img' => $this->img,
            'date' => date('Y-m-d'),
        ]);

        return true;
    }

    /**
     * Method to update the product without update its image
     * @return Product
     */
    public function updateWithoutImage(){
        // UPDATE PRODUCT
        return (new Database('`tb_products`'))->update('id = ' . $this->id, [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'discount_price' => $this->discount_price,
            'cat_id' => $this->cat_id,
            'date' => $this->date,
        ]);
    }

    /**
     * Method to update the product with its image
     * @param string $actual_image
     * @param string $new_image
     * @return Product
     */
    public function updateWithImage($actual_image, $new_image){
        // DELETE ACTUAL PRODUCT IMAGE
        Utilities::deleteFile($actual_image, 'products/');
        // UPDATE PRODUCT
        return (new Database('`tb_products`'))->update('id = ' . $this->id, [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'discount_price' => $this->discount_price,
            'cat_id' => $this->cat_id,
            'date' => $this->date,
            'img' => $new_image,
        ]);
    }

    /**
     * Method to delete the product in the db and delete its image
     * @return boolean
     */
    public function delete()
    {
        // DELETE PRODUCT IMAGE
        Utilities::deleteFile($this->img, 'products/');
        // DELETE PRODUCT
        return (new Database('`tb_products`'))->delete('id = ' . $this->id);
    }
}
