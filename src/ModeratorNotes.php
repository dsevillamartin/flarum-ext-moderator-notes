<?php

namespace  Datitisev\ModeratorNotes;

use Flarum\Core\Post;
use Flarum\Core\Support\ScopeVisibilityTrait;
use Flarum\Core\User;
use Flarum\Database\AbstractModel;

class ModeratorNotes extends AbstractModel {

    use ScopeVisibilityTrait;

    /**
     * {@inheritdoc}
     */
    protected $table = 'moderatorNotes';


    /**
     * {@inheritdoc}
     */
    protected $dates = ['time'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post() {
        return $this->belongsTo(Post::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

}
