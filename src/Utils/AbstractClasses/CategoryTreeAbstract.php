<?php


namespace App\Utils\AbstractClasses;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class CategoryTreeAbstract
{

    public $categoriesArrayFromDb;
    public $categoryLst;
    protected static $dbconnection;


    public function __construct(EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator)
    {
        $this->entitymanager = $entityManager;
        $this->urlgenetator = $urlGenerator;
        $this->categoriesArrayFromDb = $this->getCategories();

    }

    abstract public function getCategoryList(array $categories_array);


    public function buildTree(int $parent_id = null):array
    {

        $subcategory = [];

        foreach($this->categoriesArrayFromDb as $category)
        {
            if($category['parent_id'] == $parent_id)
            {
                $children = $this->buildTree($category['id']);
                {
                    $category['children'] = $children;

                }
                $subcategory[] = $category;
            }
        }

        return $subcategory;
    }




    private function getCategories()
    {
        if (self::$dbconnection)
        {
            return self::$dbconnection;
        }

        else

        {
            $conn = $this->entitymanager->getConnection();
            $sql = "SELECT * FROM categories";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return self::$dbconnection = $stmt->fetchAll();
        }

    }




}


