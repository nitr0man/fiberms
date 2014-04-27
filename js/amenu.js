/**
 * aMenu - Animated jQuery Menu
 * (C) 2011 Sawanna Team (http://sawanna.org)
 */

$.fn.amenu=function(settings)
{
	aMenu={
		menu: null,
		timer: null,
		z: 0,
		params: new Array(),
		init: function(elem,settings) {
			this.params.speed=200;
			this.params.animation='show';
			
			if (typeof(settings) != 'undefined') {
				try {
					for (s in settings) {
						this.params[s]=settings[s];
					}
				} catch(e) {}
			}
			
			this.menu=elem;
			this.z=$(this.menu).css('z-index');
			$(this.menu).find('li').each(function(){
				var childs=$(this).find('ul');
				if (childs.length > 0) {
					$(this).addClass('parent');
				}
				
				$(this).children('a').hover(
					function(){
						aMenu.show($(this));
					},
					function(){
						aMenu.timer=window.setTimeout("aMenu.hide()",1000);
					}
				);
			});
		},
		show: function(elem) {
			window.clearTimeout(aMenu.timer);
			aMenu.hide();
			aMenu.highlight(elem);
			$(elem).parents('ul').stop(true,true).css('display','block');

			aMenu.z++;
			aMenu.animate($(elem).parent('li').children('ul'));
		},
		hide: function() {
			$(aMenu.menu).find('a').removeClass('active');
			$(aMenu.menu).find('ul').stop(true,true).css('display','none');
		},
		animate: function(elem) {
			aMenu.fix($(elem));

			$(elem).children('li').css('display','none');
			$(elem).css('display','block');
			var i=1;
			$(elem).children('li').each(function(){
				if (aMenu.params.animation == 'fade') {
					$(this).stop(true,true).fadeIn(i*aMenu.params.speed);
				} else if (aMenu.params.animation == 'slide') {
					$(this).stop(true,true).slideDown(i*aMenu.params.speed);
				} else if (aMenu.params.animation == 'wind') {
					$(this).css({
								'width':0,
								'display':'block'
							});
					$(this).animate({'width':'100%'},i*aMenu.params.speed);
				} else if (aMenu.params.animation == 'none') {
					$(this).css({
								'display':'block'
							});
				} else {
					$(this).stop(true,true).show(i*aMenu.params.speed);
				}
				i++;
			});
			$(elem).css('z-index',aMenu.z);
		},
		fix: function(elem) {
			var p=$(elem).parents('ul');
			if (p.length>1) {
				$(elem).css({
							'left': $(elem).parent('li').width(),
							'top': 0
							});
			} else {
				$(elem).css({
							'left': 0,
							'top': $(elem).parent('li').height()
							});
			}
		},
		highlight: function(elem) {
			var e=$(elem).parent('li');
			while (e.length != 0) {
				$(e).children('a').addClass('active');
				e=$(e).parent('ul').parent('li');
			}
		}
	}
	
	aMenu.init($(this),settings);
}
