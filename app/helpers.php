<?php
/**
 * Created by PhpStorm.
 * User: Siebe
 * Date: 20/11/2016
 * Time: 22:44
 */

/**
 * A function to easily flash a toastr notification
 *
 * @param $style
 * @param $title
 * @param $content
 */
function flashToastr($style, $title, $content)
{
	$stringyContent = $content;
	if (is_array($content))
	{
		// If the content is an array, convert it to a string
		$stringyContent = "";
		foreach ($content as $contentMessage)
		{
			// Add some paragraphs for nice reading
			$stringyContent .= "<p>" . $contentMessage . "</p>";
		}
	}
	// Set the settings
	$message = [
		"style"   => $style,
		"title"   => $title,
		"content" => $stringyContent
	];
	// Put it in the session for blade to pick it up
	session()->flash('messageToastr', $message);
}