$(document).ready(function() {
    $('#reg_form').bootstrapValidator({
        // framework: 'bootstrap',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            firstName: {
                validators: {
                        stringLength: {
                        min: 2,
                    },
                        notEmpty: {
                        message: 'Please supply your first name'
					},
					regexp: {
                        regexp: /^[a-z]+$/i,
                        message: 'Can consist of only alphabetical characters'
                    }
                }
			},
			lastName: {
                validators: {
                        stringLength: {
                        min: 2,
                    },
                        notEmpty: {
                        message: 'Please supply your last name'
					},
					regexp: {
                        regexp: /^[a-z]+$/i,
                        message: 'Can consist of only alphabetical characters'
                    }
                }
			},
			email: {
                validators: {
                    notEmpty: {
                        message: 'Please supply your email address'
                    },
                    emailAddress: {
                        message: 'Please supply a valid email address'
                    }
                }
			},
			username: {
                validators: {
                    // stringLength: {
                    //     min: 2,
                    // },
                    // notEmpty: {
                    //     message: 'Please supply a username'
					// },
					regexp: {
                        regexp: /^[a-zA-Z0-9]([._](?![._])|[a-zA-Z0-9]){6,20}[a-zA-Z0-9]$/u,
                        message: '<ul> <li>Only alphanumeric characters, underscore and dot.</li> <li>Length at least 6 characters and maximum of 20</li>'
					}
                }
			},
			password: {
				validators: {
					notEmpty: {
                        message: 'Please supply a password'
					},
					regexp: {
                        regexp: /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,30}$/u,
                        message: '<ul><li>Must contain atleast one digit from 0-9</li> <li>Must contain atleast one lowercase character</li> <li>Must contain atleast one uppercase character</li> <li>Must contain atleast one special symbol in the list "#?!@$%^&*-"</li> <li>Length at least 8 characters and maximum of 30</li></ul>'
					}
				}
			},
			password2: {
				validators: {
					notEmpty: {
                        message: 'Please supply a password'
					},
					identical: {
						field: 'password',
						message: 'The password and its confirm are not the same'
					}
				}
			},
			
            
            }
        })
		
 	
});