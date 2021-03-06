<?php


namespace App\Utils;


use App\Utils\AbstractClasses\CategoryTreeAbstract;

class CategoryTreeFrontPage extends CategoryTreeAbstract
{
    public function getCategoryList(array $categories_array)
    {
        $this->categoryLst .= '<ul>';
            foreach ($categories_array as $value)
            {
                $catName = $value['name'];
                $url = $this->urlgenetator->generate('video_list', ['categoryname'=>$catName, 'id'=>$value['id']]);
                $this->categoryLst .='<li>' . '<a href="' . $url . '">' . $catName . '</a>';

                if(!empty($value['children']))
                {
                    $this->getCategoryList($value['children']);
                }
            }


        $this->categoryLst .= '<ul>';

            return $this->categoryLst;
    }




}
