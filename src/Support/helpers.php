<?php

use Domain\Catalog\Filters\FilterManager;
use Support\Flash\Flash;

if (!function_exists('flash')) {
    function flash(): Flash
    {
        // NOTE: делаю для того, чтобы
        // вернуть класс с инъекцией слоя, который задал в construct
        // чтобы работало, нужно подключить к composer.json
        // сделать обновление composer dump-autoload
        return app(Flash::class);
    }
}

if (!function_exists('filters')) {
    function filters(): array
    {
        return app(FilterManager::class)->items();
    }
}
