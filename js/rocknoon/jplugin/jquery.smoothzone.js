/**
 * =======================================================
 * smoothZone 

 * jQuery: 1.4.2
 * author: rocky
 * author blog  : www.rocknoon.com
 * 
 **/


  
  SmoothZone = {};

	/*
	 * create a class
	 */
  SmoothZone.Class = function( prototype ){
	  
	  var constractor = function(){
		  return this.initialize
	         ? this.initialize.apply(this, arguments) || this
	         : this;
	  };
	  
	  constractor.prototype = prototype;
	  
	  SmoothZone.Extend( constractor.prototype , SmoothZone.Class.Methods );
	  
	  return constractor;
  };
  
  /**
   * here you can write some father methods
   */
  SmoothZone.Class.Methods = {
		  
		 
		  
  };
  
  
  /**
   * extend a object
   */
  SmoothZone.Extend = function(destination, source, overwrite) {
	  if (!destination || !source) return destination;
	  for (var field in source) {
	    if (destination[field] === source[field]) continue;
	    if (overwrite === false && destination.hasOwnProperty(field)) continue;
	    destination[field] = source[field];
	  }
	  return destination;
	};
  
  	/**
	 * create a event function
	 */
  SmoothZone.Event = function(obj, strFunc) {
		var args = [];
		if (!obj)
			obj = window;
		for ( var i = 2; i < arguments.length; i++)
			args.push(arguments[i]);
		return function() {
			return obj[strFunc].apply(obj, args);
		};
	};
	
	/**
	 * create a callback function
	 */
	SmoothZone.Callback = function(obj, strFunc) {
		if (!obj)
			obj = window;
		return function() {
			return obj[strFunc].apply(obj, arguments);
		};
	};
	
	
	
(
function(){
	
	
	
	
	/**
	 * SmoothZone Manager
	 */
	var Core = SmoothZone.Class({
		
		_config : null,
		_$   	: null,
		_items  : null,
		_display : null,
		_tmpNext : null,
		
		initialize : function( $ , config ){

			this._items =  new Array();
			this._$ = $;
			this._initConfig(config);
			this._start();
			
		},
		
		 /**
		   * get current smoothZone version
		   */
		  getVersion : function(){
		  	return "1.0.0";
	  	  },
	  	  
	  	  
	  	  /**
	  	   * this method is only suitable for static mode 
	  	   */
	  	  add : function( $new ){
	  		  
	  		//check mode
	  		if( this._config.mode === "circle" ){
	  			throw new Exception("sorry add function only support static mode");
	  		}
	  		
	  		//create new element
	  		var firstItem = this._display.getFirst();
	  		var item = new SmoothZone.Item( $new , null );
	  		firstItem.setNext(item);
	  		this._items.push( item );
	  		
	  		
	  		this._displayNext();
	  	  },
	  	  
	  	  /**
	  	   * init config will override the default ones
	  	   * @param config
	  	   */
	  	  _initConfig : function( config ){
	  		 
	  		  //check the configuation
	  		
	  		/**
	  		  * SmoothZone.Core default configuration
	  		  */
	  		this._config = {
	  				  
	  				  speed	  : 3000,
	  				  number  : 5,
	  				  effect  : 'default',
	  				  mode	  : 'circle'
	  			
	  		};
	  		 
	  		SmoothZone.Extend( this._config , config , true );
	  	  }, 
	  	  
	  	  
	  	  _start : function(){
	  	  	  
	  		  this._parseItems();
	  		  this._initShow();
	  		  this._run();
	  		  
	  		  
	  	  },
	  	  
	  	  /**
	  	   * parse sub items into links
	  	   * mode == 'circle'
	  	   * 	circle link  
	  	   * mode == 'static'
	  	   * 	string link
	  	   */
	  	  _parseItems : function(){
	  		  
	  		  var hackThis = this;
	  		  
	  		  /**
	  		   * parse items link
	  		   */
	  		  this._$.children().each( function(){
	  			hackThis._insertLink.apply(hackThis, [$(this)]);
	  		  } );
	  		  
	  		  /**
	  		   * if mode == 'circle' specify the first item's next is the last one
	  		   * make sure the this._items is a circling link
	  		   */
	  		  if( this._config.mode == "circle" ){
	  			this._items[0].setNext( this._items[(this._items.length-1)] );
	  		  }
	  		  
	  		  /**
	  		   * if number > real amount
	  		   */
	  		  if( this._config.number > this._items.length  ){
	  			this._config.number = this._items.length;
	  		  }
	  	  },
	  	  
	  	  /**
	  	   * Create a Item and insert into link line
	  	   * @param $item
	  	   */
	  	  _insertLink : function( $item ){

	  		  var item = new SmoothZone.Item( $item , this._tmpNext );
	  		  this._items.push( item );
	  		  this._tmpNext = item;
	  	  },
	  	  
	  	  
	  	  
	  	  /**
	  	   * show the current numbers of items
	  	   */
	  	  _initShow : function(){
	  		 
	  		  for( var i = 0; i < this._items.length ;  i++ ){
	  			  if( i >= this._config.number ){
	  				  this._items[i].get$().remove();
	  			  }
	  		  }
	  		  
	  	  },
	  	  
	  	  /**
	  	   * after 
	  	   */
	  	  _run : function(){
	  		  
	  		  //init display
	  		  this._display = new SmoothZone.Display( 
	  				  	this._$ , 
	  				  	this._items[0] , 
	  				  	this._items[ (this._config.number - 1 )],
	  				  	this._config
	  		  );
	  		  
	  		  
	  		  switch( this._config.mode ){
	  			  
	  		  	case "circle" :
	  				  setInterval( SmoothZone.Callback( this , "_displayNext" ) , this._config.speed );
	  				  break;
	  		  	case "static" : 
	  		  		  break;
	  			  default : 
	  				  throw new Exception("no such mode");
	  				  break;
	  		  }
	  	  },
	  	  
	  	  /**
	  	   * notice display show next
	  	   */
	  	  _displayNext : function(){
	  		  this._display.next();
	  	  }
		
		
		
	});
	
	
	
	
	/**
	 * register into SmoothZone Namespace
	 */
	SmoothZone.Core = Core;
	
}
)();


(
function(){
	
	
	/**
	 * Display Manager
	 */
	var Display = SmoothZone.Class({
		
		_$     : null,
		_first : null,
		_last  : null,
		_config : null,
		
		initialize : function( $ , first , last , config ){
			
			this._$ = $;
			this._config = config;
			this._first	= first;
			this._last 	= last;
			
		},
		
		getFirst : function(){
			return this._first;
		},
		
		next : function(){
			
			//if next is last then return
			if( this._last == this._first.getNext() ){
				return true;
			}
			
			//insert new
			this._add( this._first.getNext() );
			//remove last
			this._remove( this._last );
			//upgrade
			this._upgrade( this._first.getNext() , this._last.getNext() )
		},
		_upgrade : function( first , last ){
			
			this._first = first;
			this._last  = last;
			
		},
		_add : function( newItem ){
			var $item = newItem.get$();
			this._show($item);
		},
		_remove : function( item ){
			item.get$().remove();
		},
		
		
		/**
		 * show item using different effect
		 */
		_show : function( $item ){
			
			switch( this._config.effect ){
				case "default":
					this._showDefault( $item );
					break;
				case "fade" :
					this._showFade( $item );
					break;
				case "slice" :
					this._showSlice( $item );
					break;
				default:
					throw new Exception("no such effect");
			}
			
		},
		_showDefault : function($item){
			this._$.prepend($item);
		},
		_showFade : function($item){
			
			$item.css("display" , "none");
			this._$.prepend($item);
			
			$item.animate({
				 opacity: "show"
			}, 1500);
		},
		_showSlice : function($item){
			
			$item.css("display" , "none");
			this._$.prepend($item);
			
			$item.show("fast");
		}
		
		
	});
	
	
	
	
	/**
	 * register into SmoothZone Namespace
	 */
	SmoothZone.Display = Display;
	
}
)();(
function(){
	
	
	/**
	 * Item for SmoothZone
	 */
	var Item = SmoothZone.Class({
		
		_next : null,
		_$	  : null,
		
		initialize : function( $ , next ){
			
			this._$    = $;
			this._next = next;
			
		},
		setNext : function( item ){
			this._next = item;
		},
		getNext : function( item ){
			return this._next;
		},
		get$ : function(){
			return this._$;
		}
		
		
	});
	
	
	
	
	/**
	 * register into SmoothZone Namespace
	 */
	SmoothZone.Item = Item;
	
}
)();


  /**
   * register smoothZone into Jquery Plugin
   */
  $.fn.smoothzone = function( config ) {
	  var rtn = new SmoothZone.Core( this , config );
	  return rtn;
  };