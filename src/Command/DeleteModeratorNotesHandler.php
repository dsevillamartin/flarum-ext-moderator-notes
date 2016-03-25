<?php

/*
 * (c) David Sevilla Martín <dsevilla192@icloud.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Datitisev\ModeratorNotes\Command;

use Datitisev\ModeratorNotes\Event\ModeratorNotesWillBeDeleted;
use Flarum\Core\Access\AssertPermissionTrait;
use Flarum\Core\Repository\PostRepository;
use Illuminate\Contracts\Events\Dispatcher;

class DeleteModeratorNotesHandler
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
     * @param Dispatcher     $events
     */
    public function __construct(PostRepository $posts, Dispatcher $events)
    {
        $this->posts = $posts;
        $this->events = $events;
    }

    /**
     * @param DeleteModeratorNotes $command
     *
     * @return ModeratorNotes
     */
    public function handle(DeleteModeratorNotes $command)
    {
        $actor = $command->actor;
        $post = $this->posts->findOrFail($command->postId, $actor);
        $this->assertCan($actor, 'viewModeratorNotes', $post->discussion);
        $this->events->fire(new ModeratorNotesWillBeDeleted($post, $actor, $command->data));
        $post->moderatorNotes()->delete();

        return $post;
    }
}
