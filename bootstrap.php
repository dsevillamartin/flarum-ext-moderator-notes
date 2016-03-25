<?php

namespace Datitisev\ModeratorNotes;

use Illuminate\Contracts\Events\Dispatcher;

return function (Dispatcher $events) {

    $events->subscribe(Listeners\AddClientAssets::class);
};
