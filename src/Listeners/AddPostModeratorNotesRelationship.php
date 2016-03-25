<?php

namespace Datitisev\ModeratorNotes\Listeners;

use Flarum\Api\Controller;
use Flarum\Api\Serializer\PostSerializer;
use Flarum\Core\Post;
use Flarum\Event\ConfigureApiController;
use Flarum\Event\GetApiRelationship;
use Flarum\Event\GetModelRelationship;
use Flarum\Event\PostWasDeleted;
use Flarum\Event\PrepareApiData;
use Datitisev\ModeratorNotes\Api\Controller\CreateModeratorNoteController;
use Datitisev\ModeratorNotes\Api\Serializer\ModeratorNoteSerializer;
use Datitisev\ModeratorNotes\ModeratorNotes;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Eloquent\Collection;

class AddPostModeratorNotesRelationship {

    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(GetModelRelationship::class, [$this, 'getModelRelationship']);
        $events->listen(PostWasDeleted::class, [$this, 'postWasDeleted']);
        $events->listen(GetApiRelationship::class, [$this, 'getApiRelationship']);
        $events->listen(ConfigureApiController::class, [$this, 'includeModeratorNotesRelationship']);
        $events->listen(PrepareApiData::class, [$this, 'prepareApiData']);
    }

    /**
     * @param GetModelRelationship $event
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|null
     */
    public function getModelRelationship(GetModelRelationship $event)
    {
        if ($event->isRelationship(Post::class, 'moderatornotes')) {
            return $event->model->hasMany(ModeratorNotes::class, 'post_id');
        }
    }

    /**
     * @param PostWasDeleted $event
     */
    public function postWasDeleted(PostWasDeleted $event)
    {
        $event->post->moderatornotes()->delete();
    }

    /**
     * @param GetApiRelationship $event
     * @return \Tobscure\JsonApi\Relationship|null
     */
    public function getApiRelationship(GetApiRelationship $event)
    {
        if ($event->isRelationship(PostSerializer::class, 'moderatorNotes')) {
            return $event->serializer->hasMany($event->model, ModeratorNoteSerializer::class, 'moderatorNotes');
        }
    }

    /**
     * @param ConfigureApiController $event
     */
    public function includeModeratorNotesRelationship(ConfigureApiController $event)
    {
        if ($event->isController(Controller\ShowDiscussionController::class)) {
            $event->addInclude([
                'posts.moderatorNotes',
                'posts.moderatorNotes.user'
            ]);
        }

        if ($event->isController(Controller\ListPostsController::class)
            || $event->isController(Controller\ShowPostController::class)) {
            $event->addInclude([
                'moderatorNotes',
                'moderatorNotes.user'
            ]);
        }
    }

    /**
     * @param PrepareApiData $event
     */
    public function prepareApiData(PrepareApiData $event)
    {
        // For any API action that allows the 'moderatorNotes' relationship to be
        // included, we need to preload this relationship onto the data (Post
        // models) so that we can selectively expose only the moderator notes that the
        // user has permission to view.
        if ($event->isController(Controller\ShowDiscussionController::class)) {
            $posts = $event->data->getRelation('posts');
        }

        if ($event->isController(Controller\ListPostsController::class)) {
            $posts = $event->data->all();
        }

        if ($event->isController(Controller\ShowPostController::class)) {
            $posts = [$event->data];
        }

        if ($event->isController(CreateModeratorNoteController::class)) {
            $posts = [$event->data->post];
        }

        if (isset($posts)) {
            $actor = $event->request->getAttribute('actor');
            $postsWithPermission = [];

            foreach ($posts as $post) {
                if (is_object($post)) {
                    $post->setRelation('moderatorNotes', null);

                    if ($actor->can('viewModeratorNotes', $post->discussion)) {
                        $postsWithPermission[] = $post;
                    }
                }
            }

            if (count($postsWithPermission)) {
                (new Collection($postsWithPermission))
                    ->load('moderatorNotes', 'moderatorNotes.user');
            }
        }
    }

}
