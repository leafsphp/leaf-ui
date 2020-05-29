<?php

namespace Leaf\UI;

/**
 * Leaf UI Templates [BETA]
 * ---------------------
 * Create your Leaf UI from a template
 * 
 * @version 1.0.0
 * @author Michael Darko <mychi.darko@gmail.com>
 */
class Template extends \Leaf\UI {
	/**
	 * Create a basic template
	 */
	public static function _template(string $name, array $body, array $head = []) {
		$template = self::html([
			self::head([
				self::title($name),
				self::meta("viewport", "width=device-width, initial-scale=1"),
				self::_style(self::_vendor("default/default.css")),
				(!empty($head)) ? $head : null
			]),
			self::body($body)
		]);

		return $template;
	}
}
