<?php

namespace App\Model\Entity;

use App\Utils\Utilities;
use WilliamCosta\DatabaseManager\Database;

class Category
{

    /**
     * Category id
     * @var integer
     */
    public $id;

    /**
     * Category name
     * @var string
     */
    public $name;

    /**
     * Category description
     * @var string
     */
    public $description;

    /**
     * Category created date
     * @var string
     */
    public $date;

    /**
     * Category image name
     * @var string
     */
    public $img;

    /**
     * Method to return an Category using the name
     * @param string $name
     * @return Category
     */
    public static function getCategoryByName($name)
    {
        return (new Database('`tb_categories`'))->select('name = "' . $name . '"')->fetchObject(self::class);
    }

    /**
     * Method to return an Category using the id
     * @param integer $id
     * @return Category
     */
    public static function getCategoryById($id)
    {
        return (new Database('`tb_categories`'))->select('id = "' . $id . '"')->fetchObject(self::class);
    }

    /**
     * Method to return all categories as object
     * @return Category multiple
     */
    public static function getAllCategories(){
        return (new Database('`tb_categories`'))->select()->fetchObject(self::class);
    }

    /**
     * Method to update in db with the actual instance
     */
    public function updateWithImg($actual_image, $new_image)
    {
        Utilities::deleteFile($actual_image, 'categories/');
        
        // UPDATE CATEGORY
        return (new Database('`tb_categories`'))->update('id = ' . $this->id, [
            'name' => $this->name,
            'description' => $this->description,
            'img' => $new_image,
        ]);
    }

    /**
     * Method to update in db with the actual instance
     */
    public function update()
    {
        // UPDATE CATEGORY
        return (new Database('`tb_categories`'))->update('id = ' . $this->id, [
            'name' => $this->name,
            'description' => $this->description,
            'img' => $this->img,
        ]);
    }

    /**
     * Method to delete in db with the actual instance
     */
    public function delete()
    {
        Utilities::deleteFile($this->img, 'categories/');
        // DELETE CATEGORY
        return (new Database('`tb_categories`'))->delete('id = ' . $this->id);
    }


    /**
     * Register Category method
     */
    public function register($img_name, $name, $description)
    {

        // DEFINE DATA
        $this->name = $name;
        $this->description = $description;
        $this->date = date('Y-m-d H:i:s');
        $this->img = $img_name;

        // INSERT CATEGORY ON DB
        $this->id = (new Database('`tb_categories`'))->insert([
            'name' => $this->name,
            'description' => $this->description,
            'date' => $this->date,
            'img' => $this->img
        ]);

        return true;
    }
}
