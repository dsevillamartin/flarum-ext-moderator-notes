<?php

namespace Datitisev\ModeratorNotes\Command;

use Flarum\Core\Access\AssertPermissionTrait;
use Flarum\Core\Repository\PostRepository;
use Datitisev\ModeratorNotes\Event\ModeratorNotesWillBeDeleted;
use Datitisev\ModeratorNotes\Flag;
use Illuminate\Contracts\Events\Dispatcher;

class DeleteFlagsHandler
{
    use AssertPermissionTrait;

    /**
     * @var PostRepository
     */
    protected $posts;

    /**
     * @var Dispatcher
     */
    protected $events;

    /**
     * @param PostRepository $posts
     * @param Dispatcher $events
     */
    public function __construct(PostRepository $posts, Dispatcher $events)
    {
        $this->posts = $posts;
        $this->events = $events;
    }

    /**
     * @param DeleteModeratorNotes $command
     * @return ModeratorNotes
     */
    public function handle(DeleteModeratorNotes $command)
    {
        $actor = $command->actor;
        $post = $this->posts->findOrFail($command->postId, $actor);
        $this->assertCan($actor, 'viewFlags', $post->discussion);
        $this->events->fire(new ModeratorNotesWillBeDeleted($post, $actor, $command->data));
        $post->moderatorNotes()->delete();
        return $post;
    }
}
