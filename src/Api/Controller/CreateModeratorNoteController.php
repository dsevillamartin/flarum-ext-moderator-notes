<?php

/*
 * (c) David Sevilla Martín <dsevilla192@icloud.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Datitisev\ModeratorNotes\Api\Controller;

use Datitisev\ModeratorNotes\ModeratorNotes;
use Flarum\Api\Controller\AbstractCreateController;
//use Datitisev\ModeratorNotes\Api\Serializer\ModeratorNoteSerializer;
//use Datitisev\ModeratorNotes\Command\CreateModeratorNote;
use Illuminate\Contracts\Bus\Dispatcher;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class CreateModeratorNoteController extends AbstractCreateController
{
    /**
     * {@inheritdoc}
     */
    public $serializer = ModeratorNoteSerializer::class;

    /**
     * {@inheritdoc}
     */
    public $include = [
        'post',
        'post.moderatorNotes',
    ];

    /**
     * @var Dispatcher
     */
    protected $bus;

    /**
     * @param Dispatcher $bus
     */
    public function __construct(Dispatcher $bus)
    {
        $this->bus = $bus;
    }

    /**
     * {@inheritdoc}
     */
    protected function data(ServerRequestInterface $request, Document $document)
    {
        return $this->bus->dispatch(
            new CreateModeratorNote($request->getAttribute('actor'), array_get($request->getParsedBody(), 'data', []))
        );
    }
}
