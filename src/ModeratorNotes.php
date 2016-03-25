<?php

/*
 * (c) David Sevilla Martín <dsevilla192@icloud.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace  Datitisev\ModeratorNotes;

use Flarum\Core\Post;
use Flarum\Core\Support\ScopeVisibilityTrait;
use Flarum\Core\User;
use Flarum\Database\AbstractModel;

class ModeratorNotes extends AbstractModel
{
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
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
