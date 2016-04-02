/*
	~"~"~ e7 Under Construction ~"~"~ HTML5 & CSS3 Under Construction Theme by Nuruzzaman Sheikh (UID: palpaldal)
	Please purchase a license from http://themeforest.net in order to use this template.
	Developer Web Address: http://www.palpaldal.com
	Theme Preview and Demo: http://themes.palpaldal.com/e7/
	Themeforest profile: http://themeforest.net/user/palpaldal/

	Table of Contents
	------------------
	1.	jQuery.easing plugin
	2.	jQuery CSS3 rotate plugin
	3.	jQuery.tinyValidator validates form fields then submits to server (with ajax methods).
	4.	jQuery.hidingLabel library script
	5.	Theme Script initialization function
*/

/*
 * jQuery Easing v1.3 - http://gsgd.co.uk/sandbox/jquery/easing/
 *
 * Uses the built in easing capabilities added In jQuery 1.1
 * to offer multiple easing options
 *
 * TERMS OF USE - jQuery Easing
 * 
 * Open source under the BSD License. 
 * 
 * Copyright © 2008 George McGinley Smith
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification, 
 * are permitted provided that the following conditions are met:
 * 
 * Redistributions of source code must retain the above copyright notice, this list of 
 * conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list 
 * of conditions and the following disclaimer in the documentation and/or other materials 
 * provided with the distribution.
 * 
 * Neither the name of the author nor the names of contributors may be used to endorse 
 * or promote products derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY 
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 *  COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 *  EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 *  GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED 
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 *  NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED 
 * OF THE POSSIBILITY OF SUCH DAMAGE. 
 *
*/

// t: current time, b: begInnIng value, c: change In value, d: duration
;
jQuery.easing['jswing'] = jQuery.easing['swing'];
jQuery.extend(jQuery.easing,{def: 'easeOutQuad',swing: function(x,t,b,c,d){return jQuery.easing[jQuery.easing.def](x, t, b, c, d);},easeInQuad:function(x,t,b,c,d){return c*(t/=d)*t+b;},easeOutQuad:function(x,t,b,c,d){return -c *(t/=d)*(t-2)+b;},easeInOutQuad:function(x,t,b,c,d){if((t/=d/2)<1)return c/2*t*t + b;return -c/2*((--t)*(t-2)-1)+b;},easeInCubic:function(x,t,b,c,d){return c*(t/=d)*t*t+b;},easeOutCubic:function(x,t,b,c,d){		return c*((t=t/d-1)*t*t+1)+b;},easeInOutCubic:function(x,t,b,c,d){if((t/=d/2)<1) return c/2*t*t*t+b;return c/2*((t-=2)*t*t+2)+b;},easeInQuart:function(x,t,b,c,d){return c*(t/=d)*t*t*t+b;},easeOutQuart:function(x,t,b,c,d){return -c*((t=t/d-1)*t*t*t-1)+b;},easeInOutQuart:function(x,t,b,c,d){if((t/=d/2)<1)return c/2*t*t*t*t+b;return -c/2*((t-=2)*t*t*t-2)+b;},easeInQuint:function(x,t,b,c,d){return c*(t/=d)*t*t*t*t+b;},easeOutQuint:function(x,t,b,c,d){return c*((t=t/d-1)*t*t*t*t+1)+b;},easeInOutQuint:function(x,t,b,c,d){if((t/=d/2)<1)return c/2*t*t*t*t*t+b;return c/2*((t-=2)*t*t*t*t+2)+b;},easeInSine:function(x,t,b,c,d){return -c*Math.cos(t/d*(Math.PI/2))+c+b;},easeOutSine:function(x,t,b,c,d){return c*Math.sin(t/d*(Math.PI/2))+b;},easeInOutSine:function(x,t,b,c,d){return -c/2*(Math.cos(Math.PI*t/d)-1)+b;},easeInExpo:function(x,t,b,c,d){return (t==0)?b:c*Math.pow(2,10*(t/d-1))+b;},easeOutExpo:function(x,t,b,c,d){return (t==d)?b+c:c*(-Math.pow(2,-10*t/d)+1)+b;},easeInOutExpo:function(x,t,b,c,d){if(t==0)return b;if(t==d)return b+c;if((t/=d/2)<1)return c/2*Math.pow(2,10*(t-1))+b;return c/2*(-Math.pow(2,-10*--t)+2)+b;},	easeInCirc:function(x, t, b, c, d){return -c*(Math.sqrt(1-(t/=d)*t)-1)+b;},easeOutCirc:function(x,t,b,c,d){return c*Math.sqrt(1-(t=t/d-1)*t)+b;},easeInOutCirc:function(x,t,b,c,d){if((t/=d/2)<1)return -c/2*(Math.sqrt(1-t*t)-1)+b;return c/2*(Math.sqrt(1-(t-=2)*t)+1)+b;},easeInElastic:function(x,t,b,c,d){var s=1.70158;var p=0;var a=c;if(t==0)return b;if((t/=d)==1)return b+c;if(!p)p=d*.3;if(a<Math.abs(c)){a=c;var s=p/4;}else var s=p/(2*Math.PI)*Math.asin(c/a);return -(a*Math.pow(2,10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p))+b;},easeOutElastic:function(x,t,b,c,d){var s=1.70158;var p=0;var a=c;if(t==0)return b;if((t/=d)==1)return b+c;if(!p)p=d*.3;if(a<Math.abs(c)){a=c;var s=p/4;}else var s=p/(2*Math.PI)*Math.asin(c/a);return a*Math.pow(2,-10*t)*Math.sin((t*d-s)*(2*Math.PI)/p)+c+b;},easeInOutElastic:function(x,t,b,c,d){var s=1.70158;var p=0;var a=c;if(t==0)return b;if((t/=d/2)==2)return b+c;if(!p)p=d*(.3*1.5);if(a<Math.abs(c)){a=c;var s=p/4;}else var s=p/(2*Math.PI)*Math.asin(c/a);if(t<1)return -.5*(a*Math.pow(2,10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p))+b;return a*Math.pow(2,-10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p)*.5+c+b;},easeInBack:function(x,t,b,c,d,s){if(s==undefined)s=1.70158;return c*(t/=d)*t*((s+1)*t-s)+b;},easeOutBack:function(x,t,b,c,d,s){if(s==undefined)s=1.70158;return c*((t=t/d-1)*t*((s+1)*t+s)+1)+b;},easeInOutBack:function(x,t,b,c,d,s){if(s==undefined)s=1.70158;if((t/=d/2)<1)return c/2*(t*t*(((s*=(1.525))+1)*t-s))+b;return c/2*((t-=2)*t*(((s*=(1.525))+1)*t+s)+2)+b;},easeInBounce:function(x,t,b,c,d){return c-jQuery.easing.easeOutBounce(x,d-t,0,c,d)+b;},easeOutBounce:function(x,t,b,c,d){if((t/=d)<(1/2.75)){return c*(7.5625*t*t)+b;}else if(t<(2/2.75)){return c*(7.5625*(t-=(1.5/2.75))*t+.75)+b;}else if(t<(2.5/2.75)){return c*(7.5625*(t-=(2.25/2.75))*t+.9375)+b;}else{return c*(7.5625*(t-=(2.625/2.75))*t+.984375)+b;}},easeInOutBounce:function(x,t,b,c,d){if(t<d/2)return jQuery.easing.easeInBounce(x,t*2,0,c,d)*.5+b;return jQuery.easing.easeOutBounce(x,t*2-d,0,c,d)*.5+c*.5+b;}});


(function ($) {
    // Monkey patch jQuery 1.3.1+ to add support for setting or animating CSS
    // scale and rotation independently.
    // 2009-2010 Zachary Johnson www.zachstronaut.com
    // Updated 2010.11.06
    var rotateUnits = 'deg';
    
    $.fn.rotate = function (val)
    {
        var style = $(this).css('transform') || 'none';
        
        if (typeof val == 'undefined')
        {
            if (style)
            {
                var m = style.match(/rotate\(([^)]+)\)/);
                if (m && m[1])
                {
                    return m[1];
                }
            }
            
            return 0;
        }
        
        var m = val.toString().match(/^(-?\d+(\.\d+)?)(.+)?$/);
        if (m)
        {
            if (m[3])
            {
                rotateUnits = m[3];
            }
            
            $(this).css(
                'transform',
                style.replace(/none|rotate\([^)]*\)/, '') + 'rotate(' + m[1] + rotateUnits + ')'
            );
        }
        
        return this;
    }
    
    // Note that scale is unitless.
    $.fn.scale = function (val, duration, options)
    {
        var style = $(this).css('transform');
        
        if (typeof val == 'undefined')
        {
            if (style)
            {
                var m = style.match(/scale\(([^)]+)\)/);
                if (m && m[1])
                {
                    return m[1];
                }
            }
            
            return 1;
        }
        
        $(this).css(
            'transform',
            style.replace(/none|scale\([^)]*\)/, '') + 'scale(' + val + ')'
        );
        
        return this;
    }

    // fx.cur() must be monkey patched because otherwise it would always
    // return 0 for current rotate and scale values
    var curProxied = $.fx.prototype.cur;
    $.fx.prototype.cur = function ()
    {
        if (this.prop == 'rotate')
        {
            return parseFloat($(this.elem).rotate());
        }
        else if (this.prop == 'scale')
        {
            return parseFloat($(this.elem).scale());
        }
        
        return curProxied.apply(this, arguments);
    }
    
    $.fx.step.rotate = function (fx)
    {
        $(fx.elem).rotate(fx.now + rotateUnits);
    }
    
    $.fx.step.scale = function (fx)
    {
        $(fx.elem).scale(fx.now);
    }
    
    /*
    
    Starting on line 3905 of jquery-1.3.2.js we have this code:
    
    // We need to compute starting value
    if ( unit != "px" ) {
        self.style[ name ] = (end || 1) + unit;
        start = ((end || 1) / e.cur(true)) * start;
        self.style[ name ] = start + unit;
    }
    
    This creates a problem where we cannot give units to our custom animation
    because if we do then this code will execute and because self.style[name]
    does not exist where name is our custom animation's name then e.cur(true)
    will likely return zero and create a divide by zero bug which will set
    start to NaN.
    
    The following monkey patch for animate() gets around this by storing the
    units used in the rotation definition and then stripping the units off.
    
    */
    
    var animateProxied = $.fn.animate;
    $.fn.animate = function (prop)
    {
        if (typeof prop['rotate'] != 'undefined')
        {
            var m = prop['rotate'].toString().match(/^(([+-]=)?(-?\d+(\.\d+)?))(.+)?$/);
            if (m && m[5])
            {
                rotateUnits = m[5];
            }
            
            prop['rotate'] = m[1];
        }
        
        return animateProxied.apply(this, arguments);
    }
})(jQuery);


(function ($) {
    // Monkey patch jQuery 1.3.1+ css() method to support CSS 'transform'
    // property uniformly across Safari/Chrome/Webkit, Firefox 3.5+, IE 9+, and Opera 11+.
    // 2009-2011 Zachary Johnson www.zachstronaut.com
    // Updated 2011.05.04 (May the fourth be with you!)
    function getTransformProperty(element)
    {
        // Try transform first for forward compatibility
        // In some versions of IE9, it is critical for msTransform to be in
        // this list before MozTranform.
        var properties = ['transform', 'WebkitTransform', 'msTransform', 'MozTransform', 'OTransform'];
        var p;
        while (p = properties.shift())
        {
            if (typeof element.style[p] != 'undefined')
            {
                return p;
            }
        }
        
        // Default to transform also
        return 'transform';
    }
    
    var _propsObj = null;
    
    var proxied = $.fn.css;
    $.fn.css = function (arg, val)
    {
        // Temporary solution for current 1.6.x incompatibility, while
        // preserving 1.3.x compatibility, until I can rewrite using CSS Hooks
        if (_propsObj === null)
        {
            if (typeof $.cssProps != 'undefined')
            {
                _propsObj = $.cssProps;
            }
            else if (typeof $.props != 'undefined')
            {
                _propsObj = $.props;
            }
            else
            {
                _propsObj = {}
            }
        }
        
        // Find the correct browser specific property and setup the mapping using
        // $.props which is used internally by jQuery.attr() when setting CSS
        // properties via either the css(name, value) or css(properties) method.
        // The problem with doing this once outside of css() method is that you
        // need a DOM node to find the right CSS property, and there is some risk
        // that somebody would call the css() method before body has loaded or any
        // DOM-is-ready events have fired.
        if
        (
            typeof _propsObj['transform'] == 'undefined'
            &&
            (
                arg == 'transform'
                ||
                (
                    typeof arg == 'object'
                    && typeof arg['transform'] != 'undefined'
                )
            )
        )
        {
            _propsObj['transform'] = getTransformProperty(this.get(0));
        }
        
        // We force the property mapping here because jQuery.attr() does
        // property mapping with jQuery.props when setting a CSS property,
        // but curCSS() does *not* do property mapping when *getting* a
        // CSS property.  (It probably should since it manually does it
        // for 'float' now anyway... but that'd require more testing.)
        //
        // But, only do the forced mapping if the correct CSS property
        // is not 'transform' and is something else.
        if (_propsObj['transform'] != 'transform')
        {
            // Call in form of css('transform' ...)
            if (arg == 'transform')
            {
                arg = _propsObj['transform'];
                
                // User wants to GET the transform CSS, and in jQuery 1.4.3
                // calls to css() for transforms return a matrix rather than
                // the actual string specified by the user... avoid that
                // behavior and return the string by calling jQuery.style()
                // directly
                if (typeof val == 'undefined' && jQuery.style)
                {
                    return jQuery.style(this.get(0), arg);
                }
            }

            // Call in form of css({'transform': ...})
            else if
            (
                typeof arg == 'object'
                && typeof arg['transform'] != 'undefined'
            )
            {
                arg[_propsObj['transform']] = arg['transform'];
                delete arg['transform'];
            }
        }
        
        return proxied.apply(this, arguments);
    };
})(jQuery);


/* JavaScript Custom Form Validation Routines 
	
* It's functionality is so simple. It doesn't show any validation message until user first attempts to submit forms with inappropriately filled field. When user's try to submit the form for first time this script checks if every field has been filled properly othwerwise it prevents submission to the server and notifies user about her mistake(s). This time it validates each field as user focuses in and blurs them(fields) off.

* You can also change error messages if you like.
*/

;(function($){
	jQuery.fn.tinyValidator = function(options){
		var defaults = {
			emptyMsg: "This is a required field.",
			emailMsg: "Type a valid email address e.g. <code>you@yoursite.com</code>",
			urlMsg: "	Type proper url with \
							<code>http://</code> portion \
							or leave it blank",
			sbtMsg: "Please, make sure you've properly filled all the above required fields.",
			ajax: false,
			miniForm : false,
	
			genError: function(field, msg){
				var holder = field.parent('li');
				if(!holder.hasClass('warning')){
					holder.addClass('warning').append($('<p>' + msg + '</p>'));
				}
			},
			
			canError: function(field){
				var holder = field.parent('li');
				if(holder.hasClass('warning')){
					holder.removeClass('warning').children('p').remove();
				}
			}
		};
	
		var opts = jQuery.extend(defaults, options);
	
		return this.each(function(){
	
			var form = jQuery(this);
	
			var ajaxMail = function(){
				//Get the data from all the fields
				var name = $('#name');
				var email = $('#email');
				var url = $('#url');
				var subject = $('#subject');
				var message = $('#message');
				//organize the data properly
				var data = 'name=' + name.val() + '&email=' + email.val() + '&url='+ url.val() + '&subject='+ subject.val() + '&message=' + message.val();
	
				//start the ajax
				$.ajax({
					//this is the php file that processes the data and sends mail
					url: "mail.php",
					//GET method is used
					type: "GET",
					//pass the data			
					data: data,		
					//Do not cache the page
					cache: false,
					//success
					success: function(html){
						$('.sending', form.parent()).hide();
						//if mail.php/mini-mail.php returned 1/true (send mail success)
						if(html == 1){
							$('.success', form.parent()).fadeTo('slow', 1);
							setTimeout(function(){$('.success', form.parent()).fadeTo('slow', 0, function(){hideAll();});disable(false);}, 6000);
						//if mail.php/mini-mail.php returned 0/false (send mail failed)
						}
						else{
							$('.error', form.parent()).fadeTo('slow', 1);
							setTimeout(function(){$('.error', form.parent()).fadeTo('slow', 0, function(){hideAll();}); disable(false);}, 6000);
						}
					}
				});
				//cancel the submit button default behaviours
				return false;
			};
			
			var hideAll = function(){
				$('.sending', form.parent()).hide();
				$('.success', form.parent()).hide();
				$('.error', form.parent()).hide();
			};
			
			var disable = function(disable){
				if(disable){
					$('input, textarea, input[type=submit]', form).attr('disabled', 'true');
					form.animate({opacity: .15}, 1000);
				}
				else{
					$('input, textarea, input[type=submit]', form).removeAttr('disabled');
					form.animate({opacity: 1}, 1000);
				}
			};
	
			form.one('submit', function(){
				jQuery(':input', form)
					.filter('.empty')
					.blur(function(){
						if(this.value == '' || /^\s+$/.test(this.value)){
							opts.genError(jQuery(this), opts.emptyMsg);
						}
						else{
							opts.canError(jQuery(this));
						}
					})
					.end()
					.filter('.email')
					.blur(function(){
						if(this.value == '' || !/.+@.+\.[a-zA-Z]{2,4}$/.test(this.value)){
							opts.genError(jQuery(this), opts.emailMsg);
						}
						else{
							opts.canError(jQuery(this));
						}
					})
					.end()
					.filter('.url')
					.blur(function(){
						if((this.value == '' || /^\s+$/.test(this.value)) && jQuery(this).hasClass('optional')){
							jQuery(this).val('');
							opts.canError(jQuery(this));
							return;
						}
						else if(this.value == '' || !/^(http|https):\/\/.+\.\w{2,4}$/.test(this.value)){
							opts.genError(jQuery(this), opts.urlMsg);
						}
						else{
							opts.canError(jQuery(this));
						}
					});
				}).submit(function(){
					jQuery(':input', form).trigger('blur');
					var warnings = jQuery('.warning', form).length;
					var parent = jQuery(':submit', form).parent('li');
					parent.find('p').remove();
					if(warnings > 0){
						parent.prepend(jQuery("<p><strong>" + opts.sbtMsg + "</strong></p>"));
						return false;
					}
					else{
						parent.find('p').remove();
						if(opts.ajax){
							$('.sending', form.parent()).fadeTo('slow', 1);
							disable(true);
							ajaxMail();
							return false;
						}
						else{
							return true;
						}
					}
			});
		});
	};
})(jQuery);

/* Form fields label hiding plugin */
;(function($){
	$.fn.hidingLabel = function(options){
		var fT = function(field){
			if(field.val() === '' || field.val() === ' '){
				field.siblings('label').fadeTo('slow', 0.4);
			}
		};
		var fB = function(field){
			if(field.val() === '' || field.val() === ' '){
				field.siblings('label').fadeTo('slow', 1);
			}
		};
		var h = function(field){
			if(field.val() !== '' || field.val() === ' '){
				field.siblings('label').hide();
			}
		};
		
		var autoCall = options;

		return this.each(function(){
			$(':text, :password, textarea', this).each(function(){
				var field = $(this);
				field.siblings('label').css('position', 'absolute');
				if(autoCall === true){
					fB(field);
				}
				field.focus(function(){fT(field);})
				.keyup(function(){h(field);})
				.blur(function(){fB(field);});
				h(field);
			});
		});
	};
})(jQuery);

/* Site Initialization JavaScript Codes */
;(function($){
	
	$(document).ready(function(){
		$('form').hidingLabel();
	});
	
	$(document).ready(function(){
		$('#contactForm').tinyValidator({ajax: true});
	});

	/* Counter initialization function */	
	$(document).ready(function(){
		// the year counting starts from this year.
		// So, if your target time is next year's march's 15 then set like this
		// years = 1; months = 3 ; days 15;
		//Please documentation for better understanding
		var years = 2012;
		var months = 8;
		var days = 5;

		var serverTime = function(){
			var time = null;
			$.ajax({url: 'time.php',
				async: false, dataType: 'text',
				success: function(text){
					time = new Date(text);
				}, error: function(http, message, exc){
					time = new Date();
			}});
			return time;
		}
		var austDay = new Date(years, months, days);
		$('#clock').countdown({until: austDay, serverSync: serverTime});
});

	/* Cycle plugin for home page */
	$(document).ready(function(){
		if ($('#slider').length > 0){
			$('#slider').cycle({
				fx: 'fade',
				speed: 1000,
				timeout: 6000,
				rev: 0,
				randomizeEffects: false,
				easing: 'easeInOutQuad', //jquery.easing library/plugin is required for this functionality
				next: '.next',
				prev: '.prev',
				pager: '',
				cleartypeNoBg: true
			}); 
		}
	});
	
	/*
		functions for controlling the email and main boards view with animation and rotation.
	*/
	$(document).ready(function(){
		var mainBoard = $('#mainBoard');
		var cntBoard = $('#contactBoard');
		var docWidth = (($(document).width()) - (cntBoard.width())) / 2;
		var emailBoard = false;
		
		var rotateCntBoard = function(){
			cntBoard.css('zIndex', '111');
			cntBoard.animate(
				{rotate: '-360deg', scale: '1'},
				{duration: '1000'});
		};
		
		var rotateMainBoard = function(){
			cntBoard.css('zIndex', '11');
			mainBoard.animate(
				{rotate: '-360deg', scale: '1'},
				{duration: '1000'});
		};

		/* predefining the contactBoard to enable advanced function with jQuery/CSS3 transform */
		if($.browser.msie){
			if($.browser.version >= '9.0'){
				cntBoard.css({position: 'absolute', left: (docWidth - 21) + 'px', top: '0px', zIndex: 11}).scale('.1');
			}
		}
		else{
			cntBoard.css({position: 'absolute', left: (docWidth - 21) + 'px', top: '0px', zIndex: 11}).scale('.1');
		}

		$('#emailBtn').click(function(){
			if(emailBoard){
				cntBoard.animate(
					{rotate: '360deg', scale: '.1'},
					{duration: '1000', complete: function(){rotateMainBoard();}
				});
				emailBoard = false;
			}
			else{
				mainBoard.animate(
					{rotate: '360deg', scale: '.1'},
					{duration: '1000', complete: function(){rotateCntBoard();}
				});
				emailBoard = true;
			}
			return false;
		});

		$('#clsCntFrm').click(function(){
			if(emailBoard){
				cntBoard.animate(
					{rotate: '360deg', scale: '.1'},
					{duration: '1000', complete: function(){rotateMainBoard();}
				});
				emailBoard = false;
			}
			return false;
		});
	});

	/* Ajax function to handle newsletter form .*/
	$(document).ready(function(){
		$('#nlForm').submit(function(){

			var hideMsg = function(){
				$('.nlMsg').animate(
					{opacity: 0},
					{
						duration: 1000,
						complete: function(){
							$('.nlMsg').remove();
						}
					})
			};

			var report = function(token){
				var msg = '';
				if(token == 1){
					//presumed success
					msg = '<h2 class="nlMsg success">Congratulations! Your email has been successfully added to the mailing list. Thank you so much for your interest.</h2>';
				}
				else if (token == 2){
					//presumed invalid email format
					msg = '<h2 class="nlMsg warn">Please insert a valid email address (e.g. john@example.com)</h2>';
				}
				else if(token == 3){
					//repeat entry
					msg = '<h2 class="nlMsg info">Wow! You\'re already in the mailing list! We appreciate your interest! Thank you.</h2>';
				}
				else{
					msg = '<h2 class="nlMsg error">Sorry, you cann\'t subscribe on this demo. This feature is intentionally disabled here.</h2>';
				}
				$('#mainBoard').prepend($(msg));
				setTimeout(function(){hideMsg();}, 3000);
			}

			var ajaxMail = function(){
				//Get the data from all the fields
				var email = $('#nlEmail');
				//organize the data properly
				var data = 'nlEmail=' + email.val() + '&ajax=true';
				//start the ajax
				$.ajax({
					//this is the php file that processes the data and sends mail
					url: "newsletter/save.php",
					//GET method is used
					type: "GET",
					//pass the data
					data: data,
					//Do not cache the page
					cache: false,
					//success
					success: function(html){
						report(html);
					}
				});
				//cancel the submit button default behaviours
				return false;
			};
			ajaxMail();
			return false;
		});
	});

})(jQuery);