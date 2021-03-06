Flickr Shortcodes
===========================

There are a few shortcodes that come standard with the Flickr module. You can place them in any content field that has formatting (bold, italics, links, etc).

Flickr
------
Basic Usage:
* `[flickr set="xxxxxxx" /]`
* `[flickr tag="xxxxxxx" /]`
* `[flickr photo="xxxxxx" /]`

### Sets and Tags
You can show sets on a page a few different ways as long as the set is publically viewable:

#### Galleries (default)
Galleries just lay out all of the photos (in a set) on the page in a one or multi column layout.
* `[flickr set="xxxxxxx" /]` - Displays a Flickr set in a single column gallery.
* `[flickr set="xxxxxxx" columns="2" /]` - Displays a Flickr set in a two column gallery.

* `[flickr tag="xxxxxxx" /]` - Displays a Flickr tag search (for the Flickr User defined in _ss_environment ONLY) in a single column gallery.
* `[flickr tag="xxxxxxx" columns="2" /]` - Displays a Flickr tag search in a two column gallery.

#### Slideshows
Slideshows or sliders show the photos in one, single block, moving left or right.
* `[flickr set="xxxxxxx" type="slideshow" /]` - Displays a Flickr set in a single column
* `[flickr tag="xxxxxxx" type="slideshow" /]` - Displays a Flickr tag search in a single column

## Grid (experimental)
Grids can be two (default) or three columns and attempts to lay out variable height/width images in a way that looks nice. Still working on this
* `[flickr set="xxxxxxx" type="grid" columns="2" /]` - Displays a Flickr set in a two column grid, every fifth image is full width.
* `[flickr set="xxxxxxx" type="grid" columns="3" /]` - Displays a Flickr set in a three column grid, every fourth image is full width.

### Single Photos
* `[flickr photo="xxxxxx" /]`
