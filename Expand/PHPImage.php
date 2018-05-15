<?php

/**
 * Wrapper for PHP's GD Library for easy image manipulation to resize, crop
 * and draw images on top of each other preserving transparency, writing text
 * with stroke and transparency and drawing shapes.
 *
 * @version 0.5
 * @author Blake Kus <blakekus@gmail.com>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2015 Blake Kus
 *
 * CHANGELOG:
 * version 0.5 2015-01-02
 * ADD: textBox auto scale font to width and height requested by @rufinus https://github.com/kus/php-image/issues/3
 *
 * version 0.4 2014-02-27
 * ADD: Image support for image cloning (Thanks @chainat)
 * ADD: Support to use GD commands to manipulate image and then continue using library
 * UPDATE: Private to Protected so library is extendable
 * ADD: Rotate
 *
 * version 0.3 2014-02-12
 * ADD: Examples
 * ADD: Initialise image on class instantiation
 * ADD: Image resize with optional upscaling
 * ADD: Image batch resize
 * ADD: Image crop
 * ADD: Option to save as gif/jpg/png
 * ADD: Snapshot images
 * FIX: Error in `textBox` reported by elbaku https://github.com/kus/php-image/issues/1
 *
 * version 0.2 2013-05-23
 * Add support for remote images
 * Add error handling when reading/writing files
 * Add ability to draw text box and auto fit text and align text
 *
 * version 0.1 2013-04-15
 * Initial release
 */

namespace Expand;

class PHPImage {
	/**
	 * Canvas resource
	 *
	 * @var resource
	 */
	protected $img;

	/**
	 * Canvas resource
	 *
	 * @var resource
	 */
	protected $img_copy;

	/**
	 * PNG Compression level: from 0 (no compression) to 9.
	 * JPEG Compression level: from 0 to 100 (no compression).
	 *
	 * @var integer
	 */
	protected $quality = 90;

	/**
	 * Global font file
	 *
	 * @var String
	 */
	protected $fontFile;

	/**
	 * Global font size
	 *
	 * @var integer
	 */
	protected $fontSize = 12;

	/**
	 * Global text vertical alignment
	 *
	 * @var String
	 */
	protected $alignVertical = 'top';

	/**
	 * Global text horizontal alignment
	 *
	 * @var String
	 */
	protected $alignHorizontal = 'left';

	/**
	 * Global font colour
	 *
	 * @var array
	 */
	protected $textColor = array(255, 255, 255);

	/**
	 * Global text opacity
	 *
	 * @var float
	 */
	protected $textOpacity = 1;

	/**
	 * Global text angle
	 *
	 * @var integer
	 */
	protected $textAngle = 0;

	/**
	 * Global stroke width
	 *
	 * @var integer
	 */
	protected $strokeWidth = 0;

	/**
	 * Global stroke colour
	 *
	 * @var array
	 */
	protected $strokeColor = array(0, 0, 0);

	/**
	 * Canvas width
	 *
	 * @var integer
	 */
	protected $width;

	/**
	 * Canvas height
	 *
	 * @var integer
	 */
	protected $height;

	/**
	 * Image type
	 *
	 * @var integer
	 */
	protected $type;

	/**
	 * Default folder mode to be used if folder structure needs to be created
	 *
	 * @var String
	 */
	protected $folderMode = 0755;

	/**
	 * Initialise the image with a file path, or dimensions, or pass no dimensions and
	 * use setDimensionsFromImage to set dimensions from another image.
	 *
	 * @param string|integer $mixed (optional) file or width
	 * @param integer $height (optional)
	 * @return $this
	 */
	public function __construct($mixed=null, $height=null){
		//Check if GD extension is loaded
		if (!extension_loaded('gd') && !extension_loaded('gd2')) {
			$this->handleError('GD is not loaded');
			return false;
		}
		if($mixed !== null && $height !== null){
			$this->initialiseCanvas($mixed, $height);
		}else if($mixed !== null && is_string($mixed)){
			$image = $this->setDimensionsFromImage($mixed);
			$image->draw($mixed);
			return $image;
		}
	}

	/**
	 * Intialise the canvas
	 *
	 * @param integer $width
	 * @param integer $height
	 * @return $this
	 */
	protected function initialiseCanvas($width, $height, $resource='img'){
		$this->width = $width;
		$this->height = $height;
		unset($this->$resource);
		$this->$resource = imagecreatetruecolor($this->width, $this->height);
		// Set the flag to save full alpha channel information
		imagesavealpha($this->$resource, true);
		// Turn off transparency blending (temporarily)
		imagealphablending($this->$resource, false);
		// Completely fill the background with transparent color
		imagefilledrectangle($this->$resource, 0, 0, $this->width, $this->height, imagecolorallocatealpha($this->$resource, 0, 0, 0, 127));
		// Restore transparency blending
		imagealphablending($this->$resource, true);
		return $this;
	}

	/**
	 * After we update the image run this function
	 */
	protected function afterUpdate(){
		$this->shadowCopy();
	}

	/**
	 * Store a copy of the image to be used for clone
	 */
	protected function shadowCopy(){
		$this->initialiseCanvas($this->width, $this->height, 'img_copy');
		imagecopy($this->img_copy, $this->img, 0, 0, 0, 0, $this->width, $this->height);
	}

	/**
	 * Enable cloning of images in their current state
	 *
	 * $one = clone $image;
	 */
	public function __clone(){
		$this->initialiseCanvas($this->width, $this->height);
		imagecopy($this->img, $this->img_copy, 0, 0, 0, 0, $this->width, $this->height);
	}


	/**
	 * Get image height
	 *
	 * @return int
	 */
	public function getHeight(){
		return $this->height;
	}

	/**
	 * Get image width
	 *
	 * @return int
	 */
	public function getWidth(){
		return $this->width;
	}
	

	/**
	 * Get image resource (used when using a raw gd command)
	 *
	 * @return resource
	 */
	public function getResource(){
		return $this->img;
	}

	/**
	 * Set image resource (after using a raw gd command)
	 *
	 * @param $resource
	 * @return $this
	 */
	public function setResource($resource){
		$this->img = $resource;
		return $this;
	}

	/**
	 * Set image dimensions from an image source
	 *
	 * @param String $file
	 * @return $this
	 */
	public function setDimensionsFromImage($file){
		if($info = $this->getImageInfo($file, false)){
			$this->initialiseCanvas($info->width, $info->height);
			return $this;
		} else {
			$this->handleError($file . ' is not readable!');
		}
	}

	/**
	 * Check if an image (remote or local) is a valid image and return type, width, height and image resource
	 *
	 * @param string $file
	 * @param boolean $returnResource
	 * @return \stdClass
	 */
	protected function getImageInfo($file, $returnResource=true){
		if($file instanceof PHPIMage) {
			$img = $file->img;
			$type = $file->type;
			$width = $file->width;
			$height = $file->height;
		} elseif (preg_match('#^https?://#i', $file)) {
			$headers = get_headers($file, 1);
			if (is_array($headers['Content-Type'])) {
				// Some servers return an array of content types, Facebook does this
				$contenttype = $headers['Content-Type'][0];
			} else {
				$contenttype = $headers['Content-Type'];
			}
			if (preg_match('#^image/(jpe?g|png|gif)$#i', $contenttype)) {
				switch(true){
					case stripos($contenttype, 'jpeg') !== false:
					case stripos($contenttype, 'jpg') !== false:
						$img = imagecreatefromjpeg($file);
						$type = IMAGETYPE_JPEG;
						break;
					case stripos($contenttype, 'png') !== false:
						$img = imagecreatefrompng($file);
						$type = IMAGETYPE_PNG;
						break;
					case stripos($contenttype, 'gif') !== false:
						$img = imagecreatefromgif($file);
						$type = IMAGETYPE_GIF;
						break;
					default:
						return false;
						break;
				}
				$width = imagesx($img);
				$height = imagesy($img);
				if (!$returnResource) {
					imagedestroy($img);
				}
			} else {
				return false;
			}
		} elseif (is_readable($file)) {
			list($width, $height, $type) = getimagesize($file);
			switch($type){
				case IMAGETYPE_GIF:
					if ($returnResource) {
						$img = imagecreatefromgif($file);
					}
					break;
				case IMAGETYPE_JPEG:
					if ($returnResource) {
						$img = imagecreatefromjpeg($file);
					}
					break;
				case IMAGETYPE_PNG:
					if ($returnResource) {
						$img = imagecreatefrompng($file);
					}
					break;
				default:
					return false;
					break;
			}
		} else {
			return false;
		}
		$info = new \stdClass();
		$info->type = $type;
		if($this->type === null){
			// Assuming the first image you use is the output image type you want
			$this->type = $type;
		}
		$info->width = $width;
		$info->height = $height;
		if ($returnResource) {
			$info->resource = $img;
		}
		return $info;
	}

	/**
	 * Handle errors
	 *
	 * @param String $error
	 *
	 * @throws Exception
	 */
	protected function handleError($error){
		throw new \Exception($error);
	}

	/**
	 * Rotate image
	 *
	 * @param $angle
	 * @param int $bgd_color
	 * @param int $ignore_transparent
	 * @return $this
	 */
	public function rotate($angle, $bgd_color=0, $ignore_transparent=0){
		$this->img = imagerotate($this->img, $angle, 0);
		$this->afterUpdate();
		return $this;
	}

	/**
	 * Crop an image
	 *
	 * @param integer $x
	 * @param integer $y
	 * @param integer $width
	 * @param integer $height
	 * @return $this
	 */
	public function crop($x, $y, $width, $height){
		$tmp = $this->img;
		$this->initialiseCanvas($width, $height);
		imagecopyresampled($this->img, $tmp, 0, 0, $x, $y, $width, $height, $width, $height);
		imagedestroy($tmp);
		$this->afterUpdate();
		return $this;
	}

	/**
	 * Batch resize and save
	 *
	 * Usage: $image->batchResize('/path/to/img/test_%dx%d.jpg', array(array(100, 100, 'C', true),array(50, 50)));
	 *
	 * Will result in two images being saved (test_100x100.jpg and test_50x50.jpg) with 100x100 being cropped to the center.
	 *
	 * @param String $path
	 * @param array $dimensions Array of `resize` arguments to run and save ie: array(100, 100, true, true)
	 * @return $this
	 */
	public function batchResize($path, $dimensions=array()){
		if(is_array($dimensions) && count($dimensions) > 0){
			$width = $this->width;
			$height = $this->height;
			$copy = imagecreatetruecolor($width, $height);
			imagecopy($copy, $this->img, 0, 0, 0, 0, $width, $height);
			foreach($dimensions as $args){
				$this->initialiseCanvas($width, $height);
				imagecopy($this->img, $copy, 0, 0, 0, 0, $width, $height);
				call_user_func_array(array($this, 'resize'), $args);
				$this->save(sprintf($path, $args[0], $args[1]));
			}
			$this->initialiseCanvas($width, $height);
			imagecopy($this->img, $copy, 0, 0, 0, 0, $width, $height);
			imagedestroy($copy);
		}
		return $this;
	}

	/**
	 * Resize image to desired dimensions.
	 *
	 * Optionally crop the image using the quadrant.
	 *
	 * This function attempts to get the image to as close to the provided dimensions as possible, and then crops the
	 * remaining overflow using the quadrant to get the image to be the size specified.
	 *
	 * The quadrants available are Top, Bottom, Center (default if crop = true), Left, and Right:
	 *
	 * +---+---+---+
	 * |   | T |   |
	 * +---+---+---+
	 * | L | C | R |
	 * +---+---+---+
	 * |   | B |   |
	 * +---+---+---+
	 *
	 * @param integer $targetWidth
	 * @param integer $targetHeight
	 * @param boolean|String $crop T, B, C, L, R
	 * @param boolean $upscale
	 * @return $this
	 */
	public function resize($targetWidth, $targetHeight, $crop=false, $upscale=false){
		$width = $this->width;
		$height = $this->height;
		$canvasWidth = $targetWidth;
		$canvasHeight = $targetHeight;
		$r = $width / $height;
		$x = 0;
		$y = 0;
		if ($crop !== false) {
			if($crop === true){
				$crop = 'C';
			}
			if ($targetWidth/$targetHeight > $r) {
				// crop top/bottom
				$newheight = intval($targetWidth/$r);
				$newwidth = $targetWidth;
				switch($crop){
					case 'T':
						$y = 0;
						break;
					case 'B':
						$y = intval(($newheight - $targetHeight) * ($height / $newheight));
						break;
					case 'C':
					default:
						$y = intval((($newheight - $targetHeight) / 2) * ($height / $newheight));
						break;
				}
			} else {
				// crop sides
				$newwidth = intval($targetHeight*$r);
				$newheight = $targetHeight;
				switch($crop){
					case 'L':
						$x = 0;
						break;
					case 'R':
						$x = intval(($newwidth - $targetWidth) * ($width / $newwidth));
						break;
					case 'C':
					default:
						$x = intval((($newwidth - $targetWidth) / 2) * ($width / $newwidth));
						break;
				}
			}
			if($upscale === false){
				if($newwidth > $width){
					$x = 0;
					$newwidth = $width;
					$canvasWidth = $newwidth;
				}
				if($newheight > $height){
					$y = 0;
					$newheight = $height;
					$canvasHeight = $newheight;
				}
			}
		} else {
			if ($targetWidth/$targetHeight > $r) {
				$newwidth = intval($targetHeight*$r);
				$newheight = $targetHeight;
			} else {
				$newheight = intval($targetWidth/$r);
				$newwidth = $targetWidth;
			}
			if($upscale === false){
				if($newwidth > $width){
					$newwidth = $width;
				}
				if($newheight > $height){
					$newheight = $height;
				}
			}
			$canvasWidth = $newwidth;
			$canvasHeight = $newheight;
		}
		$tmp = $this->img;
		$this->initialiseCanvas($canvasWidth, $canvasHeight);
		imagecopyresampled($this->img, $tmp, 0, 0, $x, $y, $newwidth, $newheight, $width, $height);
		imagedestroy($tmp);
		$this->afterUpdate();
		return $this;
	}

	/**
	 * Shows the resulting image and cleans up.
	 */
	public function show(){
		switch($this->type){
			case IMAGETYPE_GIF:
				header('Content-type: image/gif');
				imagegif($this->img, null);
				break;
			case IMAGETYPE_PNG:
				header('Content-type: image/png');
				imagepng($this->img, null);
				break;
			default:
				header('Content-type: image/jpeg');
				imagejpeg($this->img, null, $this->quality);
				break;
		}
		$this->cleanup();
	}

	/**
	 * Cleanup
	 */
	public function cleanup(){
		imagedestroy($this->img);
	}

	/**
	 * Save the image
	 *
	 * @param String $path
	 * @param boolean $show
	 * @param boolean $destroy
	 * @return $this
	 */
	public function save($path, $show=false, $destroy=true){
		if (!is_writable(dirname($path))) {
			if (!mkdir(dirname($path), $this->folderMode, true)) {
				$this->handleError(dirname($path) . ' is not writable and failed to create directory structure!');
			}
		}
		if (is_writable(dirname($path))) {
			switch($this->type){
				case IMAGETYPE_GIF:
					imagegif($this->img, $path);
					break;
				case IMAGETYPE_PNG:
					imagepng($this->img, $path);
					break;
				default:
					imagejpeg($this->img, $path, $this->quality);
					break;
			}
		} else {
			$this->handleError(dirname($path) . ' is not writable!');
		}
		if($show){
			$this->show();
			return;
		}
		if($destroy){
			$this->cleanup();
		}else{
			return $this;
		}
	}

	/**
	 * Save the image and return object to continue operations
	 *
	 * @param string $path
	 * @return $this
	 */
	public function snapshot($path){
		return $this->save($path, false, false);
	}

	/**
	 * Save the image and show it
	 *
	 * @param string $path
	 */
	public function showAndSave($path){
		$this->save($path, true);
	}

	/**
	 * Draw a line
	 *
	 * @param integer $x1
	 * @param integer $y1
	 * @param integer $x2
	 * @param integer $y2
	 * @param array $colour
	 * @param float $opacity
	 * @param boolean $dashed
	 * @return $this
	 */
	public function line($x1=0, $y1=0, $x2=100, $y2=100, $colour=array(0, 0, 0), $opacity=1.0, $dashed=false){
		if($dashed === true){
			imagedashedline($this->img, $x1, $y1, $x2, $y2, imagecolorallocatealpha($this->img, $colour[0], $colour[1], $colour[2], (1 - $opacity) * 127));
		}else{
			imageline($this->img, $x1, $y1, $x2, $y2, imagecolorallocatealpha($this->img, $colour[0], $colour[1], $colour[2], (1 - $opacity) * 127));
		}
		$this->afterUpdate();
		return $this;
	}

	/**
	 * Draw a rectangle
	 *
	 * @param integer $x
	 * @param integer $y
	 * @param integer $width
	 * @param integer $height
	 * @param array $colour
	 * @param float $opacity
	 * @param boolean $outline
	 * @see http://www.php.net/manual/en/function.imagefilledrectangle.php
	 * @return $this
	 */
	public function rectangle($x=0, $y=0, $width=100, $height=50, $colour=array(0, 0, 0), $opacity=1.0, $outline=false){
		if($outline === true){
			imagerectangle($this->img, $x, $y, $x + $width, $y + $height, imagecolorallocatealpha($this->img, $colour[0], $colour[1], $colour[2], (1 - $opacity) * 127));
		}else{
			imagefilledrectangle($this->img, $x, $y, $x + $width, $y + $height, imagecolorallocatealpha($this->img, $colour[0], $colour[1], $colour[2], (1 - $opacity) * 127));
		}
		$this->afterUpdate();
		return $this;
	}

	/**
	 * Draw a square
	 *
	 * @param integer $x
	 * @param integer $y
	 * @param integer $width
	 * @param array $colour
	 * @param float $opacity
	 * @param boolean $outline
	 * @see http://www.php.net/manual/en/function.imagefilledrectangle.php
	 * @return $this
	 */
	public function square($x=0, $y=0, $width=100, $colour=array(0, 0, 0), $opacity=1.0, $outline=false){
		return $this->rectangle($x, $y, $width, $width, $colour, $opacity, $outline);
	}

	/**
	 * Draw an ellipse
	 *
	 * @param integer $x
	 * @param integer $y
	 * @param integer $width
	 * @param integer $height
	 * @param array $colour
	 * @param float $opacity
	 * @param boolean $outline
	 * @see http://www.php.net/manual/en/function.imagefilledellipse.php
	 * @return $this
	 */
	public function ellipse($x=0, $y=0, $width=100, $height=50, $colour=array(0, 0, 0), $opacity=1.0, $outline=false){
		if($outline === true){
			imageellipse($this->img, $x, $y, $width, $height, imagecolorallocatealpha($this->img, $colour[0], $colour[1], $colour[2], (1 - $opacity) * 127));
		}else{
			imagefilledellipse($this->img, $x, $y, $width, $height, imagecolorallocatealpha($this->img, $colour[0], $colour[1], $colour[2], (1 - $opacity) * 127));
		}
		$this->afterUpdate();
		return $this;
	}

	/**
	 * Draw a circle
	 *
	 * @param integer $x
	 * @param integer $y
	 * @param integer $width
	 * @param array $colour
	 * @param float $opacity
	 * @param boolean $outline
	 * @see http://www.php.net/manual/en/function.imagefilledellipse.php
	 * @return $this
	 */
	public function circle($x=0, $y=0, $width=100, $colour=array(0, 0, 0), $opacity=1.0, $outline=false){
		return $this->ellipse($x, $y, $width, $width, $colour, $opacity, $outline);
	}

	/**
	 * Draw a polygon
	 *
	 * @param array $points
	 * @param array $colour
	 * @param float $opacity
	 * @param boolean $outline
	 * @see http://www.php.net/manual/en/function.imagefilledpolygon.php
	 * @return $this
	 */
	public function polygon($points=array(), $colour=array(0, 0, 0), $opacity=1.0, $outline=false){
		if(count($points) > 0){
			if($outline === true){
				imagepolygon($this->img, $points, count($points) / 2, imagecolorallocatealpha($this->img, $colour[0], $colour[1], $colour[2], (1 - $opacity) * 127));
			}else{
				imagefilledpolygon($this->img, $points, count($points) / 2, imagecolorallocatealpha($this->img, $colour[0], $colour[1], $colour[2], (1 - $opacity) * 127));
			}
			$this->afterUpdate();
		}
		return $this;
	}

	/**
	 * Draw an arc
	 *
	 * @param integer $x
	 * @param integer $y
	 * @param integer $width
	 * @param integer $height
	 * @param integer $start
	 * @param integer $end
	 * @param array $colour
	 * @param float $opacity
	 * @param boolean $outline
	 * @see http://www.php.net/manual/en/function.imagefilledarc.php
	 * @return $this
	 */
	public function arc($x=0, $y=0, $width=100, $height=50, $start=0, $end=180, $colour=array(0, 0, 0), $opacity=1.0, $outline=false){
		if($outline === true){
			imagearc($this->img, $x, $y, $width, $height, $start, $end, imagecolorallocatealpha($this->img, $colour[0], $colour[1], $colour[2], (1 - $opacity) * 127));
		}else{
			imagefilledarc($this->img, $x, $y, $width, $height, $start, $end, imagecolorallocatealpha($this->img, $colour[0], $colour[1], $colour[2], (1 - $opacity) * 127), IMG_ARC_PIE);
		}
		$this->afterUpdate();
		return $this;
	}

	/**
	 * Draw an image from file
	 *
	 * Accepts x/y properties from CSS background-position (left, center, right, top, bottom, percentage and pixels)
	 *
	 * @param String $file
	 * @param String|integer $x
	 * @param String|integer $y
	 * @see http://www.php.net/manual/en/function.imagecopyresampled.php
	 * @see http://www.w3schools.com/cssref/pr_background-position.asp
	 * @return $this
	 */
	public function draw($file, $x='50%', $y='50%'){
		if($info = $this->getImageInfo($file)){
			$image = $info->resource;
			$width = $info->width;
			$height = $info->height;
			// Defaults if invalid values passed
			if(strpos($x, '%') === false && !is_numeric($x) && !in_array($x, array('left', 'center', 'right'))){
				$x = '50%';
			}
			if(strpos($y, '%') === false && !is_numeric($y) && !in_array($y, array('top', 'center', 'bottom'))){
				$y = '50%';
			}
			// If word passed, convert it to percentage
			switch($x){
				case 'left':
					$x = '0%';
					break;
				case 'center':
					$x = '50%';
					break;
				case 'right':
					$x = '100%';
					break;
			}
			switch($y){
				case 'top':
					$y = '0%';
					break;
				case 'center':
					$y = '50%';
					break;
				case 'bottom':
					$y = '100%';
					break;
			}
			// Work out offset
			if(strpos($x, '%') > -1){
				$x = str_replace('%', '', $x);
				$x = ceil(($this->width - $width) * ($x / 100));
			}
			if(strpos($y, '%') > -1){
				$y = str_replace('%', '', $y);
				$y = ceil(($this->height - $height) * ($y / 100));
			}
			// Draw image
			imagecopyresampled(
				$this->img,
				$image,
				$x,
				$y,
				0,
				0,
				$width,
				$height,
				$width,
				$height
			);
			imagedestroy($image);
			$this->afterUpdate();
			return $this;
		} else {
			$this->handleError($file . ' is not a valid image!');
		}
	}

	/**
	 * Draw text
	 *
	 * ### Options
	 *
	 * - integer $fontSize
	 * - integer $x
	 * - integer $y
	 * - integer $angle
	 * - integer $strokeWidth
	 * - float $opacity
	 * - array $fontColor
	 * - array $strokeColor
	 * - String $fontFile
	 *
	 * @param String $text
	 * @param array $options
	 * @see http://www.php.net/manual/en/function.imagettftext.php
	 * @return $this
	 */
	public function text($text, $options=array()){
		// Unset null values so they inherit defaults
		foreach($options as $k => $v){
			if($options[$k] === null){
				unset($options[$k]);
			}
		}
		$defaults = array(
			'fontSize' => $this->fontSize,
			'fontColor' => $this->textColor,
			'opacity' => $this->textOpacity,
			'x' => 0,
			'y' => 0,
			'width' => null,
			'height' => null,
			'alignHorizontal' => $this->alignHorizontal,
			'alignVertical' => $this->alignVertical,
			'angle' => $this->textAngle,
			'strokeWidth' => $this->strokeWidth,
			'strokeColor' => $this->strokeColor,
			'fontFile' => $this->fontFile,
			'autoFit' => true,
			'debug' => false
		);
		extract(array_merge($defaults, $options), EXTR_OVERWRITE);
		if($fontFile === null){
			$this->handleError('No font file set!');
		}
		if(is_int($width) && $autoFit){
			$fontSize = $this->fitToWidth($fontSize, $angle, $fontFile, $text, $width);
		}
		// Get Y offset as it 0 Y is the lower-left corner of the character
		$testbox = imagettfbbox($fontSize, $angle, $fontFile, $text);
		$offsety = abs($testbox[7]);
		$offsetx = 0;
		$actualWidth = abs($testbox[6] - $testbox[4]);
		$actualHeight = abs($testbox[1] - $testbox[7]);
		// If text box align text
		if(is_int($width) || is_int($height)){
			if(!is_int($width)){
				$width = $actualWidth;
			}
			if(!is_int($height)){
				$height = $actualHeight;
			}
			if($debug){
				$this->rectangle($x, $y, $width, $height, array(0, 255, 255), 0.5);
			}
			switch($alignHorizontal){
				case 'center':
					$offsetx += (($width - $actualWidth) / 2);
					break;
				case 'right':
					$offsetx += ($width - $actualWidth);
					break;
			}
			switch($alignVertical){
				case 'center':
					$offsety += (($height - $actualHeight) / 2);
					break;
				case 'bottom':
					$offsety += ($height - $actualHeight);
					break;
			}
		}
		// Draw stroke
		if($strokeWidth > 0){
			$strokeColor = imagecolorallocatealpha($this->img, $strokeColor[0], $strokeColor[1], $strokeColor[2], (1 - $opacity) * 127);
			for($sx = ($x-abs($strokeWidth)); $sx <= ($x+abs($strokeWidth)); $sx++){
				for($sy = ($y-abs($strokeWidth)); $sy <= ($y+abs($strokeWidth)); $sy++){
					imagettftext($this->img, $fontSize, $angle, $sx + $offsetx, $sy + $offsety, $strokeColor, $fontFile, $text);
				}
			}
		}
		// Draw text
		imagettftext($this->img, $fontSize, $angle, $x + $offsetx, $y + $offsety, imagecolorallocatealpha($this->img, $fontColor[0], $fontColor[1], $fontColor[2], (1 - $opacity) * 127), $fontFile, $text);
		$this->afterUpdate();
		return $this;
	}

	/**
	 * Reduce font size to fit to width
	 *
	 * @param integer $fontSize
	 * @param integer $angle
	 * @param String $fontFile
	 * @param String $text
	 * @param integer $width
	 * @return integer
	 */
	protected function fitToWidth($fontSize, $angle, $fontFile, $text, $width){
		while($fontSize > 0){
			$testbox = imagettfbbox($fontSize, $angle, $fontFile, $text);
			$actualWidth = abs($testbox[6] - $testbox[4]);
			if($actualWidth <= $width){
				return $fontSize;
			}else{
				$fontSize--;
			}
		}
		return $fontSize;
	}

	/**
	 * Reduce font size to fit to width and height
	 *
	 * @param integer $fontSize
	 * @param integer $angle
	 * @param String $fontFile
	 * @param String $text
	 * @param integer $width
	 * @param integer $height
	 * @return integer
	 */
	protected function fitToBounds($fontSize, $angle, $fontFile, $text, $width, $height){
		while($fontSize > 0){
			$wrapped = $this->wrap($text, $width, $fontSize, $angle, $fontFile);
			$testbox = imagettfbbox($fontSize, $angle, $fontFile, $wrapped);
			$actualHeight = abs($testbox[1] - $testbox[7]);
			if($actualHeight <= $height){
				return $fontSize;
			}else{
				$fontSize--;
			}
		}
		return $fontSize;
	}

	/**
	 * Draw multi-line text box and auto wrap text
	 *
	 * @param String $text
	 * @param array $options
	 * @return $this
	 */
	public function textBox($text, $options=array()){
		$defaults = array(
			'fontSize' => $this->fontSize,
			'fontColor' => $this->textColor,
			'opacity' => $this->textOpacity,
			'x' => 0,
			'y' => 0,
			'width' => 100,
			'height' => null,
			'angle' => $this->textAngle,
			'strokeWidth' => $this->strokeWidth,
			'strokeColor' => $this->strokeColor,
			'fontFile' => $this->fontFile
		);
		extract(array_merge($defaults, $options), EXTR_OVERWRITE);
		if ($height) {
			$fontSize = $this->fitTobounds($fontSize, $angle, $fontFile, $text, $width, $height);
		}
		return $this->text($this->wrap($text, $width, $fontSize, $angle, $fontFile), array('fontSize' => $fontSize, 'x' => $x, 'y' => $y, 'angle' => $angle, 'strokeWidth' => $strokeWidth, 'opacity' => $opacity, 'fontColor' => $fontColor, 'strokeColor' => $strokeColor, 'fontFile' => $fontFile));
	}

	/**
	 * Helper to wrap text
	 *
	 * @param String $text
	 * @param integer $width
	 * @param integer $fontSize
	 * @param integer $angle
	 * @param String $fontFile
	 * @return String
	 */
	protected function wrap($text, $width=100, $fontSize=12, $angle=0, $fontFile=null){
		if($fontFile === null){
			$fontFile = $this->fontFile;
		}
		$ret = "";
		$arr = explode(' ', $text);
		foreach ($arr as $word){
			$teststring = $ret . ' ' . $word;
			$testbox = imagettfbbox($fontSize, $angle, $fontFile, $teststring);
			if ($testbox[2] > $width){
				$ret .= ($ret == "" ? "" : "\n") . $word;
			} else {
				$ret .= ($ret == "" ? "" : ' ') . $word;
			}
		}
		return $ret;
	}

	/**
	 * Check quality is correct before save
	 *
	 * @return $this
	 */
	public function checkQuality(){
		switch($this->type){
			case IMAGETYPE_PNG:
				if($this->type > 9){
					$this->quality = 3;
				}
				break;
		}
		return $this;
	}

	/**
	 * Set's global folder mode if folder structure needs to be created
	 *
	 * @param integer $mode
	 * @return $this
	 */
	public function setFolderMode($mode=0755){
		$this->folderMode = $mode;
		return $this;
	}

	/**
	 * Set's global text size
	 *
	 * @param integer $size
	 * @return $this
	 */
	public function setFontSize($size=12){
		$this->fontSize = $size;
		return $this;
	}

	/**
	 * Set's global text vertical alignment
	 *
	 * @param String $align
	 * @return $this
	 */
	public function setAlignVertical($align='top'){
		$this->alignVertical = $align;
		return $this;
	}

	/**
	 * Set's global text horizontal alignment
	 *
	 * @param String $align
	 * @return $this
	 */
	public function setAlignHorizontal($align='left'){
		$this->alignHorizontal = $align;
		return $this;
	}

	/**
	 * Set's global text colour using RGB
	 *
	 * @param array $colour
	 * @return $this
	 */
	public function setTextColor($colour=array(255, 255, 255)){
		$this->textColor = $colour;
		return $this;
	}

	/**
	 * Set's global text angle
	 *
	 * @param integer $angle
	 * @return $this
	 */
	public function setTextAngle($angle=0){
		$this->textAngle = $angle;
		return $this;
	}

	/**
	 * Set's global text stroke
	 *
	 * @param integer $strokeWidth
	 * @return $this
	 */
	public function setStrokeWidth($strokeWidth=0){
		$this->strokeWidth = $strokeWidth;
		return $this;
	}

	/**
	 * Set's global text opacity
	 *
	 * @param float $opacity
	 * @return $this
	 */
	public function setTextOpacity($opacity=1.0){
		$this->textOpacity = $opacity;
		return $this;
	}

	/**
	 * Set's global stroke colour
	 *
	 * @param array $colour
	 * @return $this
	 */
	public function setStrokeColor($colour=array(0, 0, 0)){
		$this->strokeColor = $colour;
		return $this;
	}

	/**
	 * Set's global font file for text from .ttf font file (TrueType)
	 *
	 * @param string $fontFile
	 * @return $this
	 */
	public function setFont($fontFile){
		$this->fontFile = $fontFile;
		return $this;
	}

	/**
	 * Set's global quality for PNG output
	 *
	 * @param string $quality
	 * @return $this
	 */
	public function setQuality($quality){
		$this->quality = $quality;
		return $this;
	}

	/**
	 * Set's global output type
	 *
	 * @param String $type
	 * @param String $quality
	 * @return $this
	 */
	public function setOutput($type, $quality = null){
		switch(strtolower($type)){
			case 'gif':
				$this->type = IMAGETYPE_GIF;
				break;
			case 'jpg':
				$this->type = IMAGETYPE_JPEG;
				break;
			case 'png':
				$this->type = IMAGETYPE_PNG;
				break;
		}
		if($quality !== null){
			$this->setQuality($quality);
		}
		return $this;
	}
}
