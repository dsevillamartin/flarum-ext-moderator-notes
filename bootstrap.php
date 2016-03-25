<?php

namespace Datitisev\ModeratorNotes;

use Flarum\Event\ConfigureClientView;
use Illuminate\Contracts\Events\Dispatcher;


return function (Dispatcher $events) {

    $events->subscribe(Listeners\AddClientAssets::class);
//    $events->subscribe(Listeners\AddModeratorNotesApi::class);
    $events->subscribe(Listeners\AddPostModeratorNotesRelationship::class);

};
