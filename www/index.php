<?php
    spl_autoload_register(function (string $className){
        require_once __DIR__.'/../src/'.str_replace('\\', '/', $className).'.php';
    });

   
   $route=$_GET['route'] ?? '';
   $routes=require __DIR__.'/../src/routes.php';

   $isRoteFound=false;
   foreach($routes as $pattern => $controllerAndAction){
      preg_match($pattern, $route, $matches); 
      if (!empty($matches)){
        $isRoteFound=true;  
        break;
      }
    }
    if (!$isRoteFound) echo 'Страница не найдена!';

   $controllerName=$controllerAndAction[0];
   $actionName=$controllerAndAction[1];
    unset($matches[0]);
    
   $controller=new $controllerName();
   $controller->$actionName(...$matches);

?>