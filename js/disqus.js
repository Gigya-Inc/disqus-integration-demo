// Global var used by disqus -- controlled internally
var disqus_config;

// All module-related functions inside closure and not accessible globally
(function($, undefined) {
  if(!gigya) {
    if(console && console.error) {
      console.error("Gigya socialize.js not on page -- do not load Gigya / Disqus integration!");
    }
    return;
  }

  // Used to cache user state
  var USER;

  // Parse script JSON configuration
  var getScriptConfig = function() {
    var thisScript;
    var scripts = document.getElementsByTagName('script');
    for (var i = scripts.length - 1; i >= 0; i--) {
      var script = scripts[i];
      var src = script.src.toLowerCase();
      if (src != '' && src.indexOf('disqus.js') > -1) {
        thisScript = script;
        break;
      }
    }

    if(thisScript) {
      var str = thisScript.innerHTML;
      if (str === "") {
        str = '""';
      }
      eval('var o');
      try {
        eval('o=' + str);
      } catch (e) {}
      if(typeof o != 'object') {
        o = {};
      }
      return o;
    } else {
      return {};
    }
  }

  // All settings can be overriden with JSON config
  var settings = $.extend(true, {
    init: true,
    short_name: 'undefined',
    cookie_name: 'disqus_remote_auth_s3',
    token_ajax_url: undefined, // URL to disqus.js.php
    page: {
      api_key: undefined,
      author_s3: undefined,
      category_id: undefined,
      developer: undefined,
      identifier: undefined,
      language: undefined,
      remote_auth_s3: undefined,
      slug: undefined,
      title: undefined,
      url: undefined
    },
    sso: {
      name: undefined,
      button: undefined,
      url: undefined,
      logout: undefined,
      width: 740,
      height: 430
    }
  }, getScriptConfig());

  // Global var looked at by Disqus
  disqus_config = function() {
    // Update settings with remote_auth_s3 cookie
    settings.page.remote_auth_s3 = $.cookie(settings.cookie_name);

    // Set disqus configs
    this.page = settings.page;
    this.sso = settings.sso;
  }

  // Bind to Gigya login/logout global events
  var onLogin = function(user) {
    USER = user;
    onUserStateChange();
  }
  var onLogout = function() {
    USER = undefined;
    onUserStateChange();
  }
  var onUserStateChange = function() {
    if(USER) {
      login();
    } else {
      logout();
    }
  }
  gigya.socialize.addEventHandlers({
    onLogin: onLogin,
    onLogout: onLogout
  });

  // Authenticate with Disqus
  var login = function() {
    if(!$.cookie(settings.cookie_name)) { // Only if not already logged into Disqus
      // With valid user signature, returns Disqus cookie
      $.ajax({
        url: settings.token_ajax_url,
        data: {
          UID: USER.UID,
          UIDSignature: USER.UIDSignature,
          signatureTimestamp: USER.signatureTimestamp
        },
        type: "POST",
        dataType: "json",
        cache: false,
        complete: function(jqXHR, textStatus) {
          jqXHR.done(function(response) {
            if(!response.success) {
              if(console && console.error) {
                console.error("Disqus login failed!");
              }
              return;
            }

            // Pass token to Disqus SDK
            $.cookie(settings.cookie_name, response.signature);
            refreshUI();
          });
        }
      });
    } else {
      // Already logged in
      refreshUI();
    }
  }

  // Remove Disqus authentication cookie and refresh UI
  var logout = function() {
    if($.removeCookie(settings.cookie_name)) {
      refreshUI();
    }
  }

  // Refresh Disqus UI and pass configuration
  var refreshUI = function() {
    try { // DISQUS.reset sometimes throws an error, it is a bug.
      if(DISQUS && DISQUS.reset) {
        DISQUS.reset({
          reload: true,
          config: disqus_config
        });
      }
    } catch(e) {}
  }

  // Query user state and render initial UI
  gigya.socialize.getUserInfo({
    callback: function(response) {
      USER = response.errorCode === 0 && response.UID ? response : undefined;
      $(document).ready(onUserStateChange);
    }
  });

  // Initialize Disqus if necessary
  if(settings.init) {
    $(document).ready(function() {
      // Generic Disqus embed code
      // http://help.disqus.com/customer/portal/articles/472097-universal-embed-code
      var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
      dsq.src = 'http://' + settings.short_name + '.disqus.com/embed.js';
      (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    });
  }
}(jQuery));