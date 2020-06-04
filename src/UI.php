<?php

namespace Leaf;

/**
 * Leaf UI [BETA]
 * ---------------------
 * Leaf UI is a PHP library for building user interfaces.
 * 
 * @version 1.0.0
 * @author Michael Darko <mychi.darko@gmail.com>
 */
class UI
{
	/**
	 * Elements defined by the user eg: `_avatar`
	 */
	protected static $custom_elements = [];
	/**
	 * A self closing tag
	 */
	public const SINGLE_TAG = "single-tag";
	public const SELF_CLOSING = "self-closing";

	/*
    |--------------------------------------------------------------------------
    | Leaf UI Base
    |--------------------------------------------------------------------------
    | Leaf UI specific code. Most of Leaf UI depends on this code
    |--------------------------------------------------------------------------
	*/

	/**
	 * Create an HTML element
	 * 
	 * Element Type Options:
	 * - UI::SELF_CLOSING
	 * - UI::SINGLE_TAG
	 * - Ignore to create a normal tag
	 * 
	 * @param string $element The HTML Element to create
	 * @param array $props The Element attributes eg: `style`
	 * @param string|array $children Element's children
	 * @param string $type The type of tag you want to create
	 */
	public static function create_element(string $element, array $props = [], $children = [], string $type = "normal")
	{
		$type = strtolower($type);
		$attributes = "";
		$subs = "";
		$id = self::random_id($element);

		if (is_array($children)) {
			foreach ($children as $child) {
				$subs .= $child;
			}
		} else {
			$subs = $children;
		}

		if (!empty($props)) {
			foreach ($props as $key => $value) {
				if ($key != "id") {
					$attributes .= "$key=\"" . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . "\" ";
				} else {
					$id = $props["id"];
				}
			}
		}

		if ($type == self::SELF_CLOSING) {
			return self::self_closing($element, $attributes, $id);
		}

		if ($type == self::SINGLE_TAG) {
			return self::self_closing($element, $attributes, $id);
		}

		return "<$element id=\"$id\" $attributes>$subs</$element>";
	}

	/**
	 * Return a self closing tag
	 * 
	 * @param string $element The element you want to create
	 * @param string $attributes Element attributes eg: `name`, `style`
	 * @param string $id Element id (compulsory)
	 */
	public static function self_closing(string $element, string $attributes, string $id)
	{
		return "<$element $attributes id=\"$id\" />";
	}

	/**
	 * Return a single tag eg: `meta`, `link`
	 * 
	 * @param string $element The element you want to create
	 * @param string $attributes Element attributes eg: `name`, `style`
	 * @param string $id Element id (compulsory)
	 */
	public static function single_tag(string $element, string $attributes, string $id)
	{
		return "<$element $attributes id=\"$id\">";
	}

	/**
	 * Map styles to style tag
	 * 
	 * @param array $styles The styles to apply
	 * @param array $props Style tag attributes
	 */
	public static function create_styles(array $styles, array $props)
	{
		$parsed_styles = "";

		foreach ($styles as $key => $value) {
			if (is_array($value)) {
				foreach ($value as $selector => $styling) {
					$parsed_styles .= "$key { $selector { $styling }}";
				}
			} else {
				$parsed_styles .= "$key { $value }";
			}
		}

		return self::create_element("style", $props, $parsed_styles);
	}

	/**
	 * [Experimental]
	 *
	 * Create your own element without extending Leaf\UI. 
	 * 
	 * It is adviced that you parse all custom elements into native HTML code.
	 * 
	 * eg: `_column` parses to HTML <div> and CSS flex
	 * 
	 * Also, although not compulsory, custom elements should start with `_`
	 * 
	 * @param string $name The name of your custom element
	 * @param callable $handler
	 * @param array $props
	 */
	public static function make(string $name, callable $handler)
	{
		if (is_callable($handler)) {
			self::$custom_elements[$name] = call_user_func($handler, $name);
		}
	}

	/**
	 * Use an element created with `make`
	 * 
	 * @param string $name The custom element you want to use
	 */
	public static function custom(string $name, array $props = [], array $children = [], string $type = "normal")
	{
		$element = self::$custom_elements[$name];
		$compile_to = "";
		$attributes = "";
		$type = strtolower($type);
		$subs = "";
		$compile_to = isset($element["compile"]) ? $element["compile"] : $name;

		$id = self::random_id() . $compile_to;

		foreach ($props as $key => $value) {
			if (isset($element[$key])) {
				$element[$key] .= " " . htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
			} else {
				$element[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
			}
			if ($key == "id") {
				$id = $props["id"];
			}
		}
		if (isset($element["props"])) {
			foreach ($element["props"] as $prop => $value) {
				$attributes .= " $prop=\"$value\"";
			}
		}
		foreach ($element as $key => $value) {
			if ($key != "props" && $key != "compile") {
				$attributes .= " $key=\"$value\"";
			}
		}
		if (is_array($children)) {
			foreach ($children as $child) {
				$subs .= $child;
			}
		} else {
			$subs = $children;
		}

		if ($type == self::SELF_CLOSING) {
			return self::self_closing($compile_to, $attributes, $id);
		}

		if ($type == self::SINGLE_TAG) {
			return self::self_closing($compile_to, $attributes, $id);
		}

		return "<$compile_to $attributes id=\"$id\">$subs</$compile_to>";
	}

	/**
	 * Generate a random id
	 *
	 * @param string $element An html element name to append to id
	 * @return string The random id
	 */
	public static function random_id($element = "")
	{
		$seed = str_split('abcdefghijklmnopqrstuvwxyz' . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' . '0123456789_-');
		shuffle($seed);
		$rand = '';
		foreach (array_rand($seed, 5) as $k) $rand .= $seed[$k];

		return "$rand-$element";
	}

	/**
	 * Render a Leaf UI
	 * 
	 * @param string $element The UI components to render
	 * @param string $inject A string to inject into element
	 */
	public static function render($element, $inject = null)
	{
		header("Content-Type: text/html");
		echo $inject . $element;
	}

	/**
	 * Loop over an array of items
	 * 
	 * @param array $array The array to loop through
	 * @param callable $handler Call back function to run per iteration
	 */
	public static function loop(array $array, callable $handler)
	{
		$element = "";
		if (is_callable($handler)) {
			foreach ($array as $key => $value) {
				$element .= call_user_func($handler, $value, $key);
			}
		}
		return $element;
	}

	/**
	 * Create an if condition
	 * 
	 * @param mixed $condition The if condition
	 * @param mixed $element The element to return if $condition is true
	 * @param mixed $else The element to return if $condition is false
	 */
	public static function if($condition, $element, $else = null)
	{
		if ($condition) {
			return $element;
		} else {
			return $else;
		}
	}

	/**
	 * Create a negative if condition
	 * 
	 * @param mixed $condition The unless condition
	 * @param mixed $element The element to return if $condition is false
	 * @param mixed $else The element to return if $condition is true
	 */
	public static function unless($condition, $element, $else = null)
	{
		if (!$condition) {
			return $element;
		} else {
			return $else;
		}
	}

	/**
	 * Return Leaf UI's vendor path
	 * 
	 * @param string $file A file/path to append to vendor path
	 * @return string Path to leaf ui in vendor folder
	 */
	public static function _vendor($file = null)
	{
		return "vendor\\leafs\\ui\\src\\UI\\$file";
	}

	/**
	 * Import/Use a styleheet
	 * 
	 * @param string|array $src The styles/stylesheet to apply
	 * @param array $props The attributes for style/link tag
	 */
	public static function _style($src, array $props = [])
	{
		if (!is_array($src)) {
			return self::create_element("link", ["href" => $src, "rel" => "stylesheet"], [], self::SINGLE_TAG);
		}
		return self::create_styles($src, $props);
	}

	/**
	 * Import/Use a script
	 * 
	 * @param string|array $src The internal/external scripts to apply
	 * @param array $props The attributes for style/link tag
	 */
	public static function _script($src, array $props = [])
	{
		if (!is_array($src)) {
			$props["src"] = $src;
			return self::create_element("script", $props);
		}
		return self::create_element("script", $props, $src);
	}

	/*
    |--------------------------------------------------------------------------
    | Structural HTML Tags
    |--------------------------------------------------------------------------
	*/
	/**
	 * HTML Element
	 * 
	 * @param array $children HTML Element children
	 * @param array $props Attributes for HTML element
	 */
	public static function html(array $children, array $props = [])
	{
		return self::create_element("!Doctype html", [], [], self::SINGLE_TAG) . self::create_element("html", $props, $children);
	}

	/**
	 * Head Element
	 * 
	 * @param array $children Head Element children
	 * @param array $props Attributes for Head element
	 */
	public static function head(array $children, array $props = [])
	{
		return self::create_element("head", $props, $children);
	}

	/**
	 * body Element
	 * 
	 * @param array $children body Element children
	 * @param array $props Attributes for body element
	 */
	public static function body(array $children, array $props = [])
	{
		return self::create_element("body", $props, $children);
	}

	/**
	 * header Element
	 * 
	 * @param array $props Attributes for header element
	 * @param array $children header Element children
	 */
	public static function header(array $props = [], array $children = [])
	{
		return self::create_element("header", $props, $children);
	}

	/**
	 * nav Element
	 * 
	 * @param array $props Attributes for nav element
	 * @param array $children nav Element children
	 */
	public static function nav(array $props = [], array $children = [])
	{
		return self::create_element("nav", $props, $children);
	}

	/**
	 * footer Element
	 * 
	 * @param array $props Attributes for footer element
	 * @param array $children footer Element children
	 */
	public static function footer(array $props = [], array $children = [])
	{
		return self::create_element("footer", $props, $children);
	}

	/**
	 * aside Element
	 * 
	 * @param array $props Attributes for aside element
	 * @param array $children aside Element children
	 */
	public static function aside(array $props = [], array $children = [])
	{
		return self::create_element("aside", $props, $children);
	}

	/**
	 * Line Break
	 * 
	 * @param array $props Attributes for br element
	 */
	public static function br(array $props = [])
	{
		return self::create_element("br", $props, [], self::SINGLE_TAG);
	}

	/**
	 * Horizontal Rule
	 * 
	 * @param array $props Attributes for hr element
	 */
	public static function hr(array $props = [])
	{
		return self::create_element("hr", $props, [], self::SINGLE_TAG);
	}

	/**
	 * HTML anchor Element 
	 * 
	 * @param array $props Element props
	 * @param string|array $children Children
	 */
	public static function a(array $props = [], $children = [])
	{
		return self::create_element("a", $props, $children);
	}

	/**
	 * HTML DIV Element 
	 * 
	 * @param array $props Element props
	 * @param string|array $children Children
	 */
	public static function div(array $props = [], $children = [])
	{
		return self::create_element("div", $props, $children);
	}

	/**
	 * HTML Span Element
	 * 
	 * @param array $props Element props
	 * @param string|array $children Children
	 */
	public static function span(array $props = [], $children = [])
	{
		return self::create_element("span", $props, $children);
	}

	/**
	 * Section Element
	 * 
	 * @param array $props Element props
	 * @param string|array $children Children
	 */
	public static function section(array $props = [], array $children = [])
	{
		return self::create_element("section", $props, $children);
	}

	/**
	 * HTML hgroup Element
	 * 
	 * @param string|array $children Children
	 * @param array $props Element props
	 */
	public static function hgroup($children, array $props = [])
	{
		return self::create_element("hgroup", $props, $children);
	}

	/**
	 * HTML H1 Element
	 * 
	 * @param string|array $children Children
	 * @param array $props Element props
	 */
	public static function h1($children, array $props = [])
	{
		return self::create_element("h1", $props, $children);
	}

	/**
	 * HTML H2 Element
	 * 
	 * @param string|array $children Children
	 * @param array $props Element props
	 */
	public static function h2($children, array $props = [])
	{
		return self::create_element("h2", $props, $children);
	}

	/**
	 * HTML H3 Element
	 * 
	 * @param string|array $children Children
	 * @param array $props Element props
	 */
	public static function h3($children, array $props = [])
	{
		return self::create_element("h3", $props, $children);
	}

	/**
	 * HTML H4 Element
	 * 
	 * @param string|array $children Children
	 * @param array $props Element props
	 */
	public static function h4($children, array $props = [])
	{
		return self::create_element("h4", $props, $children);
	}

	/**
	 * HTML H5 Element
	 * 
	 * @param string|array $children Children
	 * @param array $props Element props
	 */
	public static function h5($children, array $props = [])
	{
		return self::create_element("h5", $props, $children);
	}

	/**
	 * HTML H6 Element
	 * 
	 * @param string|array $children Children
	 * @param array $props Element props
	 */
	public static function h6($children, array $props = [])
	{
		return self::create_element("h6", $props, $children);
	}

	/**
	 * HTML Blockquote
	 * 
	 * @param string|array $children Children
	 * @param array $props Element props
	 */
	public static function blockquote($children, array $props = [])
	{
		return self::create_element("blockquote", $props, $children);
	}

	/**
	 * HTML Paragraph Element
	 * 
	 * @param string|array $children Children
	 * @param array $props Element props
	 */
	public static function p($children, array $props = [])
	{
		return self::create_element("p", $props, $children);
	}

	/**
	 * HTML Article Element
	 * 
	 * @param array $props Element props
	 * @param array $children Children
	 */
	public static function article(array $props = [], array $children = [])
	{
		return self::create_element("article", $props, $children);
	}

	/**
	 * HTML 5 Details Element
	 * 
	 * @param array $props Element props
	 * @param array $children Children
	 */
	public static function details(array $props = [], array $children = [])
	{
		return self::create_element("details", $props, $children);
	}

	/**
	 * Html summary
	 * 
	 * @param array $props Element props
	 * @param array $children Children
	 */
	public static function summary(array $props = [], array $children = [])
	{
		return self::create_element("summary", $props, $children);
	}

	/*
    |--------------------------------------------------------------------------
    | Meta-data HTML Tags
    |--------------------------------------------------------------------------
	*/

	/**
	 * Html Link Tag
	 * 
	 * @param string $href Link to resource
	 * @param string $rel Resource's relation to current document
	 * @param array $props Link tag attributes
	 */
	public static function link(string $href, string $rel = "stylesheet", array $props = [])
	{
		$props["href"] = $href;
		$props["rel"] = $rel;
		return self::create_element("link", $props, [], self::SINGLE_TAG);
	}

	/**
	 * Html Base Tag
	 * 
	 * @param string $href base url
	 * @param array $props Link tag attributes
	 */
	public static function base(string $href, array $props = [])
	{
		$props["href"] = $href;
		return self::create_element("base", $props, [], self::SINGLE_TAG);
	}

	/**
	 * Title element
	 * 
	 * @param string $title The document title
	 * @param array $props Title Element props
	 */
	public static function title(string $title, array $props = [])
	{
		return self::create_element("title", $props, [$title]);
	}

	/**
	 * Meta Tag
	 * 
	 * @param string $name meta name property
	 * @param string $content meta content property
	 * @param array $props Additional props
	 */
	public static function meta(string $name, string $content, array $props = [])
	{
		$props["name"] = $name;
		$props["content"] = $content;
		return self::create_element("meta", $props, [], self::SINGLE_TAG);
	}

	/*
    |--------------------------------------------------------------------------
    | Formatting Tags
    |--------------------------------------------------------------------------
	*/

	/**
	 * tt tag
	 * 
	 * @param array|string $children Children
	 * @param array $props Element props
	 */
	public static function tt($children, array $props = [])
	{
		return self::create_element("tt", $props, $children);
	}

	/**
	 * abbr element
	 * 
	 * @param string $title Long Text
	 * @param string $children Short Text
	 * @param array $props Element props
	 */
	public static function abbr(string $title, string $children, array $props = [])
	{
		$props["title"] = $title;
		return self::create_element("abbr", $props, $children);
	}

	/**
	 * HTML address Element 
	 * 
	 * @param array $children Children
	 * @param array $props Element props
	 */
	public static function address(array $children, array $props = [])
	{
		return self::create_element("address", $props, $children);
	}

	/**
	 * bdi tag
	 * 
	 * @param string $children Children
	 * @param array $props Element props
	 */
	public static function bdi(string $children, array $props = [])
	{
		return self::create_element("bdi", $props, $children);
	}

	/**
	 * bdo tag
	 * 
	 * @param string $children Children
	 * @param array $props Element props
	 */
	public static function bdo(string $children, array $props = [])
	{
		return self::create_element("bdo", $props, $children);
	}

	/**
	 * b tag
	 * 
	 * @param array|string $children Children
	 * @param array $props Element props
	 */
	public static function b($children, array $props = [])
	{
		return self::create_element("b", $props, $children);
	}

	/**
	 * i tag
	 * 
	 * @param array|string $children Children
	 * @param array $props Element props
	 */
	public static function i($children, array $props = [])
	{
		return self::create_element("i", $props, $children);
	}

	/**
	 * u tag
	 * 
	 * @param array|string $children Children
	 * @param array $props Element props
	 */
	public static function u($children, array $props = [])
	{
		return self::create_element("u", $props, $children);
	}

	/**
	 * small tag
	 * 
	 * @param array|string $children Children
	 * @param array $props Element props
	 */
	public static function small($children, array $props = [])
	{
		return self::create_element("small", $props, $children);
	}

	/**
	 * big tag
	 * 
	 * @param array|string $children Children
	 * @param array $props Element props
	 */
	public static function big($children, array $props = [])
	{
		return self::create_element("big", $props, $children);
	}

	/**
	 * sub tag
	 * 
	 * @param array|string $children Children
	 * @param array $props Element props
	 */
	public static function sub($children, array $props = [])
	{
		return self::create_element("sub", $props, $children);
	}

	/**
	 * sup tag
	 * 
	 * @param array|string $children Children
	 * @param array $props Element props
	 */
	public static function sup($children, array $props = [])
	{
		return self::create_element("sup", $props, $children);
	}

	/*
    |--------------------------------------------------------------------------
    | Embedded Content Tags
    |--------------------------------------------------------------------------
	*/

	/**
	 * figure Element
	 * 
	 * @param array $props Attributes for figure element
	 * @param array $children figure Element children
	 */
	public static function figure(array $props = [], array $children = [])
	{
		return self::create_element("figure", $props, $children);
	}

	/**
	 * img Element
	 * 
	 * @param array $image image source
	 * @param array $props Attributes for img element
	 */
	public static function img(string $image, array $props = [])
	{
		$props["src"] = $image;
		return self::create_element("img", $props, [], self::SINGLE_TAG);
	}

	/*
    |--------------------------------------------------------------------------
    | Form Tags
    |--------------------------------------------------------------------------
	*/

	/**
	 * Shorthand method for creating an HTML form element
	 * 
	 * @param string $method HTTP method
	 * @param string $action Form action
	 * @param array $fields Form Fields
	 * @param array $props Other attributes eg: `style`
	 */
	public static function form(string $method, string $action, array $fields, array $props = [])
	{
		$props["action"] = $action;
		$props["method"] = $method;

		return self::create_element("form", $props, $fields);
	}

	/**
	 * Shorthand method for creating an HTML form label
	 * 
	 * @param string|array $label Children
	 * @param string $id Label ID
	 * @param array $props Other attributes eg: `style`
	 */
	public static function label(string $label, string $id = null, array $props = [])
	{
		if (!$id) {
			$id = self::random_id($label);
		}
		$props["id"] = $id;
		$props["for"] = $id;
		return self::create_element("label", $props, is_array($label) ? $label : [$label]);
	}

	/**
	 * Shorthand method for creating an HTML form input
	 * 
	 * @param string $type Input type
	 * @param string $name Input name
	 * @param array $props Other attributes eg: `style` and `value`
	 */
	public static function input(string $type, string $name, array $props = [])
	{
		$id = self::random_id($type);
		$output = "";

		if (!isset($props["id"])) {
			$props["id"] = $id;
		} else {
			$id = $props["id"];
		}

		if (isset($props['label'])) {
			$output .= self::label($props['label'], $id);
		}

		$props["type"] = $type;
		$props["name"] = $name;

		$output .= self::create_element("input", $props, []);
		return $output;
	}

	/**
	 * HTML Textarea component
	 * 
	 * @param string $name textarea name
	 * @param array $props Other attributes eg: `style` and `value`
	 * @param string $children Textarea text
	 */
	public static function textarea(string $name, array $props = [], string $children = "")
	{
		$id = self::random_id($name);
		$output = "";

		if (!isset($props["id"])) {
			$props["id"] = $id;
		} else {
			$id = $props["id"];
		}

		if (isset($props['label'])) {
			$output .= self::label($props['label'], $id);
			unset($props["label"]);
		}

		$props["name"] = $name;

		$output .= self::create_element("textarea", $props, [$children]);
		return $output;
	}

	/**
	 * Datalist element
	 * 
	 * @param string $id id for datalist element
	 * @param array $list A list of datalist values
	 * @param array $props Attributes for datalist
	 */
	public static function datalist(string $id, array $list, array $props = [])
	{
		$props["id"] = $id;
		return self::create_element("datalist", $props, self::loop($list, function ($value) {
			return self::option($value);
		}));
	}

	/**
	 * HTML Select element
	 * 
	 * @param array $list A list of datalist values
	 * @param array $props Attributes for datalist
	 */
	public static function select(array $list, array $props = [])
	{
		return self::create_element("select", $props, self::loop($list, function ($text, $value) {
			return self::option($value, $text);
		}));
	}

	/**
	 * Option Tag
	 * 
	 * @param string $value Value property
	 * @param string $text Text displayed to the user
	 * @param array $props Additional props
	 */
	public static function option(string $value, string $text = "", array $props = [])
	{
		$props["value"] = $value;
		return self::create_element("option", $props, $text);
	}

	/**
	 * HTML Button Element
	 * 
	 * @param string $text Text displayed on button
	 * @param array $props Button properties
	 */
	public static function button(string $text, array $props = [])
	{
		return self::create_element("button", $props, [$text]);
	}

	/*
    |--------------------------------------------------------------------------
    | Custom Leaf UI Tags
    |--------------------------------------------------------------------------
	*/

	/**
	 * Render uppercase text
	 * 
	 * @param array|string $children Children
	 * @param array $props Element props
	 */
	public static function _uppercase($children, array $props = [])
	{
		$children = strtoupper($children);
		return self::create_element("p", $props, $children);
	}

	/**
	 * Render lowercase text
	 * 
	 * @param string|array $children Children
	 * @param array $props Element props
	 */
	public static function _lowercase(string $children, array $props = [])
	{
		$children = strtolower($children);
		return self::create_element("p", $props, $children);
	}

	/**
	 * Custom div Element (padding container)
	 * 
	 * @param string|array $children Children
	 * @param array $props Element props
	 */
	public static function _container($children, array $props = [])
	{
		if (!isset($props["style"])) {
			$props["style"] = "";
		}
		$props["style"] = "padding: 12px 25px; " . $props["style"];
		return self::create_element("div", $props, $children);
	}

	/**
	 * Custom div Element (flex row)
	 * 
	 * @param array $children Children
	 * @param array $props Element props
	 */
	public static function _row(array $children, array $props = [])
	{
		if (!isset($props["style"])) {
			$props["style"] = "";
		}
		$props["style"] = "display: flex; " . $props["style"];
		return self::create_element("div", $props, $children);
	}

	/**
	 * Custom div Element (flex column)
	 * 
	 * @param array $children Children
	 * @param array $props Element props
	 */
	public static function _column(array $children, array $props = [])
	{
		if (!isset($props["style"])) {
			$props["style"] = "";
		}
		$props["style"] = "display: flex; flex-direction: column; " . $props["style"];
		return self::create_element("div", $props, $children);
	}

	/**
	 * Custom Datalist element
	 * 
	 * @param string $type input type
	 * @param string $name input name
	 * @param string $id id for datalist element
	 * @param array $list A list of datalist values
	 * @param array $props Attributes for datalist wrapper
	 */
	public static function _datalist(string $type, string $name, string $id, array $list, array $props = [])
	{
		return self::div($props, [
			self::input($type, $name, ["list" => $id]),
			self::datalist($id, $list)
		]);
	}
}
