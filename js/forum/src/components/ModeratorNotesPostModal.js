import Modal from 'flarum/components/Modal';
import Button from 'flarum/components/Button';


export default class ModeratePostModal extends Modal {
  init() {
    super.init();

    this.success = false;

    this.reason = m.prop('');

    this.reasonDetails = m.prop('');

  }

  className() {
    return 'ModeratePostModal Modal--small';
  }

  title() {
    return app.translator.trans('datitisev-moderator-notes.forum.moderate_post.title');
  }

  content() {

    if (this.success) {
      return (
        <div className="Modal-body">
          <div className="Form Form--centered">
            <p className="helpText">{app.translator.trans('datitisev-moderator-notes.forum.moderate_post.confirmation_message')}</p>
            <div className="Form-group">
              <Button className="Button Button--primary Button--block" onclick={this.hide.bind(this)}>
                {app.translator.trans('datitisev-moderator-notes.forum.moderate_post.dismiss_button')}
              </Button>
            </div>
          </div>
        </div>
      );
    }


    return (
      <div className="Modal-body">
        <div className="Form form--centered">
          <div className="Form-group">
            <div>
              <label className="checkbox">
                <input type="radio" name="reason" checked={this.reason() === 'off_topic'} value="off_topic" onclick={m.withAttr('value', this.reason)}/>
                <strong>{app.translator.trans('datitisev-moderator-notes.forum.moderate_post.reason.off_topic_label')}</strong><br/>
                {app.translator.trans('datitisev-moderator-notes.forum.moderate_post.reason.off_topic_text')}
              </label>

              <label className="checkbox">
                <input type="radio" name="reason" checked={this.reason() === 'innapropiate'} value="innapropiate" onclick={m.withAttr('value', this.reason)}/>
                <strong>{app.translator.trans('datitisev-moderator-notes.forum.moderate_post.reason.innapropiate_label')}</strong><br/>
                {app.translator.trans('datitisev-moderator-notes.forum.moderate_post.reason.innapropiate_text')}
              </label>

              <label className="checkbox">
                <input type="radio" name="reason" checked={this.reason() === 'spam'} value="spam" onclick={m.withAttr('value', this.reason)}/>
                <strong>{app.translator.trans('datitisev-moderator-notes.forum.moderate_post.reason.spam_label')}</strong><br/>
                {app.translator.trans('datitisev-moderator-notes.forum.moderate_post.reason.spam_text')}
              </label>

              <label className="checkbox">
                <input type="radio" name="reason" checked={this.reason() === 'other'} value="other" onclick={m.withAttr('value', this.reason)}/>
                <strong>{app.translator.trans('datitisev-moderator-notes.forum.moderate_post.reason.other_label')}</strong>
              </label>

            </div>
          </div>

          <div className="Form-group">
            <Button className="Button Button--primary Button--block"  type="submit" loading={this.loading} disabled={!this.reason()}>
              {app.translator.trans('datitisev-moderator-notes.forum.moderate_post.submit_button')}
            </Button>
          </div>

        </div>
      </div>
    )

  }

  onsubmit(e) {
    e.preventDefault();

    this.loading = true;

    app.store.createRecord('moderatorNotes').save({
      reason: this.reason() === 'other' ? null : this.reason(),
      reasonDetail: this.reasonDetails(),
      relationships: {
        user: app.session.user,
        post: this.props.post
      }
    }).then(() => this.success = true)
      .catch((e) => {
        console.error(e);
      })
      .then(this.loaded.bind(this))
  }
}
