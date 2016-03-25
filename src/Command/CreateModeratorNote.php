<?php

namespace Datitisev\ModeratorNotes\Command;

use Flarum\Core\User;

class CreateModeratorNote
{
    /**
     * The user performing the action.
     *
     * @var User
     */
    public $actor;

    /**
     * The attributes of the new moderator note.
     *
     * @var array
     */
    public $data;

    /**
     * @param User  $actor The user performing the action.
     * @param array $data  The attributes of the new moderator note.
     */
    public function __construct(User $actor, array $data)
    {
        $this->actor = $actor;
        $this->data = $data;
    }
}
