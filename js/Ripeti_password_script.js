function validatePassword(){
  var password = document.getElementById("password")
  , confirm_password = document.getElementById("ripeti_password");
  
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Password diversa");
  } else {
    confirm_password.setCustomValidity('');
  }
}