<?php

/*
 * (c) David Sevilla Martín <dsevilla192@icloud.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Datitisev\ModeratorNotes\Listeners;

use Datitisev\ModeratorNotes\ModeratorNotes;
use Flarum\Api\Serializer\CurrentUserSerializer;
use Flarum\Api\Serializer\ForumSerializer;
use Flarum\Api\Serializer\PostSerializer;
use Flarum\Core\User;
use Flarum\Event\ConfigureApiRoutes;
use Flarum\Event\ConfigureModelDates;
use Flarum\Event\PrepareApiAttributes;
use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Contracts\Events\Dispatcher;

class AddModeratorNotesApi
{
    /**
     * @var SettingsRepositoryInterface
     */
    protected $settings;

    /**
     * @param SettingsRepositoryInterface $settings
     */
    public function __construct(SettingsRepositoryInterface $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(ConfigureModelDates::class, [$this, 'configureModelDates']);
        $events->listen(PrepareApiAttributes::class, [$this, 'prepareApiAttributes']);
        $events->listen(ConfigureApiRoutes::class, [$this, 'configureApiRoutes']);
    }

    /**
     * @param ConfigureModelDates $event
     */
    public function configureModelDates(ConfigureModelDates $event)
    {
        if ($event->isModel(User::class)) {
            $event->dates[] = 'moderatorNotes_read_time';
        }
    }

    /**
     * @param PrepareApiAttributes $event
     */
    public function prepareApiAttributes(PrepareApiAttributes $event)
    {
        if ($event->isSerializer(ForumSerializer::class)) {
            $event->attributes['canViewModeratorNotes'] = $event->actor->hasPermissionLike('discussion.viewModeratorNotes');
            if ($event->attributes['canViewModeratorNotes']) {
                $event->attributes['moderatorNotesCount'] = (int) $this->getModeratorNotesCount($event->actor);
            }
//            $event->attributes['guidelinesUrl'] = $this->settings->get('flarum-flags.guidelines_url');
        }
        if ($event->isSerializer(CurrentUserSerializer::class)) {
            $event->attributes['newModeratorNotesCount'] = (int) $this->getNewModeratorNotesCount($event->model);
        }
        if ($event->isSerializer(PostSerializer::class)) {
            $event->attributes['canModerateNotes'] = $event->actor->can('moderateNotes', $event->model);
        }
    }

    /**
     * @param ConfigureApiRoutes $event
     */
    public function configureApiRoutes(ConfigureApiRoutes $event)
    {
        $event->get('/moderatorNotes', 'moderatorNotes.index', Controller\ListModeratorNotesController::class);
        $event->post('/moderatorNotes', 'moderatorNotes.create', Controller\CreateModeratorNoteController::class);
        $event->delete('/posts/{id}/moderatorNotes', 'moderatorNotes.delete', Controller\DeleteModeratorNotesController::class);
    }

    /**
     * @param User $actor
     *
     * @return int
     */
    protected function getModeratorNotesCount(User $actor)
    {
        return ModeratorNotes::whereVisibleTo($actor)->distinct()->count('moderatorNotes.post_id');
    }

    /**
     * @param User $actor
     *
     * @return int
     */
    protected function getNewModeratorNotesCount(User $actor)
    {
        $query = ModeratorNotes::whereVisibleTo($actor);
        if ($time = $actor->moderatorNotes_read_time) {
            $query->where('moderatorNotes.time', '>', $time);
        }

        return $query->distinct()->count('moderatorNotes.post_id');
    }
}
