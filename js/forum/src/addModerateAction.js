import { extend } from 'flarum/extend';
import app from 'flarum/app';
import Button from 'flarum/components/Button';
import CommentPost from 'flarum/components/CommentPost';

import ModeratePostModal from 'datitisev/moderator-notes/components/ModeratorNotesPostModal'

export default function () {

  extend(CommentPost.prototype, 'actionItems', function(items) {

    const post = this.props.post;
    console.log(post);

    items.add('moderator-notes', Button.component({
      children: app.translator.trans('datitisev-moderator-notes.forum.post.moderate_button'),
      className: 'Button Button--link',
      onclick: () => {

        app.modal.show(new ModeratePostModal({post}));

      }
    }))
  });

}
