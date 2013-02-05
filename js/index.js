$(document).ready(function() {
  // Bind to login/logout links
  $(".user-functions .login a").on("click", function() {
    site.user.login();
    return false;
  });
  $(".user-functions .logout a").on("click", function() {
    site.user.logout();
    return false;
  });


  // Render UI based on user state
  var USER;

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
      $(".logged-out").hide();
      $(".logged-in").show();
    } else {
      // Logged out
      $(".logged-out").show();
      $(".logged-in").hide();
    }
  }

  site.user.addEventHandlers({
    onLogin: onLogin,
    onLogout: onLogout
  });

  site.user.getUser({
    callback: function(response) {
      USER = response.errorCode === 0 ? response : undefined;
      $(document).ready(onUserStateChange);
    }
  });
});