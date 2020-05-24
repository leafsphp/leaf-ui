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
