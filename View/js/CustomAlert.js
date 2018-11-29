
// append custom alert messages in the page
// catching the `alert_placeholder`
function customErrorAlert(msg){

  // -- JAVASCRIPT --
  var maindiv = document.getElementById("alert_placeholder");         // catch the alert_placeholder
  var div = document.createElement('div');                            // create a new div
  var strong = document.createElement('strong');                      // create a `strong` attribute
  var p      = document.createElement('p');                           // create a paragraph attribute

  div.setAttribute("class", "alert alert-danger alert-dismissible");  // set the `alert` class in order to
                                                                      // apply the bootstrap css
  div.setAttribute("role", "alert");                                  // set the `role` attribute
  strong.setAttribute("id","alert_strong");                           // set the strong id
  p.setAttribute("id","alert_p");                                     // set the p id
  strong.innerHTML = "Error!";                                        // add text in `strong`
  p.innerHTML = msg;                                                  // add text in `p`

  div.appendChild(strong);      // attach `strong` to `div`
  div.appendChild(p             // attach `p` to `div`
  maindiv.appendChild(div       // attach `div` to the alert_placeholder

  // -- JQUERY --
  // set a timeout for the alert
  window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove();
    });
  }, 4000);
}
