'use strict';

System.register('datitisev/moderator-notes/addModerateAction', ['flarum/extend', 'flarum/app', 'flarum/components/Button', 'flarum/components/CommentPost', 'datitisev/moderator-notes/components/ModeratorNotesPostModal'], function (_export, _context) {
  var extend, app, Button, CommentPost, ModeratePostModal;

  _export('default', function () {

    extend(CommentPost.prototype, 'actionItems', function (items) {

      var post = this.props.post;

      items.add('moderator-notes', Button.component({
        children: app.translator.trans('datitisev-moderator-notes.forum.post.moderate_button'),
        className: 'Button Button--link',
        onclick: function onclick() {

          app.modal.show(new ModeratePostModal({ post: post }));
        }
      }));
    });
  });

  return {
    setters: [function (_flarumExtend) {
      extend = _flarumExtend.extend;
    }, function (_flarumApp) {
      app = _flarumApp.default;
    }, function (_flarumComponentsButton) {
      Button = _flarumComponentsButton.default;
    }, function (_flarumComponentsCommentPost) {
      CommentPost = _flarumComponentsCommentPost.default;
    }, function (_datitisevModeratorNotesComponentsModeratorNotesPostModal) {
      ModeratePostModal = _datitisevModeratorNotesComponentsModeratorNotesPostModal.default;
    }],
    execute: function () {}
  };
});;
// import Page from 'flarum/components/Page';
//
// // import ModeratorNotesList from 'datitisev/moderator-notes/components/ModeratorNotesList';
//
// /**
//  * The `ModeratorNotesPage` component shows the moderation notes list. It is only
//  * used on mobile devices where the flags dropdown is within the drawer.
//  */
//
// export default class ModeratorNotesPage extends Page
"use strict";

System.register("datitisev/moderator-notes/components/ModeratorNotesPage", [], function (_export, _context) {
  return {
    setters: [],
    execute: function () {}
  };
});;
'use strict';

System.register('datitisev/moderator-notes/components/ModeratorNotesPostModal', ['flarum/components/Modal', 'flarum/components/Button'], function (_export, _context) {
  var Modal, Button, ModeratePostModal;
  return {
    setters: [function (_flarumComponentsModal) {
      Modal = _flarumComponentsModal.default;
    }, function (_flarumComponentsButton) {
      Button = _flarumComponentsButton.default;
    }],
    execute: function () {
      ModeratePostModal = function (_Modal) {
        babelHelpers.inherits(ModeratePostModal, _Modal);

        function ModeratePostModal() {
          babelHelpers.classCallCheck(this, ModeratePostModal);
          return babelHelpers.possibleConstructorReturn(this, Object.getPrototypeOf(ModeratePostModal).apply(this, arguments));
        }

        babelHelpers.createClass(ModeratePostModal, [{
          key: 'init',
          value: function init() {
            babelHelpers.get(Object.getPrototypeOf(ModeratePostModal.prototype), 'init', this).call(this);

            this.success = false;

            this.reason = m.prop('');

            this.reasonDetails = m.prop('');
          }
        }, {
          key: 'className',
          value: function className() {
            return 'ModeratePostModal Modal--small';
          }
        }, {
          key: 'title',
          value: function title() {
            return app.translator.trans('datitisev-moderator-notes.forum.moderate_post.title');
          }
        }, {
          key: 'content',
          value: function content() {

            if (this.success) {
              return m(
                'div',
                { className: 'Modal-body' },
                m(
                  'div',
                  { className: 'Form Form--centered' },
                  m(
                    'p',
                    { className: 'helpText' },
                    app.translator.trans('datitisev-moderator-notes.forum.moderate_post.confirmation_message')
                  ),
                  m(
                    'div',
                    { className: 'Form-group' },
                    m(
                      Button,
                      { className: 'Button Button--primary Button--block', onclick: this.hide.bind(this) },
                      app.translator.trans('datitisev-moderator-notes.forum.moderate_post.dismiss_button')
                    )
                  )
                )
              );
            }

            return m(
              'div',
              { className: 'Modal-body' },
              m(
                'div',
                { className: 'Form form--centered' },
                m(
                  'div',
                  { className: 'Form-group' },
                  m(
                    'div',
                    null,
                    m(
                      'label',
                      { className: 'checkbox' },
                      m('input', { type: 'radio', name: 'reason', checked: this.reason() === 'off_topic', value: 'off_topic', onclick: m.withAttr('value', this.reason) }),
                      m(
                        'strong',
                        null,
                        app.translator.trans('datitisev-moderator-notes.forum.moderate_post.reason.off_topic_label')
                      ),
                      m('br', null),
                      app.translator.trans('datitisev-moderator-notes.forum.moderate_post.reason.off_topic_text')
                    ),
                    m(
                      'label',
                      { className: 'checkbox' },
                      m('input', { type: 'radio', name: 'reason', checked: this.reason() === 'innapropiate', value: 'innapropiate', onclick: m.withAttr('value', this.reason) }),
                      m(
                        'strong',
                        null,
                        app.translator.trans('datitisev-moderator-notes.forum.moderate_post.reason.innapropiate_label')
                      ),
                      m('br', null),
                      app.translator.trans('datitisev-moderator-notes.forum.moderate_post.reason.innapropiate_text')
                    ),
                    m(
                      'label',
                      { className: 'checkbox' },
                      m('input', { type: 'radio', name: 'reason', checked: this.reason() === 'spam', value: 'spam', onclick: m.withAttr('value', this.reason) }),
                      m(
                        'strong',
                        null,
                        app.translator.trans('datitisev-moderator-notes.forum.moderate_post.reason.spam_label')
                      ),
                      m('br', null),
                      app.translator.trans('datitisev-moderator-notes.forum.moderate_post.reason.spam_text')
                    ),
                    m(
                      'label',
                      { className: 'checkbox' },
                      m('input', { type: 'radio', name: 'reason', checked: this.reason() === 'other', value: 'other', onclick: m.withAttr('value', this.reason) }),
                      m(
                        'strong',
                        null,
                        app.translator.trans('datitisev-moderator-notes.forum.moderate_post.reason.other_label')
                      )
                    )
                  )
                ),
                m(
                  'div',
                  { className: 'Form-group' },
                  m(
                    Button,
                    { className: 'Button Button--primary Button--block', type: 'submit', loading: this.loading, disabled: !this.reason() },
                    app.translator.trans('datitisev-moderator-notes.forum.moderate_post.submit_button')
                  )
                )
              )
            );
          }
        }, {
          key: 'onsubmit',
          value: function onsubmit(e) {
            var _this2 = this;

            e.preventDefault();

            this.loading = true;

            app.store.createRecord('moderatorNotes').save({
              reason: this.reason() === 'other' ? null : this.reason(),
              reasonDetail: this.reasonDetails(),
              relationships: {
                user: app.session.user,
                post: this.props.post
              }
            }).then(function () {
              return _this2.success = true;
            }).catch(function (e) {
              console.error(e);
            }).then(this.loaded.bind(this));
          }
        }]);
        return ModeratePostModal;
      }(Modal);

      _export('default', ModeratePostModal);
    }
  };
});;
'use strict';

System.register('datitisev/moderator-notes/main', ['flarum/app', 'flarum/Model', 'datitisev/moderator-notes/models/ModeratorNotes', 'datitisev/moderator-notes/addModerateAction'], function (_export, _context) {
  var app, Model, ModeratorNotes, addModerateAction;
  return {
    setters: [function (_flarumApp) {
      app = _flarumApp.default;
    }, function (_flarumModel) {
      Model = _flarumModel.default;
    }, function (_datitisevModeratorNotesModelsModeratorNotes) {
      ModeratorNotes = _datitisevModeratorNotesModelsModeratorNotes.default;
    }, function (_datitisevModeratorNotesAddModerateAction) {
      addModerateAction = _datitisevModeratorNotesAddModerateAction.default;
    }],
    execute: function () {

      app.initializers.add('datitisev-moderator-notes', function () {

        app.store.models.posts.prototype.moderatorNotes = Model.hasMany('moderatorNotes');
        app.store.models.posts.prototype.canModerate = Model.hasMany('canModerate');

        app.store.models.moderatorNotes = ModeratorNotes;

        addModerateAction();
      });
    }
  };
});;
'use strict';

System.register('datitisev/moderator-notes/models/ModeratorNotes', ['flarum/Model', 'flarum/utils/mixin'], function (_export, _context) {
  var Model, mixin, ModeratorNotes;
  return {
    setters: [function (_flarumModel) {
      Model = _flarumModel.default;
    }, function (_flarumUtilsMixin) {
      mixin = _flarumUtilsMixin.default;
    }],
    execute: function () {
      ModeratorNotes = function (_Model) {
        babelHelpers.inherits(ModeratorNotes, _Model);

        function ModeratorNotes() {
          babelHelpers.classCallCheck(this, ModeratorNotes);
          return babelHelpers.possibleConstructorReturn(this, Object.getPrototypeOf(ModeratorNotes).apply(this, arguments));
        }

        return ModeratorNotes;
      }(Model);

      ;

      babelHelpers.extends(ModeratorNotes.prototype, {
        type: Model.attribute('type'),
        reason: Model.attribute('reason'),
        reasonDetail: Model.attribute('reasonDetail'),
        time: Model.attribute('time', Model.transformDate),

        post: Model.hasOne('post'),
        user: Model.hasOne('user')
      });

      _export('default', ModeratorNotes);
    }
  };
});