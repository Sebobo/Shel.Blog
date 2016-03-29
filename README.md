# A simple blog for TYPO3 Neos based on typoscript and yaml configurations without php.

This is the blog package I'm developing for a few projects including my [blog](http://www.mind-the-seb.de).

## Build with Typoscript & Yaml

Almost all functions of this blog package are based on Typoscript and Yaml configurations. 
Just some php spice for sorting :)

## Installation

Install via composer

`composer require shel/blog`

You can overwrite and modify the different content elements to your needs.

For the route to the atom file to work you need to add the following to your `Routes.yaml` in Configuration:

	-
		name: 'Blog'
		uriPattern: '<BlogSubroutes>'
		subRoutes:
			'BlogSubroutes':
				package: 'Shel.Blog'


## Setup atom(xml)/html feed
 
After installation you have a new page type called `Blog feed`.
Add it to your site. For example in the page root and call it `Feed`.
Afterwards you can configure a few things in the inspector.

* `Entries to show` How many items should be shown at most.
* `Author` The author which will be included in the xml.
* `Page containing the blog entries` Here you should select the page which will contain your blog posts.
* `Description for the feed` A short description which will be included in the xml.

You should also check `Hide in menus` if you don't want the feed to be shown in your menu.

The xml version will use it's own rendering and most of the time you don't need to change anything there.
It will contain the full version of your posts including html. So images and everything.

The html version will use your default page template and replace the `mainContent` area with your blog posts.
This one doesn't show the `content` of the posts but only the `Title`, `Author`, `Date` and `Description`.
All fields are inline editable except the `Date` which makes it easy to modify your posts pretty fast!

## Features

* Atom feed support with the feed document type
* Latest blog entries content element
* Blog entry with it's own template and navigation elements
* Social buttons can be easily integrated
* Easily customizeable
