<?php

/*
 * (c) David Sevilla Martín <dsevilla192@icloud.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Datitisev\ModeratorNotes;

use Illuminate\Contracts\Events\Dispatcher;

return function (Dispatcher $events) {

    $events->subscribe(Listeners\AddClientAssets::class);
//    $events->subscribe(Listeners\AddModeratorNotesApi::class);
    $events->subscribe(Listeners\AddPostModeratorNotesRelationship::class);

};
