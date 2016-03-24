<?php

namespace Datitisev\ModeratorNotes\Event;

use Flarum\Core\Post;
use Flarum\Core\User;

class ModeratorNotesWillBeDeleted
{
    /**
     * @var Post
     */
    public $post;
    /**
     *
     * @var User
     */
    public $actor;

    /**
     * @var array
     */
    public $data;

    /**
     * @param Post $post
     * @param User $actor
     * @param array $data
     */
    public function __construct(Post $post, User $actor, array $data = [])
    {
        $this->post = $post;
        $this->actor = $actor;
        $this->data = $data;
    }
}
