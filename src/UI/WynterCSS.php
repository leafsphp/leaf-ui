<?php
namespace Leaf\UI;

/**
 * Leaf UI (Wynter Components) [BETA]
 * ---------------------
 * Leaf UI with a touch of Wynter CSS
 * 
 * @version 1.0.0
 * @author Michael Darko <mychi.darko@gmail.com>
 */
class WynterCSS extends \Leaf\UI {
	/**
	 * Render a wynter UI
	 */
	public static function render($element, $inject = null) {
		parent::render(
			$inject
			.self::_style(self::_vendor("WynterCSS/wynter.css"))
			.self::_style(self::_vendor("WynterCSS/wynter-exp.css"))
			.self::_style(self::_vendor("WynterCSS/wynter-icons.css"))
			.$element
		);
	}

	/**
	 * Wynter Avatar Component
	 */
	public static function _avatar(string $image, string $text = "WYN", array $props = [], array $children = [])
	{
		$f_props = ["wyn:avatar" => "", "data-initial" => $text];
		if (isset($props["size"])) {
			$f_props["wyn:avatar-{$props["size"]}"] = "";
			unset($props["size"]);
		}
		if (isset($props["badge"])) {
			$f_props["wyn:badge data-badge"] = $props["badge"];
			unset($props["badge"]);
		}
		if (isset($props["presence"])) {
			$children[] = self::i([], ["wyn:avatar-presence-{$props['presence']}" => ""]);
			unset($props["presence"]);
		}
		if (strlen($image) < 1) {
			return self::figure($f_props, $children);
		}
		$children[] = self::img($image, ["alt" => " "]);
		return self::figure($f_props, $children);
	}

	public static function _badge(string $badge, array $props = [], $children = [])
	{
		$props["wyn:badge data-badge"] = $badge;
		return self::span($props, $children);
	}

	public static function _bars(array $children, array $props = [])
	{
		if (!isset($props["class"])) $props["class"] = "";
		$props["class"] .= " bar";
		if (isset($props["variant"])) {
			$props["class"] .= " bar-{$props["variant"]}";
			unset($props["variant"]);
		}
		return self::div($props, $children);
	}

	public static function _bar(array $props = [])
	{
		if (!isset($props["class"])) $props["class"] = "";
		$props["class"] .= " bar-item";
		$props["role"] = "progressbar";

		if (!isset($props["style"])) $props["style"] = "";
		$value = $props["value"];
		$props["style"] .= "width:{$value}% !important;";
		$props["aria-valuenow"] = $value;
		unset($props["value"]);

		$props["aria-valuemin"] = isset($props["min"]) ? $props["min"] : "0";
		if(isset($props["min"])) unset($props["min"]);

		$props["aria-valuemax"] = isset($props["max"]) ? $props["max"] : "100";
		if(isset($props["max"])) unset($props["max"]);

		if (isset($props["tooltip"])) {
			$props["class"] .= " tooltip";
			$props["data-tooltip"] = $value;
		}
		$show = (isset($props["show-value"]) && $props["show-value"] == true) ? $value : "";
		return self::div($props, $show);
	}

	public static function _breadcrumb(array $breadcrumbs)
	{
		$links = "";
		$links .= self::create_element("ul", ["wyn:breadcrumb-arrow" => ""], [
			self::loop($breadcrumbs, function($link, $text) {
				return self::create_element("li", ["wyn:breadcrumb-item" => ""], [
					self::a(["href" => $link], $text)
				]);
			})
		]);
		return $links;
	}

	public static function _button(string $text, array $props = [])
	{
		$props["wyn:btn"] = "";
		if (isset($props["variant"])) {
			$props["wyn:btn-{$props['variant']}"] = "";
		}
		return self::button($text, $props);
	}

	public static function _btnGroup(array $children, array $props = [])
	{
		$props["wyn:btn-group"] = "";
		return self::div($props, $children);
	}

	public static function _card(array $props = [], array $children = [])
	{
		$props["wyn:card"] = "";
		return self::div($props, $children);
	}

	public static function _carousel(array $children, array $ids = ["slide-1", "slide-2", "slide-3", "slide-4"], array $props = []) 
	{
		$props["class"] = isset($props["class"])  ? $props["class"] . " carousel" : "carousel";

		return self::div($props, [
			self::loop($ids, function($id) {
				return self::input("radio", "carousel-radio", [
					"class" => "carousel-locator",
					"id" => $id,
					"hidden" => "",
					"checked" => "",
					"name" => "carousel-radio"
				]);
			}),
			self::div(["class" => "carousel-container"], [
				self::loop($children, function($child) {
					return $child;
				}),
			]),
			self::div(["class" => "carousel-nav"], [
				self::loop($children, function($child, $key) {
					return self::label((int) $key + 1, "slide-1", ["class" => "nav-item text-hide c-hand"]);
				}),
			])
		]);
	}

	public static function _carouselItem(string $back, string $next, $children, array $props = [])
	{
		$props["class"] = isset($props["class"])  ? $props["class"] . " carousel-item" : "carousel-item";
		return self::figure($props, [
			self::create_element("label", ["class" => "item-prev btn btn-action btn-lg", "for" => $back], [
				self::_icon("arrow-left")
			]),
			self::create_element("label", ["class" => "item-next btn btn-action btn-lg", "for" => $next], [
				self::_icon("arrow-right")
			]),
			$children
		]);
	}

	public static function _chip(string $text, array $children = [])
	{
		$subs = [$text];
		foreach ($children as $child) {
			$subs[] = $child;
		}
		return self::span(["wyn:chip" => ""], $subs);
	}

	public static function _container($children, array $props = [])
	{
		$props["class"] = isset($props["class"])  ? $props["class"] . " container" : "container";
		return self::div($props, $children);
	}

	public static function _emptyState(array $props)
	{
		if (isset($props["action"])) {
			$action = $props["action"];
			unset($props["action"]);
		}
		if (isset($props["icon"])) {
			$icon = $props["icon"];
			unset($props["icon"]);
		}
		$props["class"] = isset($props["class"])  ? $props["class"] . " empty" : "empty";
		return self::div($props, [
			isset($icon) ? self::div(["class" => "empty-icon"], [
				self::_icon($icon)
			]) : null,
			self::div(["class" => "empty-title h5"], $props["title"]),
			isset($props["subtitle"]) ? self::div(["class" => "empty-subtitle"], $props["subtitle"]) : null,
			isset($action) ? self::loop($action, function($child) {
				return self::div(["class" => "empty-action"], $child);
			}) : null
		]);
	}

	public static function _fab(array $props = ["icon" => "plus"])
	{
		$icon = "";
		$label = "";
		$prop["wyn:fab"] = "";
		if (isset($props["icon"])) {
			$icon = self::_icon($props["icon"]);
			unset($props["icon"]);
		}
		if (isset($props["label"])) {
			$label = $props["label"];
			unset($props["label"]);
		}
		$props["wyn:fab"] = "";
		return self::button($icon.$label, $props);
	}

	public static function _formGroup(array $children, array $props = [])
	{
		if (!isset($props["class"])) $props["class"] = "";
		$props["class"] .= " form-group";
		return self::div($props, $children);
	}

	public static function _formLabel(string $label, string $id = null, array $props = [])
	{
		if (!isset($props["class"])) $props["class"] = "";
		$props["class"] .= " form-label";
		return self::label($label, $id, $props);
	}

	public static function _formInput(string $type, string $name, array $props = [])
	{
		if (!isset($props["class"])) $props["class"] = "";
		$props["class"] .= " form-input";
		return self::input($type, $name, $props);
	}

	public static function _icon(string $icon, array $props = []) {
		$props["class"] = isset($props["class"])  ? "icon icon-$icon " . $props["class"] : "icon icon-$icon";
		if (isset($props["size"])) {
			$props["class"] .= " icon-{$props["size"]}";
			unset($props["size"]);
		}
		return self::i("", $props);
	}

	public static function _notify($children, array $props = [])
	{
		$props["class"] = isset($props["class"])  ? $props["class"] . " toast" : "toast";
		if (isset($props["variant"])) {
			$props["class"] .= " toast-{$props["variant"]}";
			unset($props["variant"]);
		}
		return self::div($props, $children);
	}

	public static function _text() {
		// implement text component
	}

	public static function _tile(array $props, array $children = [])
	{
		$props["class"] = isset($props["class"])  ? $props["class"] . " tile" : "tile";
		if (isset($props["icon"])) {
			$icon = $props["icon"];
			unset($props["icon"]);
		}
		if (isset($props["title"])) {
			$title = $props["title"];
			unset($props["title"]);
		}
		if (isset($props["subtitle"])) {
			$subs = $props["subtitle"];
			unset($props["subtitle"]);
		}
		if (isset($props["action"])) {
			$action = $props["action"];
			unset($props["action"]);
		}
		return self::div($props, (!isset($props["mode"]) || $props["mode"] == "manual") ? $children : [
			self::div(["class" => "tile-icon"], [
				isset($icon) ? $icon : null,
			]),
			self::div(["class" => "tile-content"], [
				self::_container([
					self::p($title, ["class" => "tile-title"]),
					isset($subs) ? self::p($subs, ["class" => "tile-subtitle"]) : null,
				])
			]),
			isset($action) ? self::div(["class" => "tile-action"], $action) : null,
		]);
	}

	public static function _xCard(array $props = [], array $options = ["title" => "Card"])
	{
		return self::_card($props, [
			isset($options["image"]) ? (self::div(["wyn:card-image" => ""], [
					self::img($options["image"], ["class" => "img-responsive", "alt" => " "])
				])) : null,
			self::div(["wyn:card-header" => ""], [
				self::div(["class" => "card-title h5"], $options["title"]),
				isset($options["subtitle"]) ? (self::div(["class" => "card-subtitle text-gray"], $options["subtitle"])) : null
			]),
			self::div(["wyn:card-body" => ""], $options["body"]),
			self::div(["wyn:card-footer" => ""], $options["footer"])
		]);
	}
}