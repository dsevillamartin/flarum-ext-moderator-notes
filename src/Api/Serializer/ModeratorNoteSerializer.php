<?php

/*
 * (c) David Sevilla Martín <dsevilla192@icloud.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
