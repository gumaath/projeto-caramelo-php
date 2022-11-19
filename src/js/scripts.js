function logoutUser() {
  document.cookie = 'PHPSESSID' + '="";-1; path=/';
  document.cookie = 'login' + '="";-1; path=/';
  window.location.replace('./index.php')
}
