import app from 'flarum/app';
import Model from 'flarum/Model';

import ModeratorNotes from 'datitisev/moderator-notes/models/ModeratorNotes'
import addModerateAction from 'datitisev/moderator-notes/addModerateAction';

app.initializers.add('datitisev-moderator-notes', () => {

  app.store.models.posts.prototype.moderatorNotes = Model.hasMany('moderatorNotes');
  app.store.models.posts.prototype.canModerate = Model.hasMany('canModerate');

  app.store.models.moderatorNotes = ModeratorNotes;

  addModerateAction();

});
