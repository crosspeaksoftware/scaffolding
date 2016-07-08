// Set parallax on larger screens
var isMobile = {
	Android: function() {
		return navigator.userAgent.match(/Android/i);
	},
	BlackBerry: function() {
		return navigator.userAgent.match(/BlackBerry/i);
	},
	iOS: function() {
		return navigator.userAgent.match(/iPhone|iPad|iPod/i);
	},
	Opera: function() {
		return navigator.userAgent.match(/Opera Mini/i);
	},
	Windows: function() {
		return navigator.userAgent.match(/IEMobile/i);
	},
	any: function() {
		return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
	}
};
$(function() {
	// skrollr
	if( !isMobile.any() ){
		skrollr.init({
			forceHeight: false,
			mobileCheck: function() {
				//hack - forces mobile version to be off
				return false;
			}
		});
	};

	// Analytics tracking

	// Download Button
	$("#download-link").click(function() {
		ga('send', 'event', 'button', 'click', 'Download');
		_paq.push(['trackEvent', 'button', 'click', 'Download']);
	});
	// Customize Button
	$("formsubmit").click(function() {
		ga('send', 'event', 'button', 'click', 'Customize');
		_paq.push(['trackEvent', 'button', 'click', 'Customize']);
	});
	$("#getstarted_btn").click(function() {
		ga('send', 'event', 'button', 'click', 'Get Started');
		_paq.push(['trackEvent', 'button', 'click', 'Get Started']);
	});
	// Fork on GitHub Button
	$("#forkongithub_btn").click(function() {
		ga('send', 'event', 'button', 'click', 'Fork on Github');
		_paq.push(['trackEvent', 'button', 'click', 'Fork on Github']);
	});
	$("#name").change(function() {
		ga('send', 'event', 'Form', 'Field', 'Name = ' + $(this).val());
		_paq.push(['trackEvent', 'Form', 'Field', 'Name = ' + $(this).val()]);
	});
	$("#slug").change(function() {
		ga('send', 'event', 'Form', 'Field', 'Slug = ' + $(this).val());
		_paq.push(['trackEvent', 'Form', 'Field', 'Slug = ' + $(this).val()]);
	});
	$("#author").change(function() {
		ga('send', 'event', 'Form', 'Field', 'Author = ' + $(this).val());
		_paq.push(['trackEvent', 'Form', 'Field', 'Author = ' + $(this).val()]);
	});
	$("#authoruri").change(function() {
		ga('send', 'event', 'Form', 'Field', 'Author URI = ' + $(this).val());
		_paq.push(['trackEvent', 'Form', 'Field', 'Author URI = ' + $(this).val()]);
	});
});