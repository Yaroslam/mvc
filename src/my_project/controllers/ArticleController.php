<?php
namespace my_project\controllers;
use my_project\view\View;
use my_project\models\articles\Article;
use my_project\models\users\User;

class ArticleController{
    private $view;

    public function edit(int $id):void {
        $article = Article::getById($id);
        $article->set_name("name");
        $article->set_text("text");
        if ($article === []){
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }
    }

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

    public function add(): void{
        $author = User::getById(1);

        $article = new Article();
        $article->set_text("text");
        $article->set_name("name");





    }
    
}
