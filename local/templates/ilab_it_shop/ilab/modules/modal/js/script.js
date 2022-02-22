/*!
	---------- ilab - jQuery Plugin exclusively for Bitrix
	---------- version: 0.0.1 Beta (September 2018)
	---------- @requires jQuery v3.2.1
	----------
	---------- Copyright 2018 iLab - info@ilab.kz

	ilab = function | Вызов - ilab.function();
!*/

(function( ilab, $, undefined ) {

// ---------------------------------------------------------------------------------------------------- Private Property
//	var isHot = true;
	var modal = $('.j_modal');
	var delta = modal.find('.j_modal_delta');
	var close = modal.find('.j_modal_close');

// ---------------------------------------------------------------------------------------------------- Public Property
//	ilab.ingredient = 'Hello world from ilab!';

// ---------------------------------------------------------------------------------------------------- Public params
	ilab.params['ilab'] = {
		option : 'work params ilab MODAL'
	}
	ilab.params['Modal'] = {
		button : undefined,
		vKEY : 'Modal_v0.0.1', // Версия
		showClass : undefined, // Класс div'а который нужно показать в модальном окне
		addId : undefined, // Id который нужно добавить модальному окну
		/*
		position: {
			horizontal: 'outerLeft' | 'left' | 'center' | 'right' | 'outerRight',
			vertical: 'outerTop' | top' | 'center' | 'bottom' | 'outerBottom'
			||
			320: {
				horizontal: 'outerLeft' | 'left' | 'center' | 'right' | 'outerRight',
				vertical: 'outerTop' | top' | 'center' | 'bottom' | 'outerBottom'
			},
			// when window width is <= 640px
			640: {
				horizontal: 'outerLeft' | 'left' | 'center' | 'right' | 'outerRight',
				vertical: 'outerTop' | top' | 'center' | 'bottom' | 'outerBottom'
			},
			// when window width is <= 480px
			480: {
				horizontal: 'outerLeft' | 'left' | 'center' | 'right' | 'outerRight',
				vertical: 'outerTop' | top' | 'center' | 'bottom' | 'outerBottom'
			}
		}*/
		position : false, // (Выше пример параметра) Позиция модального окна (resize в приоритете) (порядок не имеет значения) (по умолчанию слева под кнопкой)
		fixed : false // Фиксированное модально окно, расчёт позиции модального окна при position: fixed
	}
// ---------------------------------------------------------------------------------------------------- Public info Method
	ilab.info['ilab'] = function( o,s )
	{
		console.log('info ilab work MODAL');
	}
	ilab.info['Modal'] = {
		'a' : 1
	}
// ---------------------------------------------------------------------------------------------------- Public Method
	ilab.methods['ilab'] = function( d )
	{

		console.log('method ilab work MODAL');

	}
	ilab.methods['Modal'] = function( o,s )
	{

//console.log( o,s );

		// hide div's
		$('.j_modal_body > div, .j_modal_title > div:not(.j_modal_close)', modal).hide();

		// reset attr
		$('.j_modal')
			.data('params', o)
			.attr('id','');

		// show inside div's
		if(o.showClass)
			$(o.showClass).show();

		// add id
		if(o.addId)
			modal.attr('id', o.addId);

		// Show
		if( modal.data('fade') == o.addId )
			modal.data('fade', '').fadeOut();
		else
			modal.data('fade', o.addId).fadeIn();

		// Position modal
		if( o.button )
			_F._modalPosition( modal, o, o.position, o.button );

	}
// ---------------------------------------------------------------------------------------------------- Private Method
	_F = {
		/*
			var m Modal
			var p Position
			var b Button
		*/
		_modalPosition : function ( m, o, p = [] ,b )
		{

			// reset attr
			$('.j_modal')
				.css({
					top: '',
					right: '',
					bottom: '',
					left: ''
				});

			var w = $(window).width();
			// Вернём массив ключей чисел объекта - параметра позиции модального окна
			var resize = Object.keys(p).filter((v) => +v);

			// Общий объект размеров и позиционирования
			c = {
				h: $('body').outerHeight(),
				w: $('body').outerWidth(),

				bh: b.outerHeight(),
				bw: b.outerWidth(),

				bt: b.offset().top,
				bl: b.offset().left,

				mh: m.outerHeight(),
				mw: m.outerWidth()
			}

			if( o.fixed )
			{
				c.h = $(window).outerHeight();
				c.bt = c.bt-$(window).scrollTop();
			}

			/*if( $('#bx-panel').length )
			{
				var bx = Math.round( $('#bx-panel').height() );

				c.bt = c.bt - bx;
			}*/

			if( p.vertical )
				var vertical = p.vertical;

			if( p.horizontal )
				var horizontal = p.horizontal;

			// Есть параметры для ресайза
			if( resize.length )
			{

				// Преобразуем массив в числа и отсортируем
				var vkey = resize.map(Number).sort((a, b) => b - a);

//console.log(resize, vkey, p);

				var current;

				// when window width is <= params position
				$.each(vkey, function( i,v ) {
					if( w>v )
						return false;

					current = v;
				});
//console.log( 'work: '+current+' result work: '+p[current] );

				// Если нашли параметры под разрешение
				if( current )
				{
					if( p[current].vertical )
						var vertical = p[current].vertical;

					if( p[current].horizontal )
						var horizontal = p[current].horizontal;
				}

			}

//console.log('RESULT: ', vertical, horizontal)

			/*
				Вычислим как распологать модальное окно относительно кнопки, по заданым параметрам при вызове метода,
				либо разместим окно по умолчанию слева под кнопкой
			*/

			var pos = {}

			// Vertical
			switch( vertical )
			{
				case 'outerTop':

					pos['bottom'] = c.h - c.bt;//pos['top'] = c.bt-c.mh;

					break;
				case 'top':

					pos['top'] = c.bt;

					break;
				case 'center':

					pos['top'] = c.bt + (c.bh/2) - (c.mh/2);

					break;
				case 'bottom':

					pos['bottom'] = c.h - c.bt - c.bh;//pos['top'] = c.bt+c.bh-c.mh;

					break;
				case 'outerBottom':

					pos['top'] = c.bt + c.bh;

					break;
				default:// outerBottom

					pos['top'] = c.bt + c.bh;
			}

			// Horizontal
			switch( horizontal )
			{
				case 'outerLeft':

					pos['right'] = c.w - c.bl;//pos['left'] = c.bl-c.mw;

					break;
				case 'left':

					pos['left'] = c.bl;

					break;
				case 'center':

					pos['left'] = c.bl + (c.bw/2) - (c.mw/2);

					break;
				case 'right':

					pos['right'] = c.w - c.bl - c.bw;//pos['left'] = c.bl + c.bw - c.mw;

					break;
				case 'outerRight':

					pos['left'] = c.bl + c.bw;

					break;
				default:// left

					pos['left'] = c.bl;
			}
//console.log('CSS:', pleft, ptop);

			m.css(pos);

			_F._modalDelta(vertical, horizontal, c, pos);

			/* OLD if switch
			var hOuterLeft = c.bl-c.mw;
			var hLeft = c.bl;
			var hCenter = c.bl+(c.bw/2) - (c.mw/2);;
			var hRight = c.bl+c.bw-c.mw;
			var hOuterRight = c.bl+c.bw;

			if( p.horizontal=='outerLeft' )
				m.css('left', hOuterLeft);
			if( p.horizontal=='left' )
				m.css('left', hLeft);
			if( p.horizontal=='center' )
				m.css('left', hCenter);
			if( p.horizontal=='right' )
				m.css('left', hRight);
			if( p.horizontal=='outerRight' )
				m.css('left', hOuterRight);*/

			/* OLD if switch
			var vOuterTop = c.h-c.bt;
			var vTop = c.h-c.bt;
			var vCenter = c.bt+(c.bh/2) - (c.mh/2);
			var vBottom = c.bt+c.bh;
			var vOuterBottom = c.bt+c.bh;

			if( p.vertical=='top' )
				m.css('bottom', vTop);
			if( p.vertical=='center' )
				m.css('top', vCenter);
			if( p.vertical=='bottom' )
				m.css('top', vBottom);*/

		},
		/*
			var v Vertical position
			var h Horizontal position
			var c Object position sizes
		*/
		_modalDelta : function ( vertical,horizontal,c,pos )
		{

			// Vertical
			switch( vertical )
			{
				case 'outerTop':
				case 'bottom':

					var v = 'b';

					break;
				case 'center':

					var v = 'c';

					break;
				case 'top':
				case 'outerBottom':

					var v = 't';

					break;
				default:// outerBottom

					var v = 't';
			}

			// Horizontal
			switch( horizontal )
			{
				case 'outerLeft':
				case 'right':

					var h = 'r';

					break;
				case 'center':

					var h = 'c';

					break;
				case 'left':
				case 'outerRight':

					var h = 'l';

					break;
				default:// left

					var h = 'l';
			}
//console.log( v+h );
			delta
				.attr('id', 'i_d_'+v+h)
				.css({
					height:'',
					width:'',
					top:'',
					left:''
				});

			if( horizontal=='center' )
				delta.css( 'left', (c.bl-modal.offset().left) );
			if( vertical=='center' )
				delta.css( 'top', (c.bt-modal.offset().top) );

			if( horizontal=='center' && vertical=='center' )
				delta.css({height: c.bh, width: c.bw});
			else if( horizontal=='outerLeft' || horizontal=='outerRight' || vertical=='center' )
			{
				delta.css('height', c.bh);
				delta.css( 'top', (c.bt-modal.offset().top) );
			} else {
				delta.css('width', c.bw);
				delta.css( 'left', (c.bl-modal.offset().left) );
			}

/*
			var if_v_h = ['left', 'center', 'right'];// if vertical - no outer horizontal
			var if_v_oh = ['outerLeft', 'left', 'right', 'outerRight'];// if vertical - outer horizontal

			var if_h_v = ['top', 'center', 'bottom'];// if horizontal - no outer vertical
			var if_h_ov = ['outerTop', 'top', 'bottom', 'outerBottom'];// if horizontal - outer vertical
*/


/*
// All position

// vertical
'outerTop' && 'left' || 'center' || 'right'
'top' && 'left' || 'center' || 'right'

'center' && 'outerLeft' || 'left' || 'right' || 'outerRight'

'bottom' && 'left' || 'center' || 'right'
'outerBottom' && 'left' || 'center' || 'right'


// horizontal
'outerLeft' && 'top' || 'center' || 'bottom'
'left' && 'top' || 'center' || 'bottom'

'center' && 'outerTop' || 'top' || 'bottom' || 'outerBottom'

'right' && 'top' || 'center' || 'bottom'
'outerRight' && 'top' || 'center' || 'bottom'


// Center
'center' && 'center'


// Outer
'outerTop' && 'outerLeft'
'outerRight' && 'outerTop'
'outerBottom' && 'outerRight'
'outerLeft' && 'outerBottom'
*/


		},
		_modalResize : function ( m,p=[],t )
		{

			if( modal.length && modal.is(':visible') && modal.data('params').button )
				_F._modalPosition(modal, modal.data('params'), modal.data('params').position, modal.data('params').button);

		},
		_modalClose : function ()
		{

			modal.hide().data('fade', '');;

		},
		_outsideElementHide : function (ev)
		{

//			console.log( $(ev.target).closest().filter(modal).length );

//			console.log( $(ev.target) );
//			console.log( $(ev.target).parents().filter(modal).length, $(ev.target).filter(modal).length )
//			console.log( $(ev.target).parents().filter(modal).length != 1, $(ev.target).filter(modal).length != 1 );
//			console.log( $(ev.target).parents().filter(modal).length < 1, $(ev.target).filter(modal).length < 1 );

//			if ( ($(ev.target).parents().filter(modal).length != 1) && ($(ev.target).filter(modal).length != 1) )
//			if ( ($(ev.target).parents().filter(modal).length < 1) && ($(ev.target).filter(modal).length < 1) )
			if( $(ev.target).closest(modal).length < 1 )
				_F._modalClose();

		},
		// Debounce
		_debounce : function ( func,time )
		{
			var time = time || 100; // 100 by default if no param
			var timer;
			return function(event){
				if(timer) clearTimeout(timer);
				timer = setTimeout(func, time, event);
			};
		}

	}

// ---------------------------------------------------------------------------------------------------- Scripts
	$(document).ready(function(){

		$(window)
			.resize( _F._modalResize )
			.resize( _F._debounce( _F._modalResize,50 ) );

		$(document).on('click', _F._outsideElementHide);
		$('body').on('click', '.j_modal_close', _F._modalClose);

	});

}( window.ilab = window.ilab || {}, jQuery ));