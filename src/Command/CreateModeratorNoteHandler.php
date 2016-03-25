<?php

namespace Datitisev\ModeratorNotes\Command;

use Flarum\Core\Access\AssertPermissionTrait;
use Flarum\Core\Post\CommentPost;
use Flarum\Core\Repository\PostRepository;
use Tobscure\JsonApi\Exception\InvalidParameterException;

class CreateModeratorNoteHandler
{
    use AssertPermissionTrait;

    /**
     * @var PostRepository
     */
    protected $posts;

    /**
     * @param PostRepository $posts
     */
    public function __construct(PostRepository $posts)
    {
        $this->posts = $posts;
    }

    /**
     * @param CreateFlag $command
     *
     * @throws InvalidParameterException
     *
     * @return ModeratorNote
     */
    public function handle(CreateModeratorNote $command)
    {
        $actor = $command->actor;
        $data = $command->data;

        $postId = array_get($data, 'relationships.post.data.id');
        $post = $this->posts->findOrFail($postId, $actor);

        if (!($post instanceof CommentPost)) {
            throw new InvalidParameterException();
        }

        $this->assertCan($actor, 'moderatePost', $post);

        ModeratorNote::unguard();

        $moderatorNote = ModeratorNote::firstOrNew([
            'post_id' => $post->id,
            'user_id' => $actor->id,
        ]);

        $moderatorNote->post_id = $post->id;
        $moderatorNote->user_id = $actor->id;
        $moderatorNote->type = 'user';
        $moderatorNote->reason = array_get($data, 'attributes.reason');
        $moderatorNote->reason_detail = array_get($data, 'attributes.reasonDetail');
        $moderatorNote->time = time();

        $moderatorNote->save();

        return $moderatorNote;
    }
}
