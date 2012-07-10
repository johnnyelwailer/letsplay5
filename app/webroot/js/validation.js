//http://bakery.cakephp.org/articles/mattc/2008/10/26/automagic-javascript-validation-helper


function validateForm(form, rules) {
  //clear out any old errors
  $('.input').removeClass('error');
  $(".error-message").remove();
  
  //loop through the validation rules and check for errors
  var isValid = true;
  $.each(rules, function(field) {
    var val = $.trim($("#" + field).val());
	
    $.each(this, function() {
      console.log(this['rule']);
	  
      //check if the input exists
      if ($("#" + field).attr("id") != undefined) {
        var valid = true;
        
        if (this['allowEmpty'] && val == '') {
          //do nothing
        } else if (this['rule'] == "range") {
          var range = this['rule'].split('|');
          if (val < parseInt(range[1])) {
            valid = false;
          }
          if (val > parseInt(range[2])) {
            valid = false;
          }
		} else if (this['identicalFieldValues']) {
			var f = this['identicalFieldValues'];
			if($("#" + field).val() != $("#" + f).val())
				valid = false;
        } else if (this['negate']) {
			
          if (!val.match(eval(this['rule']))) {
            valid = false;
          }
        } else if (!val.match(eval(this['rule']))) {
          valid = false;
        }
        
        if (!valid) {
			isValid = false;
          //add the error message
		  
          var main = $("#" + field).parent();
		  main.addClass('error');
		  main.append('<div class="error-message">' + this['message'] + "</div>");
          
          //highlight the label
          //$("label[for='" + field + "']").addClass("error");
          //$("#" + field).parent().addClass("error");
        }
      }
    });
  });
  
  if(!isValid)
	return false;

  return true;
}