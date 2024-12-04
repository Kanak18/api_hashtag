<?
function getWidthHeight($ActualWidth,$ActualHeight,$NewWidth,$NewHeight)
{
	# this function will return display width, display height and a boolean parameter "DontResize" as an array.
	# if actual width and actual height are less than new width and new height required, "DontResize" will be true and image can be displayed without resize code
	
	$ActualWidth = (isset($ActualWidth) && intval($ActualWidth) > 0)?intval($ActualWidth):0;	
	$ActualHeight = (isset($ActualHeight) && intval($ActualHeight) > 0)?intval($ActualHeight):0;	

	$NewWidth = (isset($NewWidth) && intval($NewWidth) > 0)?intval($NewWidth):0;	
	$NewHeight = (isset($NewHeight) && intval($NewHeight) > 0)?intval($NewHeight):0;	

	$ratio = ($ActualWidth/$ActualHeight);
			
	$DisplayWidth = $ActualWidth;
	$DisplayHeight = $ActualHeight;
			
	$DontResize = true;
			
	if($NewWidth>0)
	{
		if($ActualWidth >= $NewWidth)
		{
			$DontResize = false;

			$DisplayWidth = $NewWidth;
			$DisplayHeight = ($DisplayWidth / $ratio);
		
			if($NewHeight>0)
			{
				if($DisplayHeight>=$NewHeight)
				{
					$DontResize = false;

					$DisplayHeight = $NewHeight;
					$DisplayWidth = ($DisplayHeight * $ratio);
				}
			}
		}
	}
	else if($NewHeight>0)
	{		
		if($DisplayHeight >= $NewHeight)
		{	
			$DontResize = false;
					
			$DisplayHeight = $NewHeight;
			$DisplayWidth = ($DisplayHeight * $ratio);

			if($NewWidth>0)
			{
				if($DisplayWidth>=$NewWidth)
				{
					$DontResize = false;
							
					$DisplayWidth = $NewWidth;
					$DisplayHeight = ($DisplayWidth / $ratio);
				}
			}
		}
	}
	
	return Array($DisplayWidth,$DisplayHeight,$DontResize);	
}
	//dl('php_gd2.dll');
	
	# use this file if you want to display image stored in some folder.
	# This can be used for PNG, GIF and JPG
	# pass full path to file in $File querystring along with new width and new height 
	
	# if width and height are not found, it will display full image without resizing code.
	
	# if new width is not specified, only height will be restricted and width will be actual image width.
	# if new height is not specified, only width will be restrected and height will be actual image height.
	# if both new height and new width are specified, image will be displayed with in that dimentions.

	# if width and height are passed, GIF will lose animation it might have.
	
	# I have tried to preserve transparency for GIF and PNG images but it may not work perfectly.

	$File = isset($_REQUEST["File"])?trim($_REQUEST["File"]):"";	
	$NewWidth = (isset($_REQUEST["Width"]) && intval($_REQUEST["Width"]) > 0)?intval($_REQUEST["Width"]):0;	
	$NewHeight = (isset($_REQUEST["Height"]) && intval($_REQUEST["Height"]) > 0)?intval($_REQUEST["Height"]):0;	
	
	if(strlen($File) > 0 && is_file($File) && file_exists($File))
	{
		list($ActualWidth,$ActualHeight,$ImageType) = GetImageSize($File);
		# ImageType 1=GIF, 2=JPG, 3=PNG

		$DisplayWH = getWidthHeight($ActualWidth,$ActualHeight,$NewWidth,$NewHeight);
		
		$DisplayWidth = $DisplayWH[0];
		$DisplayHeight = $DisplayWH[1];
		$DontResize = $DisplayWH[2];

		if($ImageType == 1)
		{
			//Header("Content-type: image/gif");	

			if($DontResize===true)
			{
				$ImageData = fread(fopen($File, "r"), filesize($File));
				echo $ImageData;
			}
			else
			{
				$dst = imagecreate ($DisplayWidth, $DisplayHeight);
				$src = imagecreatefromgif($File);
		
				$transparent = imagecolorat($src, 0,0);
				$t = imagecolorsforindex($src, $transparent);
				$mytransparent = imagecolorallocatealpha($dst,$t["red"],$t["green"],$t["blue"],$t["alpha"]);
				imagefill($dst, 0, 0, $mytransparent);
				imagecolortransparent($dst, $mytransparent);
		
				imagecopyresampled ($dst, $src, 0, 0, 0, 0, $DisplayWidth, $DisplayHeight,$ActualWidth,$ActualHeight);
		
				imagegif($dst);		
				imagedestroy($dst);
			}
		}			
		elseif($ImageType == 2)
		{
			//Header("Content-type: image/jpeg");	
			
			if($DontResize===true)
			{
				$ImageData = fread(fopen($File, "r"), filesize($File));
				echo $ImageData;
			}
			else
			{
	
				$dst = imagecreatetruecolor ($DisplayWidth, $DisplayHeight);
				$src = imagecreatefromjpeg($File); 
		
				imagecopyresampled ($dst, $src, 0, 0, 0, 0, $DisplayWidth, $DisplayHeight,$ActualWidth,$ActualHeight);
	
				imagejpeg($dst,NULL,100);
		
				imagedestroy($dst);
			}		
		}		
		elseif($ImageType == 3)
		{
			//Header("Content-type: image/png");
			
			if($DontResize===true)
			{
				$ImageData = fread(fopen($File, "r"), filesize($File));
				echo $ImageData;
			}
			else
			{
				$dst = imagecreatetruecolor ($DisplayWidth, $DisplayHeight);
				$src = imagecreatefrompng($File);
		
				$transparent = imagecolorat($src, 0,0);
				$t = imagecolorsforindex($src, $transparent);
				
				$mytransparent = imagecolorallocatealpha($dst,$t["red"],$t["green"],$t["blue"],$t["alpha"]);
				imagefill($dst, 0, 0, $mytransparent);
				imagecolortransparent($dst, $mytransparent);
		
				imagecopyresampled ($dst, $src, 0, 0, 0, 0, $DisplayWidth, $DisplayHeight,$ActualWidth,$ActualHeight);
				imagepng($dst);		
				imagedestroy($dst);
			}
		}	
	}
?>