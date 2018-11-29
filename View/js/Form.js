// validate the form before sending
// any data to the server

function validateForm() {
    var return_value = true;
    var res1,res2;

    var email     = document.getElementById("inputEmail");
    var password  = document.getElementById("inputPassword");
    var password2 = document.getElementById("inputPassword2");
    var re_mail   = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var re_pass   = /^(?=.{3})(?=.*[^0-9a-zA-Z])/;



    // test the email with `re_mail` regex object
    res1 = re_mail.test(email.value);
    // test the password with `re_pass` regex object
    res2 = re_pass.test(password.value);

    var msg=""; //if an error occours fill `msg` variable

    if(!res1){  // if the email field does not respect `re_mail`
      msg += "The email format is not valid."
      return_value = false;
    }
    if(!res2){ // if the password field does not respect `re_mail`
      msg += " The password format is not valid."
      return_value = false;
    }

    if(password2){ // this control must be perform only in `sign up`
      // if the two passwords are different
      if(password.value.localeCompare(password2.value) != 0){
        msg += " The passwords are different."
        return_value = false;
      }
    }

    if(!return_value){
      // alert the user with the message
      customErrorAlert(msg);
    }
    return return_value; // return true   -> send datas to the server
                         // return false  -> block the submit
}
