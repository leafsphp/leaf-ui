<?php
require "./src/UI.php";
require "./src/UI/Template.php";
require "./src/UI/WynterCSS.php";

// $ui = new Leaf\UI;

// $ui::render((
// 	$ui::body([
// 		$ui::h2("This is h2")
// 	])
// ));

// $ui = new \Leaf\UI\Template;

// $arr = [
// 	["name" => "Michael"],
// 	["name" => "Seth"],
// 	["name" => "Mychi"],
// 	["name" => "Darko"],
// 	["name" => "Duodu"]
// ];

// $c = 3;

// $ui::render((
// 	$ui::_template("Title Here", [
// 		$ui::_row([
// 			$ui::loop($arr, function($value) use($ui, $c) {
// 				return (
// 					$ui::div([], [
// 						$ui::h2($value["name"]),
// 						$ui::p("Something Really Interesting"),
// 						$ui::if($c == 2, (
// 							$ui::div([], "This is an if statement")
// 						), $ui::unless($c == 3, (
// 							$ui::div([], "This is an else if block")
// 						), (
// 							$ui::div([], "This is the else block")
// 						))),
// 						$ui::button("Click Me!!")
// 					])
// 				);
// 			}),
// 		]),
// 	])
// ));

$ui = new Leaf\UI\WynterCSS;

$html = $ui::body([
	$ui::_preloader($ui::h2("Loading...")),
	$ui::_container([
		$ui::h2("Avatar"),
		$ui::_avatar("", "MD", ["size" => "xl", "presence" => "away", "badge" => "700"]),
		$ui::hr(),
		$ui::h2("Badge"),
		$ui::_badge("8000", [], "Notifications"),
		$ui::hr(),
		$ui::h2("Breadcrumb"),
		$ui::_breadcrumb([
			"profile" => "/profile", 
			"settings" => "/profile/settings",
			"security" => "/profile/settings/security"
		]),
		$ui::hr(),
		$ui::h2("Buttons"),
		$ui::_button("Wynter Button", ["wyn:loading" => "true"]),
		$ui::_button("Primary Button", ["variant" => "primary"]),
		$ui::_button("Link Button", ["variant" => "link"]),
		$ui::_btnGroup([
			$ui::_button("Button 1"),
			$ui::_button("Button 2"),
			$ui::_button("Button 3"),
			$ui::_button("Button 4"),
		]),
		$ui::_fab(["icon" => "people"]),
		$ui::hr(),
		$ui::h2("Cards"),
		$ui::_card([], [
			$ui::_container([
				$ui::div([], "Something Interesting")
			])
		]),
		$ui::_xCard(["style" => "width: 300px"], [
			"image" => "./1.jpg",
			"title" => "Something",
			"subtitle" => "Subtitle",
			"body" => "Lorem ipsum, dolor sit amet consectetur adipisicing elit. Doloribus ratione cupiditate officia animi itaque esse saepe et officiis possimus dolorem, a architecto facere veritatis adipisci sed eos aliquam alias vitae.",
			"footer" => $ui::div([], [
				$ui::_button("Button", ["variant" => "primary"])
			]),
		]),
		$ui::hr(),
		$ui::h2("Chips"),
		$ui::_chip("Something"),
		$ui::_chip("Food", [
			$ui::a(["href" => "#", "wyn:btn-clear" => "", "aria-label" => "Close", "role" => "button"])
		]),
		$ui::hr(),
		$ui::h2("Carousel"),
		$ui::_carousel([
			$ui::_carouselItem("slide-4", "slide-2", $ui::img("./1.jpg", ["style" => "width: 100%;height: 100% !important;"])),
			$ui::_carouselItem("slide-1", "slide-3", $ui::img("./2.jpg", ["style" => "width: 100%;height: 100% !important;"])),
			$ui::_carouselItem("slide-2", "slide-4", $ui::img("./1.jpg", ["style" => "width: 100%;height: 100% !important;"])),
			$ui::_carouselItem("slide-3", "slide-1", $ui::img("./2.jpg", ["style" => "width: 100%;height: 100% !important;"])),
		]),
		$ui::hr(),
		$ui::h2("Bars"),
		$ui::_bars([
			$ui::_bar(["value" => "25", "tooltip" => "25"]),
			$ui::_bar(["value" => "25", "tooltip" => "25", "style" => "background: grey;", "show-value" => true]),
			$ui::_bar(["value" => "40", "style" => "background: gold;", "show-value" => true]),
		]),
		$ui::hr(),
		$ui::h2("Empty States"),
		$ui::_emptyState([
			"icon" => "mail icon-3x",
			"title" => "You have no new messages",
			"subtitle" => "Click the button to start a conversation",
			"action" => [
				$ui::_button("Send a message", ["variant" => "primary"])
			]
		]),
		$ui::hr(),
		$ui::h2("Notifications"),
		$ui::_notify("Lorem ipsum dolor sit amet, consectetur adipiscing elit."),
		$ui::_notify([
			$ui::_button("", ["class" => "btn-clear float-right"]),
			$ui::h6("A Short Title"),
			$ui::p("Lorem ipsum dolor sit amet, consectetur adipiscing elit."),
		]),
		$ui::_notify("Lorem ipsum dolor sit amet, consectetur adipiscing elit.", ["variant" => "primary"]),
		$ui::hr(),
		$ui::h2("Tiles"),
		$ui::_tile([
			"mode" => "auto",
			"icon" => $ui::_avatar("./1.jpg", "", ["size" => "xl"]),
			"title" => "The Avengers",
			"subtitle" => "Earth's Mightiest Heroes joined forces to take on threats that were too big for any one hero to tackle...",
			"action" => $ui::_btnGroup([
				$ui::_button("Join Us", ["variant" => "primary"]),
				$ui::_button("View Us"),
			])
		]),
		$ui::br(),
		$ui::br(),
		$ui::_row([
			$ui::_formGroup([
				$ui::_formLabel("Name", "idxxname"),
				$ui::_formInput("text", "name", ["id" => "idxxname"])
			]),
			$ui::_formTextarea("description", [
				"placeholder" => "Description"
			]),
			$ui::_formSelect([
				"btc" => "Bitcoin",
				"eth" => "Ethereum"
			]),
			$ui::_colourPicker(),
			$ui::_datePicker(),
		])
	])
]);

$ui::render($html);
