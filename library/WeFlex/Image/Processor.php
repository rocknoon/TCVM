<?php
/*---------------------------------------------------------------
 功能: 图片操作类
 作者: Rocky
 -----------------------------------------------------------------*/

class WeFlex_Image_Processor
{

    //==========================================
    // 函数: switchpic($sourFile,$width=128,$height=128)
    // 功能: 转换图片格式,输出指定大小.
    // 参数: $sourFile 图片源文件
    // 参数: $newName 生成的文件URL
    // 参数: $width 生成缩略图的宽度
    // 参数: $height 生成缩略图的高度
    // $backcolor = array( 111,111,111 ) 三原色 
    
    // 返回: 0 失败 成功时返回生成的图片路径
    //==========================================
    public static function switchpic($sourFile ,  $width=128, $height=128 , $transparent = 0 , $backcolor = null , $focus = null )
    {

    	/**
    	 * gener new file name
    	 * Enter description here ...
    	 * @var unknown_type
    	 */
    	if( $transparent ){
    		$newName = substr($sourFile,0,strrpos($sourFile,'.')).'_'.$width . 'x' . $height . ".png";
    	}else{
    		$newName = substr($sourFile,0,strrpos($sourFile,'.')).'_'.$width . 'x' . $height . substr($sourFile,strrpos($sourFile,'.'));
    	}
    	
    	
    	$dst_width = $width;
    	$dst_height = $height;
        $imageInfo = self::getInfo($sourFile);
        
        switch ($imageInfo["type"])
        {
            case 1: //gif
                $img = imagecreatefromgif($sourFile);
                break;
            case 2: //jpg
                $img = imagecreatefromjpeg($sourFile);
                break;
            case 3: //png
                $img = imagecreatefrompng($sourFile);
                break;
            default:
                return 0;
                break;
        }
        
        if (!$img)
        	return 0;

        //$width  = ($width > $imageInfo["width"]) ? $imageInfo["width"] : $width;
        //$height = ($height > $imageInfo["height"]) ? $imageInfo["height"] : $height;
        $srcW = $imageInfo["width"];
        $srcH = $imageInfo["height"];
        /*
        if ($srcW * $width > $srcH * $height)
        $height = round($srcH * $width / $srcW);
        else
        $width = round($srcW * $height / $srcH);
        */
    	if( $focus == 'width' ){
        	$height 	= round($srcH * $width / $srcW);
	        $dst_height = $height;
        	
        }elseif( $focus == 'height' ){
        	$width 	   = round($srcW * $height / $srcH);
	        $dst_width = $width;
        	
        }else{
        	if ($srcW / $width > $srcH / $height)
	        $height = round($srcH * $width / $srcW);
	        else
	        $width = round($srcW * $height / $srcH);
        }
       

        if (function_exists("imagecreatetruecolor")) //GD2.0.1
        {
            $new = imagecreatetruecolor($dst_width, $dst_height);
            $offset_x = ($dst_width-$width) / 2;
            $offset_y = ($dst_height-$height) / 2;
            
            $backcolor = self::_getbackcolor( $new , $backcolor);
            imagefill($new, 0, 0, $backcolor);
            
        	if( $transparent ){
				//set back color transparent
				imagecolortransparent( $new , $backcolor );
			}
            
            ImageCopyResampled($new, $img, $offset_x, $offset_y, 0, 0, $width, $height, $imageInfo["width"], $imageInfo["height"]);
        }
        else
        {
        	throw new Exception( "gd library doesn't have imagecreatetruecolor function" );
//            $new = imagecreate($dst_width, $dst_height);
//            $offset_x = ($dst_width-$width) / 2;
//            $offset_y = ($dst_height-$height) / 2;
//            ImageCopyResized($new, $img, 0, 0, 0, 0, $width, $height, $imageInfo["width"], $imageInfo["height"]);
        }
        
        //*/
        if (file_exists($newName)) unlink($newName);
        $maketype = strtolower(substr(strrchr($newName,"."),1));
        switch($maketype)
        {
    
            case "jpg": ImageJPEG($new, $newName , 100);break;
            case "gif" : ImageGIF($new, $newName);break;
            case "png" : ImagePNG($new, $newName , 9);break;
            case "wbmp" : ImageWBMP($new, $newName);break;
            default: ImageJPEG($new, $newName);
        }
        ImageDestroy($new);
        ImageDestroy($img);
        chmod($newName,0777);
        return $newName;



    }
    

 

    public static function getInfo($file)
    {
        $data = getimagesize($file);
        $imageInfo["width"] = $data[0];
        $imageInfo["height"]= $data[1];
        $imageInfo["type"] = $data[2];
        $imageInfo["name"] = basename($file);
        //$imageInfo["size"]  = filesize($file);
        return $imageInfo;
    }
    
    private static function _getbackcolor( $new , $backcolor = null ){
    	
    	
    	switch( $backcolor ){

    		case "white":
    			$white = imagecolorallocate($new, 255, 255, 255);
    			return $white;
    			break;
    		case "black":
    			$black = imagecolorallocate($new, 0, 0, 0);
    			return $black;
    			break;
    		default:
    			$white = imagecolorallocate($new, 255, 255, 255);
    			return $white;
    			break;
    		
    		
    	}
    	  
    	
    }
}
?>
