<?php


namespace Datitisev\ModeratorNotes\Api\Controller;

use Flarum\Api\Controller\AbstractDeleteController;
use Datitisev\ModeratorNotes\Command\DeleteModeratorNotes;
use Illuminate\Contracts\Bus\Dispatcher;
use Psr\Http\Message\ServerRequestInterface;


class DeleteModeratorNotes extends AbstractDeleteController
{
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
    protected function delete(ServerRequestInterface $request)
    {
        $this->bus->dispatch(
            new DeleteModeratorNotes(array_get($request->getQueryParams(), 'id'), $request->getAttribute('actor'), $request->getParsedBody())
        );
    }
}
