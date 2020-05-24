# Leaf UI: Wynter Components

Leaf UI is a PHP library for building user interfaces.

This package combines the base wynter UI with Wynter CSS, in order to use Wynter CSS based components.

Wynter CSS is a CSS Framework (work-in-progress) based on [spectre CSS](https://picturepan2.github.io/spectre/). So, with Leaf UI - Wynter Components, you can build your amazing frontends without any additional CSS or Javascript.

## Basic Usage

Since Leaf UI deals with static components, there's no need to initialise the class if you don't want to. So we simply call:

```php
Leaf\UI\WynterCSS::component();

# or

use Leaf\UI\WynterCSS as UI;

UI::component();

# or

$ui = new Leaf\UI\WynterCSS;

$ui::component();
```

After this, you can use any Wynter component.

**Note that** since `Leaf\UI\WynterCSS` is still Leaf UI, you should familiarize yourself with Leaf UI base first, though not compulsory, this is recommended.

## Wynter Components

This is a basic guide to the components prepared for you. Since these are all custom components, they start with `_`. This is not a compulsory naming convention for custom components, but it's adviced.

### render

Render just like the base `render` method renders a Leaf UI. However, unlike the default render, wynter css' render method attaches links to wynter css files. It takes in 2 parameters:

- The Leaf UI to render
- A string to render before the Leaf UI

```php
$ui::render($ui::p("This is a paragraph"), "Something here");
```

### _avatar

This is renders a wynter css based avatar component. It takes in 4 params

- An image, if available
- A text avatar placeholder (optional, string), used when image is loading or unavailable
- Avatar props (optional, array)
- Children, if any (optional, array)

```php
$ui::_avatar("./image.jpg");
$ui::_avatar("./image.jpg", "MD");
$ui::_avatar("", "MD");
```

_avatar also takes in special props which add extra functionality to the avatar.

- size: The size of the avatar. Available values (xs, sm, md, lg, xl)
- presence: Adds an "online indicator" to avatar. Available values (away, online, offline, busy)
- badge: Adds a badge to avatar.

```php
$ui::_avatar("", "MD", ["size" => "xl", "presence" => "away", "badge" => "700"]);
```

### _badge

This renders a badge component. It takes in 3 params:

- The badge text
- Badge properties (optional, array)
- Badge Children (optional, array|string)

```php
$ui::_badge("8000", [], "Notifications");
```

### _bars

Bars work together with the `_bar` component to create "progress bars".

```php
$ui::_bars([
	$ui::_bar(["value" => "25", "tooltip" => "25"])
]);
```

_bars also takes in a special `variant` prop which allows you to configure the progress bars nested in it.

```php
$ui::_bars([
	$ui::_bar(["value" => "25", "tooltip" => "25"])
], ["variant" => "sm"]); // creates a small progress bar
```

### _bar

This creates a progress bar and is nested inside the `_bars` component. You can add multiple bars inside the `_bars` to create a segmented progress bar.

`_bar` takes in special props which allow you to configure the progress bar in which ever way you want.

- value: This shows the current point of the progress bar
- tooltip: This shows a tooltip
- min: the minimum value
- max: the maximum value
- show-value: Whether to show the value inside the progressbar

```php
$ui::_bars([
	$ui::_bar(["value" => "25", "tooltip" => "25"]),
	$ui::_bar(["value" => "25", "tooltip" => "25", "style" => "background: grey;", "show-value" => true]),
	$ui::_bar(["value" => "40", "style" => "background: gold;", "show-value" => true]),
]),
```

### _breadcrumb

This creates breadcrumbs. It takes in just one param:

- A key value array of values and their links

```php
$ui::_breadcrumb([
	"profile" => "/profile", 
	"settings" => "/profile/settings",
	"security" => "/profile/settings/security"
])
```

### _button

This creates a default wynter css based button. It takes in 2 parameters:

- The button text
- Button props

_button also takes in a variant prop which allows easy customization. Accepted values are:

Variations:

- primary
- link
- success
- error
- action

Sizes:

- block
- sm
- lg

```php
$ui::_button("Primary Button", ["variant" => "primary"]);
$ui::_button("Primary Button", ["variant" => "sm"]);
$ui::_button("Primary Button", ["variant" => "block"]);
```

### _btnGroup

This creates a container to merge buttons together.

```php
$ui::_btnGroup([
	$ui::_button("Button 1"),
	$ui::_button("Button 2"),
	$ui::_button("Button 3"),
	$ui::_button("Button 4"),
]);
```

### _card

This creates a simple card surface. It takes in 2 parameters:

- Props for card
- Card children

```php
$ui::_card([], [
	$ui::_container([
		$ui::div([], "Something Interesting")
	])
]);
```

Checkout [_xCard](?id=_xCard) for an "automated" version.

### _carousel

This is a bit more complicated than the components we've seen before. It creates a simple carousel slider. It takes in 3 parameters:

- Carousel children (array)
- Carousel items ids: in order (array). By default, `["slide-1", "slide-2", "slide-3", "slide-4"]` is used.
- Any additional props

```php
$ui::_carousel([
	$ui::_carouselItem("slide-4", "slide-2", $ui::img("./1.jpg")),
	$ui::_carouselItem("slide-1", "slide-3", $ui::img("./2.jpg")),
	$ui::_carouselItem("slide-2", "slide-4", $ui::img("./1.jpg")),
	$ui::_carouselItem("slide-3", "slide-1", $ui::img("./2.jpg")),
]);
```

### _carouselItem

Carousel item as the name suggests is the item in a carousel. It takes in 4 params:

- The id of the slide to go to when back button is pressed
- The id of the slide to go to when forward button is pressed
- carousel item children (element)
- props for carousel item (array, optional)

```php
$ui::_carouselItem("slide-3", "slide-1", $ui::img("./2.jpg"), ["style" => "width: 100%"]);
```

### _chip

This component returns a wynter css chip. It takes in 2 parameters:

- Chip text
- Children

```php
$ui::_chip("Something");
```

You can use `btn-clear` to create a closeable chip

```php
$ui::_chip("Food", [
	$ui::a(["href" => "#", "wyn:btn-clear" => "", "aria-label" => "Close", "role" => "button"])
]);
```

### _container

Container creates a little "breathing space" for your components. It takes in 2 params:

- Children
- Props (array, optional)

```php
$ui::_container([
	$ui::div([], "Something Interesting")
], ["style" => "background: gold;"]);
```

### _emptyState

This creates an empty state layout. It takes in only one param:

- (array) properties of the empty state

```php
$ui::_emptyState([
	"icon" => "mail icon-3x",
	"title" => "You have no new messages",
	"subtitle" => "Click the button to start a conversation",
	"action" => [
		$ui::_button("Send a message", ["variant" => "primary"])
	]
]);
```

### _fab

This creates a simple fab

```php
$ui::_fab(["icon" => "people"]);
```

### _icon

This creates a css icon. It takes in 2 params:

- The icon to use "string"
- Props for the icon (array, optional)

```php
$ui::_icon("people");
```

### _notify

Creates a beautiful "toast" notification. It takes in 2 parameters:

- Notification text/children
- Notification props

```php
$ui::_notify("Lorem ipsum dolor sit amet, consectetur adipiscing elit.");
$ui::_notify([
	$ui::_button("", ["class" => "btn-clear float-right"]),
	$ui::h6("A Short Title"),
	$ui::p("Lorem ipsum dolor sit amet, consectetur adipiscing elit."),
]);
$ui::_notify("Lorem ipsum dolor sit amet.", ["variant" => "primary"]);
```

### _tile

Creates a wynter css tile component. It takes in 2 params:

- props (array)
- children

```php
$ui::_tile([
	"mode" => "auto",
	"icon" => $ui::_avatar("./1.jpg", "", ["size" => "xl"]),
	"title" => "The Avengers",
	"subtitle" => "Earth's Mightiest Heroes joined forces to take on threats that were too big for any one hero to tackle...",
	"action" => $ui::_btnGroup([
		$ui::_button("Join Us", ["variant" => "primary"]),
		$ui::_button("View Us"),
	])
]);
```

### _xCard

This creates a card component, but unlike `_card`, `_xCard` literally does everything for you and takes in special props to create your card.

```php
$ui::_xCard(["style" => "width: 300px"], [
	"image" => "./1.jpg",
	"title" => "Something",
	"subtitle" => "Subtitle",
	"body" => "Lorem ipsum, dolor sit amet consectetur adipisicing elit.",
	"footer" => $ui::div([], [
		$ui::_button("Button", ["variant" => "primary"])
	]),
]);
```

**WORK IN PROGRESS:** Bothe the docs and wynter components are still being written.
