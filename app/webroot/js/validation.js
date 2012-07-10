//http://bakery.cakephp.org/articles/mattc/2008/10/26/automagic-javascript-validation-helper


function validateForm(form, rules) {
  //clear out any old errors
  $("#messages").html("");
  $("#messages").slideUp();
  $(".error-message").hide();
  
  //loop through the validation rules and check for errors
  $.each(rules, function(field) {
    var val = $.trim($("#" + field).val());
    
    $.each(this, function() {
      console.log(this['rule']);
      
      //check if the input exists
      if ($("#" + field).attr("id") != undefined) {
        var valid = true;
        
        if (this['allowEmpty'] && val == '') {
          //do nothing
        } else if (this['rule'].match(/^range/)) {
          var range = this['rule'].split('|');
          if (val < parseInt(range[1])) {
            valid = false;
          }
          if (val > parseInt(range[2])) {
            valid = false;
          }
        } else if (this['negate']) {
          if (val.match(eval(this['rule']))) {
            valid = false;
          }
        } else if (!val.match(eval(this['rule']))) {
          valid = false;
        }
        
        if (!valid) {
          //add the error message
          $("#messages").append("<p>" + this['message'] + "</p>");
          
          //highlight the label
          //$("label[for='" + field + "']").addClass("error");
          $("#" + field).parent().addClass("error");
        }
      }
    });
  });
  
  if($("#messages").html() != "") {
    $("#messages").wrapInner("<div class='errors'></div>");
    $("#messages").slideDown();
    return false;
  }

  return true;
}