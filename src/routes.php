<?php

return [
    '~^articles/(\d+)$~' => [\my_project\controllers\ArticleController::class, 'view'],
    '~^articles/(\d+\)$~' => [\my_project\controllers\ArticleController::class, 'edit'],
    '~^$~' => [\my_project\controllers\MainController::class, 'main'],
];
?>