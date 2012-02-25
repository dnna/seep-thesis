<?php
/**
 * You input two hex colors, and the degree to which you want to fade between the two. An example call to the function is:
 * $new_color = figureColor("#000000", "#FFFFFF", 5); // will return a gray of some sort. Play around with the value you send $count. I can't remember what its bounds are, but this code should do the trick.
 * Code from <a href=http://www.programmersheaven.com/mb/phpstuff/166720/166720/fade-a-hex-color/>www.programmersheaven.com</a>
 * @author awulf
 */
class ColorCalculator {
	static function figureColor($dark, $light, $count){
	// $dark and $light come in format "#FFFFFF" or something.
	// they have the # with 'em
	$dark = substr($dark, 1, 6);
	$light = substr($light, 1, 6);

	$offset = array();
	for($i = 0; $i <6; $i+=2){
	$offset[] = ColorCalculator::getOffset(substr($dark, $i, 2), substr($light, $i, 2), $count);
	}

	//rebuild the new color.
	$newColor = implode("", $offset);
	$newColor = "#" . $newColor;

	return $newColor;
	}

	static function getOffSet($dark_in, $light_in, $count){
	// $dark_in and $light_in are only one color of the rgb
	// example for a color #FFCC99, the inputs would be sent in
	// as either a FF, CC, or 99.
	// returns the faded portion of either the color input
	$lighterAmount = 17;

	$dark = array();
	$dark[] = ColorCalculator::hexToInt(substr($dark_in,0,1));
	$dark[] = ColorCalculator::hexToInt(substr($dark_in,1,1));

	$light = array();
	$light[] = ColorCalculator::hexToInt(substr($light_in,0,1));
	$light[] = ColorCalculator::hexToInt(substr($light_in,1,1));

	$dark[0] *= 16;
	$light[0] *= 16;

	$dark = $dark[0] + $dark[1];
	$light = $light[0] + $light[1];

	$new = $light - $dark - $lighterAmount;


	$new = $new * $count/3;
	$new = intval($new);

	if($new < 0){
	$new = 0;
	}
	if($new > 255){
	$new = 255;
	}

	$new = $light - $new;

	$new = ColorCalculator::intToHex($new);

	return $new;
	}

	static function hexToInt($ret){
	if(strtoupper($ret) == "F"){
	$ret = 15;
	}else
	if(strtoupper($ret) == "E"){
	$ret = 14;
	}else
	if(strtoupper($ret) == "D"){
	$ret = 13;
	}else
	if(strtoupper($ret) == "C"){
	$ret = 12;
	}else
	if(strtoupper($ret) == "B"){
	$ret = 11;
	}else
	if(strtoupper($ret) == "A"){
	$ret = 10;
	}

	return $ret;
	}

	static function intToHex($ret){

	$hex = array();
	$one = $ret % 16;
	$ret -= $one;
	$hex[] = $ret / 16;
	$hex[] = $one;

	if($hex[0] < 0){
	$hex[0] = 0;
	}
	if($hex[1] < 0){
	$hex[1] = 0;
	}

	for($i = 0; $i < 2; $i++){
	if($hex[$i] == 15){
	$hex[$i] = "F";
	}else
	if($hex[$i] == 14){
	$hex[$i] = "E";
	}else
	if($hex[$i] == 13){
	$hex[$i] = "D";
	}else
	if($hex[$i] == 12){
	$hex[$i] = "C";
	}else
	if($hex[$i] == 11){
	$hex[$i] = "B";
	}else
	if($hex[$i] == 10){
	$hex[$i] = "A";
	}
	}

	$hex = implode("", $hex);

	return $hex;
	}
}
?>