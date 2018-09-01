$(document).ready(function(){

	// Nav toggler

	$('#nav-icon').click(function(){

		$(this).toggleClass('open').next().slideToggle();

	});



	//Mobile search

	$('.search-btn').on('click', function() {

		$(".header-search").slideToggle();

		return false;

	});



	// $(document).mouseup(function(e) 

	// {

	//     var container = $(".search-form");



	//     if (!container.is(e.target) && container.has(e.target).length === 0) 

	//     {

	//         container.fadeOut();

	//     }

	// });



	// Images Slider

	$('.home-slider').owlCarousel({

	    items:1,

	    dots:true,

	    autoplay: true,

	    autoplayHoverPause: true,

	    animateOut: 'slideOutUp',

  		animateIn: 'slideInUp'

	});



	$('.home-slider-mid').owlCarousel({

	    items:1,

	    dots:true,

	    autoplay: true,

	    autoplayHoverPause: true,

	    animateOut: 'slideOutDown',

  		animateIn: 'slideInDown'

	});



	// Tooltip

	$('[data-tooltip="tooltip"]').tooltip({ trigger: "hover" });



	// Equal height

	if ($(".mHeight").length > 0) {

		$(".mHeight").matchHeight();

	}



	// Sign Up Tab

	$('#gt-si').click(function(e){

    	e.preventDefault();

        $('.sign-in-tab a[href="#tab-1"]').tab('show');

    });



	// Product details image slider

    $('.slider-for').slick({

	  slidesToShow: 1,

	  slidesToScroll: 1,

	  arrows: false,

	  fade: true,

	  dots: true,

	  asNavFor: '.slider-nav'

	}).magnificPopup({

      type: 'image',

      delegate: 'a:not(.slick-cloned)',

      gallery: {

        enabled: true

      }

	});



	$('.slider-nav').owlCarousel({
		loop: false,
		dots:false,
	  	autoplay: false,
	  	items:3,
	  	margin:10,
	  	nav:true,
	    navText: ["<img src='./images/owl_arrow_prev.png'>","<img src='./images/owl_arrow_next.png'>"]
	});



	// Similar Product Slider

	$('.sp-slider').owlCarousel({

	    margin:15,

	    dots:false,

	    autoplay: true,

	    nav:true,

	    navText: ["<img src='./images/owl_arrow_prev.png'>","<img src='./images/owl_arrow_next.png'>"],

	    responsive:{

	        0:{

	            items:1

	        },

	        479:{

	            items:2

	        },

	        600:{

	            items:4

	        },

	        768:{

	            items:5

	        }

	    }

	});

	//custom scroll
	$('.wishlist-con, .i-box-wrap.order-history').mCustomScrollbar({
		theme:"dark"
	});


	//Touchspin

    $(".set_qty").TouchSpin({

    	min: 0

    });



    // on radio check display input

    $("#other-inp").attr("disabled", true);

    $(".c-radio").click(function() {	    

	    if ($("input[name=radio-group]:checked").val() == "other-cour") {

	        $("#other-inp").attr("disabled", false);

	    }else{

	    	$("#other-inp").attr("disabled", true);

	    }

	});  



	// Passwoed field toggle

	(function() {



		try {



			var passwordField = document.getElementById('user-password');

			passwordField.type = 'text';

			passwordField.type = 'password';

			var togglePasswordField = document.getElementById('togglePasswordField');

			togglePasswordField.addEventListener('click', togglePasswordFieldClicked, false);

			togglePasswordField.style.display = 'inline';

			

		}

		catch(err) {



		}



	})();



	function togglePasswordFieldClicked() {



		var passwordField = document.getElementById('user-password');

		var value = passwordField.value;



		if(passwordField.type == 'password') {

			passwordField.type = 'text';

		}

		else {

			passwordField.type = 'password';

		}

		

		passwordField.value = value;



	} 

});