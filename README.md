# A simple configurable blog/news plugin for Neos CMS

I developed this blog package for several projects including my own [blog](http://www.mind-the-seb.de).

## Build with TypoScript & Yaml

Almost all functions of this blog package are based on Typoscript and Yaml configurations. 
Just some php spice for sorting :)
So it's very easy to extend and adapt to your needs.

## Installation

Install via composer

`composer require shel/blog`

You can overwrite and modify the different content elements to your needs:

* `Shel.Blog:BlogEntry` - A single blog post
* `Shel.Blog:BlogFeed` - The container for blog entries which also works as archive and atom feed
* `Shel.Blog:LatestBlogEntries` - Renders a sorted list of blog posts for example on your homepage 

## Setup a new feed
 
After installation you have a new page type called `Blog feed`.
Add it to your site. For example in the site root and call it `Feed`.
Afterwards you can configure a few things in the inspector.

* `Entries to show` How many items should be shown at most.
* `Author` The author which will be included in the xml.
* `Description for the feed` A short description which will be included in the xml.

### Html content

The html version will use your default page template and replace the `mainContent` area with your blog posts.
All fields are inline editable except the `publication date` which makes it easy to modify your posts pretty fast!

Each blog post includes a paging widget which allows you to navigate to the next/previous blog posts.

### Atom/Xml feed 

The atom/xml version will use it's own rendering and most of the time you don't need to change anything there.
It will contain the full version of your posts including html. So images and everything.
All active feeds will automatically be linked in the html header as meta tags.

#### Routing

For the route to the atom feeds to work you need to add the following to your `Routes.yaml` in Configuration:

	-
		name: 'Blog'
		uriPattern: '<BlogSubroutes>'
		subRoutes:
			'BlogSubroutes':
				package: 'Shel.Blog'

## Features

* Atom feed support with the feed document type
* Content element showing latest blog entries
* Blog entry with it's own template and navigation elements
* Social buttons for twitter and flattr can be configured
* Disqus integration
* Easily customizeable

## You found a problem or have ideas for improvements?

Fork this project at github and create a pull request :)
If you are not a developer, create an issue and tell me about your thoughts!
