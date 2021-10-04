<?php
namespace my_project\controllers;
use my_project\view\View;
use my_project\models\articles\Article;

class MainController{
    private $view;
    private  $db;

    public function __construct(){
        $this->view = new View(__DIR__.'/../../templates');
    } 
    
    public function main(){
        $articles = Article::findAll();
        $this->view->renderHtml('main/main.php', ['articles' => $articles]);
    }

    public function sayHello(string $name){
        $this->view->renderHtml('main/hello.php', ['name' => $name]);
    }
}
?>