Silverstripe Filterable
=======================

Module to allow creation of "Filters" that can be mapped to data
objects.

The idea is that we then add ability to render these filters to front
end templates and (eventually) add them to search results.

At the moment, only the backend mapping is supported by the module,
front-end support comming soon...

## Author

This module is created and maintained by
[ilateral](http://www.i-lateral.com)

Contact: morven@i-lateral.com

## Dependancies

* SilverStripe Framework 3.1.x
* [Grid Field Extensions](https://github.com/ajshort/silverstripe-gridfieldextensions)

## Installation

Install this module either by downloading and adding to:

[silverstripe-root]/filterable

Then run: dev/build/?flush=all

Or alternativly add to your project's composer.json

## Usage

Once installed, you can setup filters via the "Filters" tab in the CMS.

### Mapping to objects

To be able to add filters to your objects, add the following to your
_config.php

    Filterable::add("YourObjectName", "RelationName");

* YourObjectName is the name of the object you want to add filters to.
* RelationName is the name of the relation added to the FilterOption
object (for example, "Products").

### Filtering on a controller

To be able to see a list of filtered objects from a controller, you need
to add *FilterableController* to your controller classes. You can do
this in either of the standard ways:

Via config.yml

    YourController:
      extensions:
        - FilterableController

Via _config.php

    YouController::add_extension("FilterableController");

Once a controller has been extended, it gains access to a "FilterMenu"
and a "filterby" action.

### Filter Menu

The Filter Menu can be loaded into a template using the template
variable:

    $FilterMenu

This generates a menu of available filters and options

### Filter By

The "filterby" action returns a result set of objects, based on the
relations you stipulate via *Filterable::add()*.

These results are rendered into a template, you can overwrite this
template in several ways.

1. Create a template called *YourClassName_filterby.ss* in your Layout
This will allow you to create several different styled filters,
depending on the controller.

2. Create a template called *FilterBy.ss* in your Layout directory.
