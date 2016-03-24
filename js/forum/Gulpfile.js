var flarum = require('flarum-gulp');

flarum({
  modules: {
    'datitisev/moderator-notes': [
      'src/**/*.js'
    ]
  }
});
