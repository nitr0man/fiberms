var option = {
	jTimeClose: 3500,
	jErrorTime: 0,
	jErrorIndex: 0,
	winActive: false,
	openWin: false
};

$(window).bind('focusout', function(){option.winActive = false; $('#ajax-messages > div').clearQueue();});
$(window).bind('focusin', function(){option.winActive = true; jMessClose();});
$('body,html').one('mouseenter', function(){option.winActive = true;});

var reSearch = $('.search-results');
reSearch.hide();

$('.ssr').bind('keyup', function(){
	
	var ser = $(this);
	if (ser.val().length > 1) {
		
		reSearch.queue(function(){
			setTimeout(function(){
				reSearch.stop(true, true);
				
				reSearch.empty();
				reSearch.append('<a href="#" onclick="return false;" class="search-a">Result one</a>');
				reSearch.append('<a href="#" onclick="return false;" class="search-a">Result two</a>');
				reSearch.append('<a href="#" onclick="return false;" class="search-a">Result three</a>');
				
				reSearch.fadeIn(200);
				
				$('a.search-a').click(function() {
					$('.ssr').val($(this).text()).trigger('focus');
				});
				
			}, 500);
		});
		
	}
	else if (ser.val().length < 2) reSearch.fadeOut(200);
}).blur(function(){reSearch.fadeOut(200);});

// $('#showInfo').hide();
$('[title]').bind('mouseenter', function(event){
	var title = $(this).attr('title');
	// if (title.length==0) title = 'No information';
	$('#showInfo').text(title);
	$(this).attr({'title':''});
	
	$(this).bind('mousemove', function(event){
		var srcY = event.pageY + 20;
		if (document.body.clientHeight - 30 < srcY) srcY = srcY-50;
		if (title.length > 0) $('#showInfo').stop(true, true).attr({'style':'top:'+srcY+'px;left:'+ (event.pageX+15) +'px;'});
	});
	
	$(this).bind('mousedown', function(event){
		$('#showInfo').stop(true, true);
	});
	
	$(this).bind('mouseout', function(event){
		$(this).attr({'title':title});
		$('#showInfo').fadeOut(100);
	});
});


// errors
function jError(data) {
	$('#ajax-error').css({'display':''}).append('<div><span id="ajax-error-close"></span>'+data+'</div>');
}
$('#ajax-error > div span#ajax-error-close').live('click', function(){
	$(this).parent().queue(function(){
		$(this).slideUp(300).dequeue();
	}).queue(function(){
		$(this).remove().dequeue();
	});
	aj_size = $('#ajax-error').children('div').size();
	if (aj_size < 2) $('#ajax-error').fadeOut(222);
});


// message close
function jMessClose() {
	if (!option.openWin && option.winActive) {
		$('#ajax-messages > div:last-child').queue(function(){
			$(this).delay(option.jTimeClose).slideUp(300).dequeue();
		}).queue(function(){
			$(this).remove().dequeue();
			option.jErrorIndex--;
			if (option.jErrorIndex) jMessClose();
		});
	}
}

// message
function jMess(data) {
	option.jErrorIndex++; // счетчик
	$('#ajax-messages').prepend('<div><span style="display: none;" id="ajax-message-remove">1</span><span id="ajax-message-close"></span>' + data + '</div></div>').slideDown(300);
	if ($('#ajax-messages > div').size() < 2) jMessClose();
}

$('#ajax-messages > div').live({
	'mouseenter': function(){
		$(this).children('span#ajax-message-remove').text('0');
		$('#ajax-messages > div').clearQueue();
	},
	'mouseleave': function(){
		jMessClose();
	}
});
$('#ajax-messages > div span#ajax-message-close').live('click', function(){
	$(this).parent('div').queue(function(){
		$(this).slideUp(200).dequeue();
	}).queue(function(){
		option.jErrorIndex--;
		$(this).remove().dequeue();
	});
	
	aj_size = $('#ajax-messages').children('div').size();
	if (aj_size < 2) $('#ajax-messages').fadeOut(222);
});
$('#ajax-messages > div > div').live('click', function(){
	$(this).parent('div').queue(function(){
		$(this).slideUp(300).dequeue();
	}).queue(function(){
		option.jErrorIndex--;
		$(this).remove().dequeue();
	});
	
	$('body').append('<div style="display: none;" id="mes"><div id="title">'+$(this).find('p:first-child').html()+'</div></div>');
	openWindow({height: 400, width: 500, content: '#mes'});
});





// open new window
// author: winch
// date: 28.03.2012
openWindow = function(param){
	option.openWin = true;
	param = param || {};
	var html = '#html',
		width = param.width || 500,
		height = param.height || false,
		minHeight = param.minHeight || false,
		maxHeight = param.maxHeight || false,
		allclose = true,
		example = '#openWindow-example',
		content = param.content || example,
		hei = 104;
	
	if (!height && !minHeight && !maxHeight) height = '80%';
	
	if (height) { // height
		if (typeof(height)=='number') height -= hei;
		else {
			if (height.indexOf('%')!=-1) {
				height = Math.ceil(($(window).height()/100)*parseInt(height))-hei;
			}
			else height = parseInt(height)-hei;
		}
	}
	
	if (minHeight) { // min-height
		if (typeof(minHeight)=='number') minHeight -= hei;
		else {
			if (minHeight.indexOf('%')!=-1) {
				minHeight = Math.ceil(($(window).height()/100)*parseInt(minHeight))-hei;
			}
			else minHeight = parseInt(minHeight)-hei;
		}
	}
	
	if (maxHeight) { // max-height
		if (typeof(maxHeight)=='number') maxHeight -= hei;
		else {
			if (maxHeight.indexOf('%')!=-1) {
				maxHeight = Math.ceil(($(window).height()/100)*parseInt(maxHeight))-hei;
			}
			else maxHeight = parseInt(maxHeight)-hei;
		}
	}
	
	noHeight = (height ? height : (maxHeight ? maxHeight : minHeight))+hei;
	
	var $content = $(content),
		$title = $content.children('#title').size() ? $content.children('#title') : $(example).children('#title'),
		$text = $content.children('#text').size() ? $content.children('#text') :  $(example).children('#text'),
		$end = $content.children('#end').size() ? $content.children('#end') :  $(example).children('#end'),
		marg = (($(window).height() - noHeight)/2)-10;
	marg = marg < 20 ? 20 : Math.ceil(marg);
	
	$iframe = $text.children('iframe');
	if ($iframe.size()) {
		$iframe.each(function(){
			var url = $(this).attr('src');
			$.ajax({
				url: url,
				cache: false,
				success: function(html){$text.append(html+'<br/><br/>');},
				error: function(msg, msg2, msg3){ jError('<b>Ошибка</b>: '+document.URL+' -&gt; '+url+(msg3 ? '<br/>'+msg3 : ''));}
			});
			$(this).remove();
		});
	}
	
	$('body').attr({'style':'overflow: hidden; margin-right: 17px;'});
	
	$('.openTitle').html('<span id="openClose"></span>'+$title.html());
	$('.openPanel').html('<div class="entLink">'+$end.html()+'</div>');
	
	$('.openText').attr({'style':(height ? 'height:'+height+'px;' : '')+(minHeight ? 'min-height:'+minHeight+'px;' : '')+(maxHeight ? 'max-height:'+maxHeight+'px;' : '')}).html($text.html());
	$('#open').attr({'style':'margin: '+marg+'px auto '+marg+'px auto; width:'+width+'px;'});
	
	$(window).resize(function(){
		marg = (($(window).height() - noHeight)/2)-10;
		marg = marg < 20 ? 20 : Math.ceil(marg);
		$('.openText').attr({'style':(height ? 'height:'+height+'px;' : '')+(minHeight ? 'min-height:'+minHeight+'px;' : '')+(maxHeight ? 'max-height:'+maxHeight+'px;' : '')});
		$('#open').attr({'style':'margin: '+marg+'px auto '+marg+'px auto; width:'+width+'px;'});
	});
	
	$(html).attr({'style':'overflow-y: scroll; display: none;'}).fadeIn(200);
	$('*#openClose' + (allclose ? ', #openCloseHtml' : '')).click(function(event){
		$('body').attr({'style':''});
		$(html).attr({'style':'display: none;'});
		option.openWin = false;
		if ($('#ajax-messages > div > span#ajax-message-remove:contains("1")').size()) jMessClose();
	});
};


var tes = $('#tas'),
	win = $(document),
	test = tes.offset(),
	zxc = $('#zxc');

tes.hover(function(){
	
	setTimeout(function(){
		zxc.css({'top':(test.top - tes.outerHeight() - (zxc.outerHeight())+20)+'px', 'left':(test.left - zxc.outerWidth()/2 + tes.outerWidth()/2)+'px'}).fadeIn(300);
	}, 100);
	
	
	
}, function(){
	
	c = setTimeout(function(){zxc.stop(true, true).fadeOut(300)}, 100);
	
	zxc.hover(function(){
		clearTimeout(c);
		zxc.css({'display':'inline'});
		
	}, function(){
	
	setTimeout(function(){zxc.stop(true, true).fadeOut(300)}, 100);
	
	});
	
});