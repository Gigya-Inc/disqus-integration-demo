// The Disqus module does not depend on this abstraction, it's used for the demo
// This abstraction can be abstracted away if not using the accounts API
if(!site) {
  var site = {};
}
site.user = {};
site.user.login = function(params) {
  gigya.accounts.showScreenSet($.extend({
    screenSet: "Login-web"
  }, params));
}
site.user.logout = function(params) {
  gigya.accounts.logout($.extend({}, params));
}
site.user.getUser = function(params) {
  gigya.accounts.getAccountInfo(params);
}
site.user.profile = function(params) {
  gigya.accounts.showScreenSet($.extend({
    screenSet: "Profile-web"
  }, params));
}
site.user.addEventHandlers = function(params) {
  gigya.accounts.addEventHandlers(params);
}