$(function() {
	$(".login-button").click(function(e){
		$(this).removeAttr("href");
	});
});

$(function() {
	$(".login-button a").click(function(e){
		$(this).removeAttr("href");
	});
});

$(function() {
	$(".login-button").click(function() {
		$(".login-button").toggleClass("active");
		$(".login-overlay").toggleClass("active");
		$(".login-area").toggleClass("active");
	});
});

$(function() {
	$(".login-overlay").click(function() {
		$(".login-button").removeClass("active");
		$(".login-overlay").removeClass("active");
		$(".login-area").removeClass("active");
	});
});



$(function() {
	$(".main-menu li a").click(function() {
		$(this).addClass("active");
	});
});



// SMOOTH SCROLL

$(function() {
  $('a[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
  });
});
