<?php
namespace my_project\controllers;
use my_project\view\View;
use my_project\models\articles\Article;

class ArticleController{
    private $view;

    public function __construct(){
        $this->view = new View(__DIR__.'/../../templates');
   
    }

    public function view(int $articleID){
        $result=Article::getById($articleID);
        
        if ($result === []){
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }
        $this->view->renderHtml
        ('articles/view.php', ['article' => $result]);
        
    }
    
}
