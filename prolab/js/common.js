(function () {

    var $jsProductDel = $('.js-product-del');
    $('[class*=js-product-del]').on('click', function(e){
        e.preventDefault();
        e.stopPropagation();

        var name = $(this).attr('class');
        var id = name[name.length - 1];
        var scrollPos = $(window).scrollTop();

        $('#product-'+id).hide()
    });
	var pl = {};

	window.pl = pl;

	$.fn.exists = function () {
		return this.length !== 0;
	};

	var classNames = {
		active: 'active',
		wrapperDropdown: 'wrapper-dropdown',
		popupBox: 'popup-box',
		blackout: 'blackout',
		productBuyBtn: 'my-button',
		popupBtnContinue: 'popup-btn__continue',
		close: 'close',
        popupBoxEnter: 'popup-box-enter',
        jsEnter: 'js-enter',
        btnReg: 'registration-btn',
		plScrollFix: 'pl-scroll-fix'
	};

	var ids = {};

	var buildSelectors = function (selectors, source, characterToPrependWith) {
		$.each(source, function (propertyName, value) {
			selectors[propertyName] = characterToPrependWith + value;
		});
	};

	pl.buildSelectors = function (classNames, ids) {
		var selectors = {};
		if (classNames) {
			buildSelectors(selectors, classNames, ".");
		}
		if (ids) {
			buildSelectors(selectors, ids, "#");
		}
		return selectors;
	};

	var selectors = pl.buildSelectors(classNames, ids);

	function DropDown(el) {
		this.dd = el;
		this.placeholder = this.dd.children('span');
		this.opts = this.dd.find('ul.dropdown > li');
		this.val = '';
		this.index = -1;
		this.initEvents();
	}

	DropDown.prototype = {
		initEvents: function () {
			var obj = this;

			obj.dd.on('click', function (event) {
				$(this).toggleClass(classNames.active);
				return false;
			});

			obj.opts.on('click', function () {
				var opt = $(this);
				obj.val = opt.text();
				obj.index = opt.index();
				obj.placeholder.text(obj.val);
			});
		},
		getValue: function () {
			return this.val;
		},
		getIndex: function () {
			return this.index;
		}
	};

	var $wrapperDropdown,
		dd,
		$productBuyBtn,
		$popupBox;

    var $popupBoxEnter,
        $btnReg,
        $jsEnter;


	var boxWidth = 560;

	function centerBox() {
		var winWidth = $(window).width();
		var winHeight = $(document).height();
		var scrollPos = $(window).scrollTop();
		var disWidth = (winWidth - boxWidth) / 2;
		var disHeight = scrollPos + 150;

		$popupBox.css({'width': boxWidth + 'px', 'left': disWidth + 'px', 'top': disHeight + 'px'});
		$(selectors.blackout).css({'width': winWidth + 'px', 'height': winHeight + 'px'});
		return false;
	}

	var $body = $(document.body);

	var plScrollFixOffset,
		$plScrollFix;

	$(function () {
		$plScrollFix = $(selectors.plScrollFix);
		$productBuyBtn = $(selectors.productBuyBtn);
		$wrapperDropdown = $(selectors.wrapperDropdown);
		$popupBox = $(selectors.popupBox);
		dd = new DropDown($wrapperDropdown);
        $popupBoxEnter = $(selectors.popupBoxEnter);
        $jsEnter = $(selectors.jsEnter);
        $btnReg = $(selectors.btnReg);

		if ($plScrollFix.exists()) {
			plScrollFixOffset = $plScrollFix.offset();
		}

		//Popup
		$(document.body).append($('<div/>', {class: classNames.blackout}));

		centerBox();
        hidePopupBox();

		$productBuyBtn.on('click', function() {
			var scrollPos = $(window).scrollTop();
			$('#popup-box').show();
			$('.blackout').show();
			//$(selectors.blackout).show();
			$(document).scrollTop(scrollPos);
			return false;
		});

        $jsEnter.on('click', function(){
            var scrollPos = $(window).scrollTop();
            $popupBoxEnter.show().find(".tab-2").show();
            $popupBoxEnter.find(".tab-1").stop(false,false).hide();
            $popupBoxEnter.find(".top a").removeClass("active");
            $('.popup-box-enter__btn-enter').addClass("active");
            $(selectors.blackout).show();
            $(document).scrollTop(scrollPos);
            return false;
        });

        $btnReg.on('click', function(){
            var scrollPos = $(window).scrollTop();
            $popupBoxEnter.show().find(".tab_content div").show();
            $popupBoxEnter.find(".tab-2").stop(false,false).hide();
            $popupBoxEnter.find(".top a").removeClass("active");
            $('.popup-box-enter__btn-reg').addClass("active");
            $(selectors.blackout).show();
            $(document).scrollTop(scrollPos);

			$('#opt-chbox').click(function(){
				console.log('Opt');
				if($(this).prop('checked')){
					$('#rozn-chbox').prop("checked", false);
				}else{
					$('#rozn-chbox').prop("checked", true);
				}
			});

			$('#rozn-chbox').click(function(){
				console.log('Rozn');
				if($(this).prop('checked')){
					$('#opt-chbox').prop("checked", false);
				}else{
					$('#opt-chbox').prop("checked", true);
				}
			});

            return false;

        });

        //Switch btn
        $("div.popup-box-enter").each(function () {
            var tmp = $(this);
            $(tmp).find(".top a").each(function (i) {
                $(tmp).find(".top a:eq("+i+")").click(function(){
                    var tab_id=i+1;
                    $(tmp).find(".top a").removeClass("active");
                    $(this).addClass("active");
                    $(tmp).find(".tab_content div").stop(false,false).hide();
                    $(tmp).find(".tab-"+tab_id).stop(false,false).fadeIn(300);
                    return false;
                });
            });
        });
	});

    var hidePopupBox = function() {
        $popupBox.hide();
        $(selectors.blackout).hide();
    };

    $(document).on('click', function() {
        // all dropdowns
        $wrapperDropdown.removeClass(classNames.active);
    });

    $(document).on('click', selectors.blackout, hidePopupBox);

	$(document).on('resize', centerBox);

	$(document).on('scroll', function() {
        centerBox();
		if ($plScrollFix.exists()) {
			var $this = $(this),
				thisScrollTop = $this.scrollTop();

			if (thisScrollTop + 40 >= plScrollFixOffset.top) {
				$plScrollFix.addClass('fixed');
			} else {
				$plScrollFix.removeClass('fixed');
			}
		}
	});

	$(document).on('click', selectors.popupBtnContinue, function() {
		hidePopupBox();
		return false;
	});

	$(document).on('click', selectors.close, function () {
		hidePopupBox();
		return false;
	});

})();
$(document).ready(function(){

	jQuery.fn.ForceNumericOnly =
		function()
		{
			return this.each(function()
			{
				$(this).keydown(function(e)
				{
					var key = e.charCode || e.keyCode || 0;
					// Разрешаем backspace, tab, delete, стрелки, обычные цифры и цифры на дополнительной клавиатуре
					return (
					key == 8 ||
					key == 9 ||
					key == 46 ||
					(key >= 37 && key <= 40) ||
					(key >= 48 && key <= 57) ||
					(key >= 96 && key <= 105));
				});
			});
		};

	var button_position = 0;

	$('#order-catalog').click(function(){

		if(button_position == 1){
			$('#order-document').removeClass('active');
			$(this).addClass('active');
			button_position = 0;
			$('#catalog-form').show();
			$('#document-form').hide();
		}else{
			$('#order-document').addClass('active');
			$(this).removeClass('active');
			button_position = 1;
			$('#catalog-form').hide();
			$('#document-form').show();
		}

	});

	$('#order-document').click(function(){

		if(button_position == 0){
			$('#order-catalog').removeClass('active');
			$(this).addClass('active');
			button_position = 1;
			$('#catalog-form').hide();
			$('#document-form').show();
		}else{
			$('#order-catalog').addClass('active');
			$(this).removeClass('active');
			button_position == 0;
			$('#catalog-form').show();
			$('#document-form').hide();
		}

	});

	$("#summ-price-box .quantity").ForceNumericOnly();

	$('#summ-price-box .quantity').bind('keyup',function (){
		var AllSumm = 0;
		var ProductsIdToPHP = '';
		var Sale = Number($('#user_sale').attr('user-sale'));
		$('div#summ-price-box').each(function () {
			var block_sum = 0;
			$(this).find('.quantity').each( function (){
				var price = Number($(this).val());


					block_sum += price;
					if(Number($(this).val()) > 0) {
						ProductsIdToPHP += Number($(this).val())+':'+$(this).attr('product-id')+':'+$(this).attr('slug') + ';';
					}
			});

			block_sum *= Number($(this).attr('price'));
			AllSumm += block_sum;
			if(Sale > 0 && Sale < 100) {
				block_sum = block_sum - block_sum * (Sale / 100);
				block_sum = Math.round(block_sum).toFixed(0);
			}
			$('#block-price-'+$(this).attr('uid')).text(block_sum);
		});
		ProductsIdToPHP = ProductsIdToPHP.substring(0, ProductsIdToPHP.length - 1);

		if(Sale > 0 && Sale < 100) {
			AllSumm = AllSumm - AllSumm * (Sale / 100);
			AllSumm = Math.round(AllSumm).toFixed(0);
		}

		$('#full-summ').text(AllSumm);
		$('#cart-full-summ').text(AllSumm);
		$('#products-id-field').val(ProductsIdToPHP);

		if(AllSumm > 0){
			$('#empty-cart').hide();
			$('.product-buy__btn').show();
		}else{
			$('#empty-cart').show();
			$('#catalog-form .product-buy__btn').hide();
		}
		//console.log(ProductsIdToPHP)
	});

	$("input.input-text.qty.text").change(function () {
		//alert($(this).val());
		$('input[name=update_cart]').click();
	});
			$('input.custom-file-input').change(function() {
				var text = $(this).val();
				var lastindex = text.lastIndexOf('\\')+1;
				if(lastindex !== -1){
					text = text.substr(lastindex);
				}
				$('input.fileInputText').val(text);
			});

	$("form#main-send-form").submit(function() {
		var str = new FormData($('form#main-send-form')[0]);
		$.ajax({
			type: "POST",
			processData: false,
			contentType: false,
			url: "/wp-content/themes/prolab/components/mail.php",
			data: str,
			success: function(msg) {
				if(msg == 'OK') {
					result = 'Сообщение отправлено успешно';
					$('#POST-name').val('');
					$('#POST-tel').val('');
					$('#POST-com').val('');
					alert(result);
				}
				else {result = msg; alert('Ошибка отправки сообщения');}

			}
		});
		return false;
	});

});