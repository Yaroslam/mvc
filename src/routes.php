<?php

return [
    '~^articles/(\d+)$~' => [\my_project\controllers\ArticleController::class, 'view'],
    '~^$~' => [\my_project\controllers\MainController::class, 'main'],
];
?>