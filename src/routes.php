<?php

return [
    '~^articles/(\d+)$~' => [\my_project\controllers\ArticleController::class, 'view'],
    '~^articles/(\d+)/edit$~' => [\my_project\controllers\ArticleController::class, 'edit'],
    '~^articles/add$~' => [\my_project\controllers\ArticleController::class, 'add'],
    '~^$~' => [\my_project\controllers\MainController::class, 'main'],
];
?>