System.register('datitisev/moderator-notes/addModerateAction', ['flarum/extend', 'flarum/app', 'flarum/components/Button', 'flarum/components/CommentPost', 'datitisev/moderator-notes/components/ModeratePostModal'], function (_export) {
  'use strict';

  var extend, app, Button, CommentPost, ModeratePostModal;
  return {
    setters: [function (_flarumExtend) {
      extend = _flarumExtend.extend;
    }, function (_flarumApp) {
      app = _flarumApp['default'];
    }, function (_flarumComponentsButton) {
      Button = _flarumComponentsButton['default'];
    }, function (_flarumComponentsCommentPost) {
      CommentPost = _flarumComponentsCommentPost['default'];
    }, function (_datitisevModeratorNotesComponentsModeratePostModal) {
      ModeratePostModal = _datitisevModeratorNotesComponentsModeratePostModal['default'];
    }],
    execute: function () {
      _export('default', function () {

        extend(CommentPost.prototype, 'actionItems', function (items) {

          var post = this.props.post;
          console.log(post);

          items.add('moderator-notes', Button.component({
            children: app.translator.trans('datitisev-moderator-notes.forum.post.moderate_button'),
            className: 'Button Button--link',
            onclick: function onclick() {

              app.modal.show(new ModeratePostModal({ post: post }));
            }
          }));
        });
      });
    }
  };
});;
System.register('datitisev/moderator-notes/main', ['flarum/app', 'flarum/extend', 'datitisev/moderator-notes/addModerateAction'], function (_export) {
	'use strict';

	var app, extend, addModerateAction;
	return {
		setters: [function (_flarumApp) {
			app = _flarumApp['default'];
		}, function (_flarumExtend) {
			extend = _flarumExtend.extend;
		}, function (_datitisevModeratorNotesAddModerateAction) {
			addModerateAction = _datitisevModeratorNotesAddModerateAction['default'];
		}],
		execute: function () {

			app.initializers.add('datitisev-moderator-notes', function (app) {

				addModerateAction();
			});
		}
	};
});;
System.register('datitisev/moderator-notes/components/ModeratePostModal', ['flarum/components/Modal', 'flarum/components/Button'], function (_export) {
  'use strict';

  var Modal, Button, ModeratePostModal;
  return {
    setters: [function (_flarumComponentsModal) {
      Modal = _flarumComponentsModal['default'];
    }, function (_flarumComponentsButton) {
      Button = _flarumComponentsButton['default'];
    }],
    execute: function () {
      ModeratePostModal = (function (_Modal) {
        babelHelpers.inherits(ModeratePostModal, _Modal);

        function ModeratePostModal() {
          babelHelpers.classCallCheck(this, ModeratePostModal);
          babelHelpers.get(Object.getPrototypeOf(ModeratePostModal.prototype), 'constructor', this).apply(this, arguments);
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
            return app.translator.trans('datitisev-moderator-notes.moderate_post.title');
          }
        }, {
          key: 'content',
          value: function content() {

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
                      app.translator.trans('datitisev-moderator-notes.forum.moderate_post.reason.innapropiate_text')
                    ),
                    m(
                      'label',
                      { className: 'checkbox' },
                      m('input', { type: 'radio', name: 'reason', checked: this.reason() === 'other', value: 'other', onclick: m.withAttr('value', this.reason) }),
                      m(
                        'strong',
                        null,
                        app.translator.trans('datitisev-moderator-notes.forum.moderate_post.reason.other_label')
                      ),
                      app.translator.trans('datitisev-moderator-notes.forum.moderate_post.reason.other_text')
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
            var _this = this;

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
              return _this.success = true;
            })['catch'](function () {}).then(this.loaded.bind(this));
          }
        }]);
        return ModeratePostModal;
      })(Modal);

      _export('default', ModeratePostModal);
    }
  };
});;
System.register("datitisev/moderator-notes/components/models/ModeratorNotes", [], function (_export) {
  "use strict";

  return {
    setters: [],
    execute: function () {}
  };
});;
System.register("datitisev/moderator-notes/models/ModeratorNotes.js/ModeratorNotes", [], function (_export) {
  "use strict";

  return {
    setters: [],
    execute: function () {}
  };
});