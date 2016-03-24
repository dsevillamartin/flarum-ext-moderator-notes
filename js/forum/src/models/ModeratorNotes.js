import Model from 'flarum/Model';
// import mixin from 'flarum/utils/mixin';

class ModeratorNotes extends Model {};

Object.assign(ModeratorNotes.prototype, {
  type: Model.attribute('type'),
  reason: Model.attribute('reason'),
  reasonDetail: Model.attribute('reasonDetail'),
  time: Model.attribute('time', Model.transformDate),

  post: Model.hasOne('post'),
  user: Model.hasOne('user')
});

export default ModeratorNotes;
