<?php

namespace Datitisev\ModeratorNotes\Api\Serializer;

use Flarum\Api\Serializer\AbstractSerializer;
use Flarum\Api\Serializer\PostSerializer;
use Flarum\Api\Serializer\UserBasicSerializer;

class ModeratorNoteSerializer extends AbstractSerializer
{
    /**
     * {@inheritdoc}
     */
    protected $type = 'moderatorNotes';

    /**
     * {@inheritdoc}
     */
    protected function getDefaultAttributes($moderatorNotes)
    {
        return [
            'type'         => $moderatorNotes->type,
            'reason'       => $moderatorNotes->reason,
            'reasonDetail' => $moderatorNotes->reason_detail,
            'time'         => $this->formatDate($moderatorNotes->time),
        ];
    }

    /**
     * @return \Tobscure\JsonApi\Relationship
     */
    protected function post($moderatorNotes)
    {
        return $this->hasOne($moderatorNotes, PostSerializer::class);
    }

    /**
     * @return \Tobscure\JsonApi\Relationship
     */
    protected function user($moderatorNotes)
    {
        return $this->hasOne($moderatorNotes, UserBasicSerializer::class);
    }
}
