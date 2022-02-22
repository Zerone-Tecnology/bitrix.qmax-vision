/*!
	---------- ilab - jQuery Plugin exclusively for Bitrix
	---------- version: 0.0.1 Beta (September 2018)
	---------- @requires jQuery v3.2.1

	---------- Copyright 2018 iLab - info@ilab.kz

	$.ilab() = function | Вызов - $.ilab();
	$.fn.ilab() = function | Вызов - $('selector').ilab();
!*/

(function( ilab, $, undefined ) {
	"use strict";

	// ilab object
	ilab.params = {}
	ilab.info = {}
	ilab.methods = {}

	var __DIR__ = '/local/modules/ilab.kernel/lib/ilab/modules/',
// ---------------------------------------------------------------------------------------------------- Params
	params = {
		ilab : {
			option : 'params ilab work'
		}
	},
// ---------------------------------------------------------------------------------------------------- Info
	info = {
		ilab : function( o,s )
		{
			_F._log('info ilab work');
		},
		init : function( o,s )
		{

			console.groupCollapsed('iLab - jQuery Plugin');
				console.info('Hello world! p.s. from iLab');
				console.groupCollapsed('Call example :');
					_F._log('\t$.ilab(\'method\', {help:true, more options...});', 'r');
					_F._log('\t$(\'selector\').ilab(\'method\', {help:true, more option....});', 'r');
					_F._log('\tif( $.fn.ilab ){$.ilab(...,{..})} - Сheck for the existence of the plugin ilab.', 'r');
				console.groupEnd();
				console.groupCollapsed('methods:');
					// ----------------------------------------
					$.each(methods, function( i,v ){
						console.log(i,v);
					});
					// ----------------------------------------
				console.groupEnd();
				console.groupCollapsed('Available methods:');
					console.log(methods);
				console.groupEnd();
			console.groupEnd();

			return s;

		}
	},
// ---------------------------------------------------------------------------------------------------- Method
	methods = {
		ilab : function( o,s )
		{

			_F._log('method ilab work');

		}
	},
// ---------------------------------------------------------------------------------------------------- Funtions
	_F = {
		_log : function ( m,s )
		{

			var style = {
				'r': 'font-weight:bold;font-size:120%;color:#FA3535;',
				'b': 'font-weight:bold;font-size:120%;color:#111111;',
				'g': 'font-weight:bold;font-size:120%;color:#5B945B;',
				'd': 'font-weight:bold;font-size:120%;color:#9F9F9F;'
			}
			if ( !style[s] )
				s = 'd';
			console.log ( '%c'+m, style[s] );

		},
	}

	// $('selector').ilab(); event
	$.fn.ilab = function( event, options ) {

//		console.log('Start work $.fn.ilab( event, options )');

		return this.each(function() {
			var settings = $.extend({
				this: $(this)
			}, options );

			return $.ilab( event, settings );
		});

	};

	// $.ilab(); event
	$.ilab = function( event, options ) {

//		console.log('Start work $.ilab( event, options )');

		// Call $.ilab() options undefined?
		options = options || {};

		// data-option="" options
		if( options.this && options.this.data() )
			options = $.extend(true,  {}, options.this.data(), options);

		// Status
		var status = false,
			settings = {},
			help = {},
			method = {}

/*
		ilabOptions = {
			version						: 'iLab 0.0.1', // version
			help						: false, // help

			// Callbacks
			onAfter						: undefined, // onAfter
			onBefore					: undefined, // onBefore
		},
		defaultOptions = {
			CompareModal: {
				vKEY					: 'CompareModal_v0.0.1',

				this					: undefined,
			},
			CompareToggle: {
				vKEY					: 'CompareToggle_v0.0.1',

				this					: undefined,
				iblock_id				: false,
				id						: false,
				button_class			: false,
				loader_class			: false,
				change_class			: false,
				count_class				: '.j_ct_count',
				stiker_class			: '.j_item_compare_stiker',
				change_text				: false,
				remove_second			: false,
			}
		};*/

// ---------------------------------------------------------------------------------------------------- Setting

//console.log('settings', settings);

		// params general ilab
		if( params[event] )
			settings = params[event];

//console.log('settings', settings);

		// params ilab
		if( ilab.params[event] )
			settings = ilab.params[event];

//console.log('settings', settings);

		// options ilab
		if( options )
			settings = $.extend(true,  {}, settings, options);

//console.log('settings', settings);

// ---------------------------------------------------------------------------------------------------- Help ---------------------------------------------------------------------------------------------------- TODO

//console.log('help', help);

		// info help general ilab
		if( info[event] )
			help[event] = info[event];

//console.log('help', help);

		// info help ilab
		if( ilab.info[event] )
			help[event] = ilab.info[event];

//console.log('help', help);

// ---------------------------------------------------------------------------------------------------- Method

//console.log('method', method);

		// method general ilab
		if( methods[event] )
			method[event] = methods[event];

//console.log('method', method);

		// method ilab
		if( ilab.methods[event] )
			method[event] = ilab.methods[event];

//console.log('method', method);

// ---------------------------------------------------------------------------------------------------- Callback onBefore
		if( !settings.help && $.isFunction(settings.onBefore) )
			settings.onBefore.call(this, settings, _F);
// ---------------------------------------------------------------------------------------------------- Callback onBefore

// ---------------------------------------------------------------------------------------------------- Result
		if ( settings.help && help[event] )
			var result = help[event].call(this, settings, status);
		else if( !settings.help && method[event] )
			var result = method[event].call(this, settings, status);
		else if ( typeof event==='object' || !event )
			var result = info.init.call(this, settings, status);
		else
			$.error( 'Метод с именем ' +  event + ' не существует для $.ilab(); || $(\'selector\').ilab();' );
// ---------------------------------------------------------------------------------------------------- Result

// ---------------------------------------------------------------------------------------------------- Callback onAfter
		if( !settings.help && $.isFunction(settings.onAfter) )
			settings.onAfter.call(this, settings, _F);
// ---------------------------------------------------------------------------------------------------- Callback onAfter

		return result;

	};

})( window.ilab = window.ilab || {}, jQuery );


/**
 * __DIR__ & __FILE__ for JavaScript (was tested in IE 7-10)
 * This definition must be inserted at root of script file, outside of any function.
 * Link to code - https://gist.github.com/adamasantares/04cf84e3a99326a4d73f
 */
(function(w,d){
	var u=null;
	w.__FILE__=(function(){
		try{u();}catch(err){
			if(err.stack){
				u=(/(http[s]?:\/\/.*):\d+:\d+/m).exec(err.stack);
				if(u&&u.length>1){ return u[1]; }
			}
			u = (d.scripts.length>0) ? d.scripts[d.scripts.length-1].src : "";
			if (u.length > 0 && u.indexOf("://") < 0 && u.substring(0,1) != "/" ){
				u = location.protocol + "//" + location.host + "/" + u;
			}
			return u;
		}
	})();
	w.__DIR__=(function(f){
		f=(/^(.*\/)[a-z0-9 -_]+\.[a-z]+$/i).exec(f);
		return (f&&f.length>1)?f[1]:"";
	})(w.__FILE__);
})(window, document);