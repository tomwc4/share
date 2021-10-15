import { refresh_mini_cart } from './modules/refresh-mini-cart'

(function (root, $, Cookies) {
	'use strict';
 
	$(function () {

		// if it's a pre-order product, change add to cart button text
		function handle_preorder_changes(){
			if( $('.bc-btn--preorder').length ){
				$('.bc-btn--preorder, .product-detail__add-to-cart-button').text('Pre-Order Now');
				$('.bc-product-form__purchase-message').html('<div class="bc-product-form__preorder-message">'+$('#preorder_messaging').html()+'</div>');
				$('.product-detail__find-a-dealer').css('display','none');
				if(!$('.bc-btn--preorder').parent().find('#preorder-notify-btn').length) {
					$('.bc-btn--preorder').parent().append('<div id="preorder-notify-btn" class="product-detail__preorder-notify-button">Notify When Available</div');
				}
				$('.bc-product-form__purchase-message').prepend('<div class="product-detail__preorder-message-info">'+$('#preorder_messaging_moreinfo').html()+'</div');
			}
		}

		handle_preorder_changes();

		function display_product_preorder_message(){
			var message = $('#preorder_form').html();
			$('.modal__content').css('max-width','620px'); 
			$('.modal__content__inner').css('max-width','620px');
			$('.modal__close').css('top','22px');
			$('.modal__content__inner').html( message );			
			$('.modal').addClass('active');	

			//pre-order inner content
			$('.modal__content__inner').find('.product-detail__preorder-notify-button').addClass('active');
			
			$('.modal__content__inner').find('.product-detail__preorder-notify-button').on('click', function () {
				close_preorder_modal();
			});

			//load Klaviyo form based on passed classname ID
			if($('#preorder_form .formID').length) {
				var klaviyoForm = document.createElement('div');
				klaviyoForm.className = $('#preorder_form .formID').data('form-id');
				$('.modal__content__inner').append(klaviyoForm);
			}
			
		}

		//pre-order pop-up messaging 
		$('body').on('click', '#preorder-notify-btn', function () {
			display_product_preorder_message();					
		});	

		function close_preorder_modal(e) {
			close_modal();
		}

		if($('#preorder_form').length) {
			$('.product-detail__add-to-cart-button').css('margin-top','20px');
		}
		
		$('body').on('click', '.product-detail__preorder-message__learn-more', function () {
			if($('.product-detail__preorder-message-info').css('opacity') == 0) {
				$('.product-detail__preorder-message-info').css('opacity','1');
				$('.product-detail__preorder-message-info').css('visibility','visible');
				$('.bc-product-form__preorder-message').css('margin-top',$('.product-detail__preorder-message-info').outerHeight());	
			} else {
				$('.product-detail__preorder-message-info').css('opacity','0');
				$('.product-detail__preorder-message-info').css('visibility','hidden');
				$('.bc-product-form__preorder-message').css('margin-top','36px');
			}
		});

		$('body').on('click', '.product-detail__preorder-message-info__close', function () {
			$('.product-detail__preorder-message-info').css('opacity','0');
			$('.product-detail__preorder-message-info').css('visibility','hidden');
			$('.bc-product-form__preorder-message').css('margin-top','0');
		});

		$('body').on('click', '.product-detail__backorder-message__learn-more', function () {
			if($('.product-detail__backorder-message-info').css('opacity') == 0) {
				$('.product-detail__backorder-message-info').css('opacity','1');
				$('.product-detail__backorder-message-info').css('visibility','visible');
				$('.product-detail__backorder-message').css('margin-top',$('.product-detail__backorder-message-info').outerHeight()+40);	
			} else {
				$('.product-detail__backorder-message-info').css('opacity','0');
				$('.product-detail__backorder-message-info').css('visibility','hidden');
				$('.product-detail__backorder-message').css('margin-top','36px');
			}
		});

		$('body').on('click', '.product-detail__backorder-confirm .label', function () {
			if($('#backorder_confirm').prop("checked") == true) {
				$('#backorder_confirm').prop("checked", false);
			} else {
				$('#backorder_confirm').prop("checked", true);
			}
		});

		$('body').on('click', '.product-detail__backorder-message-info__close', function () {
			$('.product-detail__backorder-message-info').css('opacity','0');
			$('.product-detail__backorder-message-info').css('visibility','hidden');
			$('.product-detail__backorder-message').css('margin-top','36px');
		});

		// mini cart popup on add to cart.  
		$('body').on('click', '.bc-btn--add_to_cart', function () {
			$(this).css('display', 'block');
			$('.product-detail__add-to-cart-button').css('display', 'none');
			$(document).on('bigcommerce/ajax_cart_update', show_mini_cart);
		});

		//alternate mini cart functions for 99Minds giftcards (it uses BigC API to add to cart)
		function show_mini_cart_giftcards() {
			var minicart_interval_gc = setInterval(function(){
				if($('#has_gift_card_purchase').length ){
					refresh_mini_cart($,Cookies); // attached to module: refresh-mini-cart.js
					size_and_position_mini_cart();
					$('#has_gift_card_purchase').remove();
				}
			}, 500);
		}

		//run check for cart interval if gift card widget is present
		if($('#giftcard-container').length){
			show_mini_cart_giftcards();
		}
		
		function show_mini_cart() {
			if( $('.bc-mini-cart--nav-menu .bc-cart__empty').length && $('.modal-mini-cart').hasClass('active') ){
				$('.bc-mini-cart--nav-menu .bc-cart__empty').css('opacity', 1);
			} else {
				var minicart_interval = setInterval(function(){
					if( $('.bc-mini-cart--nav-menu section.bc-mini-cart').length  ){
						clearInterval( minicart_interval );
						size_and_position_mini_cart();
						$('.bc-mini-cart--nav-menu').addClass('bc-show-mini-cart-nav');
						if ($('.modal-mini-cart__overlay').length < 1) {
							$('.modal-mini-cart').append('<div class="modal-mini-cart__overlay"></div>');
							$('body .modal-mini-cart__overlay').addClass('active');
						}
												
						$('.modal-mini-cart').addClass('active');
					}
				}, 100);
			}
	
			$('.bc-btn--add_to_cart').css('display', 'none');
			$('.product-detail__add-to-cart-button').css('display', 'block');

			$(document).off('bigcommerce/ajax_cart_update', show_mini_cart);
		}
	
		function size_and_position_mini_cart() {
			var dh = $(document).height();
			$('.modal-mini-cart, .modal-mini-cart__overlay').height(dh);
			// position modal content vertically just a bit below the top of the page
			var vertical_position = $(document).scrollTop();
			$('.bc-mini-cart--nav-menu').css('top', vertical_position + 'px');
		}
	
		$('body').on('click', '.product-detail__add-to-cart-button', function () {
			
			//check if is backordered first
			if($('.product-detail__backorder-confirm').length) {
				if($('#backorder_confirm').prop('checked')) {
					$('.product-detail__form-container .bc-btn--add_to_cart').click();
				}
			}

		});		

    });

}(this, jQuery, window.Cookies));