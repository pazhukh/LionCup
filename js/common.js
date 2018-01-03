$(document).ready(function(){
	var deadline='2018-08-05 12:00:00';
	var timer = $('.count-down');
	var historyLine = $('.line');
	var windowWidth = $(window).width();
	var mainSlider = $('.main-slider');
	var menuWrap = $('.menu-wrap');
	var menuToggle = $('.fa-compass');
	var subMenu = $('.sub-menu');
	var hasChild = $('.menu-item-has-children > a');



	function activeMainSlider(){
		if(windowWidth>575){
			mainSlider.slick({
				infinite: true,
				dots: true,
				autoplay: true,
				autoplaySpeed: 3000,
				speed: 3000,
				arrows: false,
				fade: true,
				pauseOnFocus: false,
				pauseOnHover: false,
			});
		} else{
			mainSlider.addClass('no-slider');
		}
	}
	activeMainSlider();
	

	$('.part-wr').slick({
		infinite: true,
		slidesToShow: 4,
		dots: true,
		autoplay: true,
		autoplaySpeed: 3000,
		arrows: false,
		pauseOnFocus: false,
		pauseOnHover: false,
		responsive: [
		{
			breakpoint: 991,
			settings: {
				slidesToShow: 3,
			}
		},
		{
			breakpoint: 575,
			settings: {
				slidesToShow: 2,
			}
		}
		]
	});


	timer.downCount({
		date: deadline,
	},
	function(){
		//do after end of timer
		timer.hide();
	});



	//menu toggle
	menuToggle.on('click', function(){
		menuWrap.slideToggle(200);
	})


	//close sub-menu when click outside (desktop)
	function closeSubMenuOutMenuClick(e){
		if(!$(e.target).closest('.menu-item-has-children.active').length && $(window).width()>991){
			$('.sub-menu').slideUp(100);
			$('.menu-item-has-children').removeClass('active');
		}
	}
	$(window).on('click', closeSubMenuOutMenuClick);


	//toggle sub menu
	hasChild.on('click', function(e){
		e.preventDefault();
		if($(window).width() > 991){
			var target = $(this).closest('.menu-item-has-children');
			if(!target.hasClass('active')){
				$('.sub-menu').slideUp(100);
				$('.menu-item-has-children').removeClass('active');

				target.addClass('active');
				$(this).next().slideDown(100);
			} else{
				target.removeClass('active');
				$(this).next().slideUp(100);
			}
		} else {
			$(this).next().slideToggle(100);
		}
	})


	//close menu when click out of them (Mobile)
	function closeMenuOutMenuClick(e){
		if(!$(e.target).closest('.menu-wrap').length && !$(e.target).closest('.fa-compass').length && $(window).width()<991){
			menuWrap.slideUp(100);
		}
	}
	$(window).on('click', closeMenuOutMenuClick);

	

	//set height of history items line
	function lineHeight(){
		historyLine.each(function(index, element){
			if(index == $('.line').length - 1){
				return false;
			} else{
				var thisBlock = $(this).closest('.history-item').height()/2;
				var nextBlock = $(this).closest('.history-item').next().height()/2;
				var h = thisBlock+nextBlock;
				$(this).height(h);
			}
			
		})
	}
	lineHeight();

	$(window).on('resize', function(){
		lineHeight();
	})

	//change header height
	$(window).on('scroll', function() {
		if( $(this).width() >= 991 ){
			var scroll = $(window).scrollTop();
			if (scroll > 300) {
				$(".header").addClass("small");
			} else{
				$(".header").removeClass("small");
			}
		} else {
			$(".header").removeClass("small");
		}
	}); 



});	
