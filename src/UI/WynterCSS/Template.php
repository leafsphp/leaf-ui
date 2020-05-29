<?php
namespace Leaf\UI\WynterCSS;

class Template extends \Leaf\UI\WynterCSS {
    /**
     * Scaffold a Leaf UI
     * 
     * @param array $children Options for scaffold
     */
    public static function _scaffold(array $children) {
        $template = self::html([
			self::head([
				self::title($children["name"]),
				self::meta("viewport", "width=device-width, initial-scale=1"),
				self::_style(self::_vendor("WynterCSS/wynter.css")),
				self::_style(self::_vendor("WynterCSS/wynter-exp.css")),
				self::_style(self::_vendor("WynterCSS/wynter-icons.css")),
				isset($children["head"]) ? $children["head"] : null
			]),
			isset($children["body"]) ? self::body($children["body"]) : self::body([
                !isset($children["app-bar"]) ? self::header(["class" => "navbar", "style" => "padding: 10px 20px; box-shadow: 1px 0px 6px #ccc;"], [
					self::section(["class" => "navbar-section"], [
						self::a(["class" => "navbar-brand mr-2"], $children["name"] ?? $children["brand"]),
					]),
					self::section(["class" => "navbar-section"], [
						isset($children["nav-links"]) ? self::loop($children["nav-links"], function($value, $key) {
							return self::a(["class" => "btn btn-link", "href" => $value], $key);
						}) : null
					]),
				]) : $children["app-bar"]
			]),
			(isset($children["hero"]) && !is_array($children["hero"])) ? $children["hero"] : (
				"hero component here"
			)
		]);

		return $template;
    }
}