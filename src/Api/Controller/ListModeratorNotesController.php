<?php

namespace Datitisev\ModeratorNotes\Api\Controller;

use Flarum\Api\Controller\AbstractCollectionController;
use Datitisev\ModeratorNotes\Api\Serializer\ModeratorNoteSerializer;
use Datitisev\ModeratorNotes\ModeratorNotes;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;


class ListModeratorNotesController extends AbstractCollectionController
{
    /**
     * {@inheritdoc}
     */
    public $serializer = ModeratorNoteSerializer::class;

    /**
     * {@inheritdoc}
     */
    public $include = [
        'user',
        'post',
        'post.user',
        'post.discussion'
    ];

    /**
     * {@inheritdoc}
     */
    protected function data(ServerRequestInterface $request, Document $document)
    {
        $actor = $request->getAttribute('actor');
        $actor->moderatorNotes_read_time = time();
        $actor->save();
        return Flag::whereVisibleTo($actor)
            ->with($this->extractInclude($request))
            ->latest('moderatorNotes.time')
            ->groupBy('post_id')
            ->get();
    }
}
