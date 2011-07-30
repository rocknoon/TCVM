/**
 * =======================================================
 * formbuilder 

 * jQuery: 1.5.1
 * author: rocky
 * author blog  : www.rocknoon.com
 * 
 **/


var FormBuilder = {};
	
	
(
function(){
	
	
	
	
	/**
	 * SmoothZone Manager
	 */
	var Core = rocknoon.Class({
		
		_config : null,
		_$   	: null,
		_tempHtml :  null,
		
		initialize : function( $ , config ){

			this._$ = $;
			this._initConfig(config);
			this._render();
			
		},
		
		 /**
		   * get current smoothZone version
		   */
		  getVersion : function(){
		  	return "1.0.0";
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
	  				  
	  				action  : "#",
	  				method  : "post",
	  				data    : null,
	  				default_type : "text"
	  			
	  		};
	  		 
	  		rocknoon.extend( this._config , config , true );
	  	  }, 
	  	  
	  	  
	  	  _render : function(){
	  	  	  
	  		  this._configForm();
	  		  var  html = this._renderHtml();
	  		  this._append(html);
	  		 
	  	  },
	  	  
	  	  _configForm : function(){
	  		
	  		  this._$.attr( "action" , this._config.action );
	  		  this._$.attr( "method" , this._config.method );
	  		  
	  	  },
	  	  
	  	  _append : function(){  
	  		  this._$.prepend($(this._tempHtml));
	  	  }, 
	  	  
	  	  _renderHtml : function(){
	  		  
	  		  if( !this._config.data ){
	  			  return '';
	  		  }
	  		  
	  		  this._tempHtml = '';
	  		  $.each( this._config.data ,  rocknoon.callback( this , "_renderItem" ) );
	  		  return this._tempHtml;
	  	  },
	  	  
	  	  _renderItem : function( key , item ){
	  		  
	  		  var type = item.type;
	  		  
	  		  //validate item
	  		  if( !item.type ){
	  			  return;
	  		  }
	  		  
	  		  if( !type ){
	  			  type = this._config.default_type;
	  		  }
	  		  
	  		  this._renderItemByType( item.type , key , item.label, item.value );
	  		    		  
	  	  },
	  	  
	  	  _renderItemByType : function( type , key , label , value ){
	  		  
	  		  if( value == undefined ){
	  			  value = '';
	  		  }
	  		  
	  		  switch( type ){
	  		  	
		  		  case 'text':
		  			  this._renderItemByText( key , label , value );
		  			  break;
		  		  case 'textarea':
		  			  this._renderItemByTextArea( key , label , value );
		  			  break;
		  		  default:
		  			  throw new Exception("the type " + type + " is not supported");
	  				 
	  		  }
	  		  
	  	  },
	  	  
	  	  _renderItemByText : function( key , label , value ){
	  		  
	  		  var html = '<div><label>'+label+'</label><input type="text" value="'+value+'" name="'+key+'" id="'+key+'"></input></div>';
	  		  this._tempHtml += html;
	  		  
	  	  },
	  	  _renderItemByTextArea : function( key , label , value ){
	  		  
	  		  var html = '<div><label>'+label+'</label><textarea name="'+key+'">'+value+'</textarea></div>';
	  		  this._tempHtml += html;
	  		  
	  	  }
	  	  
	  	  
	  	
		
		
		
	});
	
	
	
	
	/**
	 * register into SmoothZone Namespace
	 */
	FormBuilder.Core = Core;
	
}
)();


  /**
   * register smoothZone into Jquery Plugin
   */
  $.fn.formbuilder = function( config ) {
	  var rtn = new FormBuilder.Core( this , config );
	  return rtn;
  };