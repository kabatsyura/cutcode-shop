<?php

use App\Support\Flash\Flash;

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
