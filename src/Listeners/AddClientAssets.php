<?php

namespace Datitisev\ModeratorNotes\Listeners;

use DirectoryIterator;
use Flarum\Event\ConfigureClientView;
use Flarum\Event\ConfigureLocales;
use Illuminate\Contracts\Events\Dispatcher;


class AddClientAssets {

    /**
     * Subscribes to the Flarum events.
     *
     * @param Dispatcher $events;
     */
    public function subscribe(Dispatcher $events) {
        $events->listen(ConfigureClientView::class, [$this, 'addAssets']);
        $events->listen(ConfigureLocales::class, [$this, 'addLocales']);
    }

    /**
     * Modifies the client view for the Forum
     *
     * @param ConfigureClientView $event;
     */
    public function addAssets(ConfigureClientView $event) {
        if ($event->isForum()) {
            $event->addAssets([
                __DIR__.'/../../js/forum/dist/extension.js'
            ]);
            $event->addBootstrapper('datitisev/moderator-notes/main');
        }
    }

    /**
     * Adds Locales, or Language, to extension
     *
     * @param ConfigureLocales $event
     */
    public function addLocales(ConfigureLocales $event) {
        foreach (new DirectoryIterator(__DIR__.'/../../locale') as $file) {
            app('log')->debug('File Extension:');
            app('log')->debug($file->getExtension());
            if ($file->isFile() && in_array($file->getExtension(), ['yml', 'yaml'])) {
                app('log')->debug('The check for the file ' . $file . ' passed!');
                $event->locales->addTranslations($file->getBasename('.'.$file->getExtension()), $file->getPathname());
            }
        }
    }

}
