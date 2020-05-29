<?php
require "./src/UI.php";
require "./src/UI/Template.php";
require "./src/UI/WynterCSS.php";
require "./src/UI/WynterCSS/Template.php";

$ui = new \Leaf\UI\WynterCSS\Template;

$html = $ui::_scaffold([
    "name" => "Application",
    "nav-links" => [
        "Home" => "/",
        "About Us" => "/about",
        "Contact Us" => "/contact",
    ]
]);

\Leaf\UI::render($html);
