				
				// My js Editing

$( function () {

	'use strict';

		// Swith Between Login & Signup

		$('.login-page h1 span').click(function (){

			$(this).addClass('selected').siblings().removeClass('selected');

			$('.login-page form').hide();

			$('.'+$(this).data('class')).fadeIn(100);

		});


		//Hide Placeholde 'Username' && 'Password' On Form Focus

		$('[placeholder]').focus(function () {

			$(this).attr('data-text',$(this).attr('placeholder'));

			$(this).attr('placeholder','');

		}).blur(function () {

			$(this).attr('placeholder' , $(this).attr('data-text'));

		});

		// Add Asterisk On Required Field

		$('input').each(function(){

			if ($(this).attr('required') === 'required'){//attripute

				$(this).after('<span class="asterisk"> * </span>');

			}

		});


	   // Confirmation Message To Delete 
	   $('.confirm').click(function (){

	   		return confirm('Are You Sure ?');

	   });

	   //Display Changed in Once Time In Ad
	   $('.live-name').keyup(function () {
	   		$('.live-preview .caption h3').text($(this).val());
	   });

	   $('.live-desc').keyup(function () {
	   		$('.live-preview .caption p').text($(this).val());
	   });

	   	$('.live-price').keyup(function () {
	   		$('.live-preview .price-tag').text('$' + $(this).val());
	   });


});
