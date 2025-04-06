<?php

/*  MY_Image_lib.php (./application/libraries/MY_Image_lib)
====================================================================================================
	Author:	hrvojegolcic@gmail.com
	Date:	26.03.2013
----------------------------------------------------------------------------------------------------
	[26.03.2013] - v1.1. Released, upgraded from previous projects
	[13.05.2013] - BUG - Images rotated by Picasa or not rotated images receives wrong image parametars...
	[17.05.2013] - BUG - If you set master_dim=width and leave height=null, image will lose ratio, put height=1
====================================================================================================
ideja stavi sve ove tri funkcije u jednu i onda da jedan argument bude samo tipa keep proportions


*/


class MY_Image_lib extends CI_Image_lib
{
	public function __construct() { parent::__construct(); }
	
	function regular_resize($source, $width, $height, $quality)
	{
		//...ipak ti samo orginalnu sliku sredi, do not make a copy
        //$info = pathinfo($source); 
		//$newImage = '';
		
		// samo odabir koji ce biti extension marker

		//if($extMarker === NULL) $source = $info['dirname'].'/'.$info['filename'].'_'.$width.'x'.$height.'.'.$info['extension'];
		//else $newImage = $info['dirname'].'/'.$info['filename'].$extMarker.'.'.$info['extension'];


		// IF IMAGE IS SMALLER THEN REQUIRED, WE WILL NOT RESIZE HERE...
		list($thisWidth, $thisHeight) = getimagesize($source);
		if($thisWidth <= $width && $thisHeight <= $height) return $source;

		$config['image_library'] = 'gd2';
		$config['source_image'] = $source;
		//$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['quality'] = $quality;
        //$config['new_image'] = $newImage;
		//$config['master_dim'] = 'height'; // auto, width, height
		//$config['thumb_marker'] = '_THUMB';
		$config['width'] = $width; 
		$config['height'] = $height;
		
		$this->clear();
		$this->initialize($config);
		$this->resize() or die($this->display_errors()); 
		
        return $source;
        //return $newFile;
	}
	public function resizeby_width_copy($oldFile, $width, $height=1, $quality, $extMarker=NULL)
	{
		// height nije bitan za ovo
		$info = pathinfo($oldFile); 
		$newFile = $info['dirname'].'/'.$info['filename'].$extMarker.'.'.$info['extension'];
		
        //if image already exists, use it
        if(file_exists($newFile)) return $newFile;

		$config['image_library'] = 'gd2';
		$config['source_image'] = $oldFile;
        $config['new_image'] = $newFile;
		$config['maintain_ratio'] = TRUE;
		$config['quality'] = $quality;
		$config['master_dim'] = 'width'; // auto, width, height
		$config['width'] = $width; 
		$config['height'] =  1; // inace ne radi kad je null...neki bug?
		
		$this->clear();
		$this->initialize($config);
		$this->resize() or die($this->display_errors()); 
		
        return $newFile;
	}
	public function regular_resize_copy($oldFile, $width, $height, $quality, $extMarker=NULL)
	{
		$info = pathinfo($oldFile); 
		$newFile = $info['dirname'].'/'.$info['filename'].$extMarker.'.'.$info['extension'];
		
        //if image already exists, use it
        if(file_exists($newFile)) return $newFile;

		$config['image_library'] = 'gd2';
		$config['source_image'] = $oldFile;
        $config['new_image'] = $newFile;
		$config['maintain_ratio'] = TRUE;
		$config['quality'] = $quality;
		$config['width'] = $width; 
		$config['height'] =  $height; // inace ne radi kad je null...neki bug?
		
		$this->clear();
		$this->initialize($config);
		$this->resize() or die($this->display_errors()); 
		
        return $newFile;
	}
	
	function resize_crop_copy($oldFile, $width, $height, $quality, $extMarker=NULL) // iskljucivo na te dimenzije
	{
		// image_lib must be loaded!
		// $extMarker - string ili null za AxB ili false za original filename
		// nazalost ovo reze po sredini samo po y osi, po x osi je uvijek u ishodistu? nisam siguran
		// jos uvijek postoji onaj moj library od vanjamijac.com, samo matematiku treba srediti...
		// http://codeigniter.com/forums/viewthread/178095/
		      
        $info = pathinfo($oldFile); 
		$newFile = $info['dirname'].'/'.$info['filename'].$extMarker.'.'.$info['extension'];
		
        //if image already exists, use it
        if(file_exists($newFile)) return $newFile;
        list($thisWidth, $thisHeight) = getimagesize($info['dirname'].'/'.$info['basename']);             

        /*
        //math for resize/crop without loss, epsilon=0,00001;
        // this is still usefull function to know resolutions...
        $master_dim = ($thisWidth-$width < $thisHeight-$height?'width':'height');
        $perc = max( (10000*$width)/$thisWidth , (10000*$height)/$thisHeight  );
        $perc = round($perc, 0);
        $w_d = round(($perc*$thisWidth)/10000, 0);        
        $h_d = round(($perc*$thisHeight)/10000, 0);
        // end math stuff
        */

        // this is a trick, to set opposite dim then 'auto' would set :P
		$w_ratio = $width/$thisWidth;
		$h_ratio = $height/$thisHeight;
		$master_dim = 'width';
		if ($w_ratio < $h_ratio) $master_dim = 'height';

        // ovime izbjegavam grešku...
        $resizedImage = $info['dirname'].'/temp_'.$info['filename'].$extMarker.'.'.$info['extension'];

        /*
         *    Resize image
         */
        $config['image_library'] = 'gd2';
        $config['source_image'] = $oldFile;
        $config['new_image'] = $resizedImage;
        $config['maintain_ratio'] = TRUE;
        $config['master_dim'] = $master_dim;
		$config['quality'] = $quality;
        //$config['width'] = $w_d + 1;
        //$config['height'] = $h_d + 1;
        $config['width'] = $width;
        $config['height'] = $height;
        //var_dump($config['source_image'], $config['new_image']);

        $this->clear();
        $this->initialize($config);
        $this->resize() or die($this->display_errors());
        

        // AFTER RESIZE
        //list($thisWidth, $thisHeight) = getimagesize($newFile);    
        list($new_width, $new_height) = getimagesize($resizedImage);    


        // nikako ne mogu shvatiti zašto ovdje pukne program kad se izvodi crop nakon resize-a i to samo sa slikma sa diska, ne i sa onima koje se upload-aju...

        // crop image in the middle
		$x_axis = 0;
		$y_axis = 0;  
		if ($new_width < $new_height) $y_axis = round(($new_height - $height)/2); // portrait
		else $x_axis = round(($new_width - $width)/2); // landscape

        /*
         *    Crop image  in weight, height
         */  
        $config = array(); // clear previous data     
        $config['image_library'] = 'gd2';
        $config['source_image'] = $resizedImage; // if no new_image, it'll process original file.
        $config['new_image'] = $newFile; // this should commented
		$config['quality'] = '100%';
        $config['maintain_ratio'] = FALSE;
        $config['width'] = $width;
        $config['height'] = $height;
        $config['y_axis'] = $y_axis;
        $config['x_axis'] = $x_axis;
        //var_dump($config['source_image'], $config['new_image']);
        //echo ' is_writable: '.is_writable($newFile);
        //echo ' is_writable: '.is_writable('img/mobile/');
        //echo ' dir: '. getcwd();


        $this->clear();
        $this->initialize($config);
        //$this->crop() or die($this->display_errors()); 
        $this->crop() or show_error($this->display_errors(), 400); 


        unlink($resizedImage);		
        return $newFile;
    } 

	function copy_resize_biggerThen($oldFile, $width, $height, $quality, $extMarker=NULL) // iskljucivo na te dimenzije
	{
		/* regular resize, ratio kept */
		$info = pathinfo($oldFile); 
		$newFile = $info['dirname'].'/'.$info['filename'].$extMarker.'.'.$info['extension'];
		
        //if image already exists, use it
        if(file_exists($newFile)) return $newFile;

        //math stuff for resize/crop to bigger then wanted without loss, epsilon=0,00001;
        list($thisWidth, $thisHeight) = getimagesize($info['dirname'].'/'.$info['basename']);             
        $master_dim = ($thisWidth-$width < $thisHeight-$height?'width':'height');
        $perc = max( (10000*$width)/$thisWidth , (10000*$height)/$thisHeight  );
        $perc = round($perc, 0);
        $w_d = round(($perc*$thisWidth)/10000, 0);        
        $h_d = round(($perc*$thisHeight)/10000, 0);
        // CHECKOUT NEW CROP_RESIZE FUNCTION!


        $config['image_library'] = 'gd2';
        $config['source_image'] = $oldFile;
        $config['new_image'] = $newFile;
        $config['maintain_ratio'] = TRUE;
		$config['quality'] = $quality;
		/* original
        $config['master_dim'] = $master_dim;
        $config['width'] = $w_d + 1;
        $config['height'] = $h_d + 1;
        */
        $config['master_dim'] = 'width'; // because sometimes height does not matter...it is variable
        $config['width'] = $w_d >= $width? $w_d : $w_d+1;
        $config['height'] = $h_d >= $height? $h_d : $h_d+1;

        $this->clear();
        $this->initialize($config);
        $this->resize() or die($this->display_errors());
        
        return $newFile;
    }  

}


/*

if (!defined('BASEPATH')) exit('No direct script access allowed');


// ------------------------------------------------------------------------



class MY_Image_lib extends CI_Image_lib {
	
	protected $_width;
	protected $_height;
	protected $_thumb_marker = '';
	protected $_create_thumb = FALSE;
	protected $_save_props = array('width', 'height', 'thumb_marker', 'create_thumb');
	
	public function __construct()
	{
        parent::__construct();
    }

	// --------------------------------------------------------------------


	public function initialize($props = array())
	{
		foreach($this->_save_props as $sp)
		{
			$p = '_'.$sp;
			if (isset($props[$sp])) $this->$p = $props[$sp];
		}
		parent::initialize($props);
	}
	

	// --------------------------------------------------------------------

	public function resize_and_crop()
	{
		// need these set
		$this->maintain_ratio = TRUE;
		
		foreach($this->_save_props as $sp)
		{
			$p = '_'.$sp;
			$this->$sp = $this->$p;
		}

		// get the current dimensions and see if it is a portrait or landscape image
		$props = $this->get_image_properties($this->source_folder.$this->source_image, TRUE);
		$orig_width = $props['width'];
		$orig_height = $props['height'];
		
		// if ($orig_width < $orig_height )
		// {
		// 	$this->master_dim = 'width';
		// }
		// 
		$w_ratio = $this->width/$orig_width;
		$h_ratio = $this->height/$orig_height;
		if ($w_ratio > $h_ratio)
		{
			$this->master_dim = 'width';
		}
		else
		{
			$this->master_dim = 'height';
		}
		
		$this->image_reproportion();

		// resize image
		if (!$this->resize())
		{
			// TODO... put in lang file
			$this->set_error('Could not resize');
		}
		
		if (!empty($this->dest_image))
		{
			// now crop if it is too wide
			$thumb_src = $this->explode_name($this->dest_image);
			$thumb_source = $thumb_src['name'].$this->thumb_marker.$thumb_src['ext'];
			$new_source = $this->dest_folder.$thumb_source;
			$props = $this->get_image_properties($new_source, TRUE);
			$new_width = $props['width'];
			$new_height = $props['height'];
			
			$config = array();
			$config['width'] = $this->_width;
			$config['height'] = $this->_height;
			$config['source_image'] = $new_source;
			$config['maintain_ratio'] = FALSE;
			$config['create_thumb'] = FALSE;


			// portrait
			if ($new_width < $new_height)
			{
				$this->x_axis = 0;
				$this->y_axis = round(($new_height - $this->_height)/2);
			}

			// landscape
			else
			{
				$this->x_axis = round(($new_width - $this->_width)/2);
				$this->y_axis = 0;
			}
			$this->dest_folder = '';
			$this->initialize($config);
			if (!$this->crop())
			{
				// TODO... put in lang file
				$this->set_error('Could not crop');
			}
		}
		else
		{
			// TODO... put in lang file
			$this->set_error('Could not crop');
		}

		return (empty($this->error_msg));
		
	}
	
	// --------------------------------------------------------------------

	function convert($type = 'jpg', $delete_orig = FALSE)
	{
		$this->full_dst_path = $this->dest_folder . end($this->explode_name($this->dest_image)) . '.' . $type;

		if (!($src_img = $this->image_create_gd()))
		{
		    return FALSE;
		}

		if ($this->image_library == 'gd2' AND function_exists('imagecreatetruecolor'))
		{
		    $create = 'imagecreatetruecolor';
		    $copy = 'imagecopyresampled';
		}
		else
		{
		    $create = 'imagecreate';
		    $copy = 'imagecopyresized';
		}

		$dst_img = $create($this->width, $this->height);
		$copy($dst_img, $src_img, 0, 0, 0, 0, $this->width, $this->height, $this->width, $this->height);

		$types = array('gif' => 1, 'jpg' => 2, 'jpeg' => 2, 'png' => 3);

		$this->image_type = $types[$type];

		if ($delete_orig)
		{
		    unlink($this->full_src_path);        
		}

		if ($this->dynamic_output == TRUE)
		{
		    $this->image_display_gd($dst_img);
		}
		else
		{
		    if (!$this->image_save_gd($dst_img))
		    {
		        return FALSE;
		    }
		}

		imagedestroy($dst_img);
		imagedestroy($src_img);

		@chmod($this->full_dst_path, DIR_WRITE_MODE);

		return TRUE;
	}
}



*/



/* END OF FILE */