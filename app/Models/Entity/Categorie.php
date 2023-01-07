<?php

namespace App\Models\Entity;

use App\Utils\Utilities;
use WilliamCosta\DatabaseManager\Database;

class Categorie{

    /**
     * Categorie id
     * @var integer
     */
    public $id;

    /**
     * Categorie name
     * @var string
     */
    public $name;

    /**
     * Categorie description
     * @var string
     */
    public $description;

    /**
     * Categorie created date
     * @var string
     */
    public $date;

    /**
     * Categorie image name
     * @var string
     */
    public $img;

    /**
     * Register Categorie method
     */
    public function register($request){
        // POST DATA
        $postVars = $request->getPostVars();
        $postFiles = $request->getPostFiles();
        //DEFINE DATA
        $obUtilities = new Utilities;
        $this->name = $postVars['name'];
        $this->description = $postVars['description'];
        if($obUtilities->validateImage($postFiles['file'])){
            $upload = $obUtilities->uploadFile($postFiles['file'],'categories/');
        }
        $this->date = date('Y-m-d H:i:s');
        $this->img = $upload;

        // INSERT CATEGORIE ON DB
        $this->id = (new Database('tb_categories'))->insert([
            'name' => $this->name,
            'description' => $this->description,
            'date' => $this->date,
            'img' => $this->img
        ]);

        return true;
    }

}