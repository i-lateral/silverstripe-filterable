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

To be able to add filters to your objects, add the following to your
_config.php

    Filterable::add("YourObjectName", "RelationName");

* YourObjectName is the name of the object you want to add filters to.
* RelationName is the name of the relation added to the FilterOption
object (for example, "Products").
