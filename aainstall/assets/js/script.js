$(document).ready(function(){
		$('#install_form').validate({
	    rules: {
	    	hostname: {
	        required: true
	      },
	      db_user: {
	    	  required: true 
	      },
	      db_name: {
	    	  required: true
	      },
	      company_name: {
	    	  required: true
	      },
	      company_email: {
	    	  required: true,
	    	  email: true
	      },
	       currency_symbol: {
	    	  required: true
	      },
	      admin_email: {
	        required: true,
	        email: true
	      },
	      admin_username: {
	        required: true
	      },
	      admin_password: {
	        required: true
	      }
	    },
			highlight: function(element) {
				$(element).removeClass('success').addClass('error');
			},
			success: function(element) {
				element.removeClass('error').addClass('success');
			}
	  });

}); // end document.ready