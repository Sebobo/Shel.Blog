# A simple configurable blog/news plugin for Neos CMS with AMP support                                

[![Latest Stable Version](https://poser.pugx.org/shel/blog/v/stable)](https://packagist.org/packages/shel/blog)
[![Total Downloads](https://poser.pugx.org/shel/blog/downloads)](https://packagist.org/packages/shel/blog)
[![License](https://poser.pugx.org/shel/blog/license)](https://packagist.org/packages/shel/blog)

I developed this blog package for several projects including my own [blog](http://www.mind-the-seb.de).

## Build with Fusion & AFX & YAML

Almost all features of this blog package are based on Fusion, AFX and YAML configurations. 
So it's very easy to extend and adapt to your needs.

## Installation

Add the dependency to your site package like this

    `composer require --no-update shel/blog`
    
And then run `composer update` in your projects root folder.

You can overwrite and modify the different content elements to your needs:

* `Shel.Blog:Document.Article` - A single blog post
* `Shel.Blog:Document.Feed` - The container for blog entries which also works as archive and atom feed
* `Shel.Blog:Document.Category` - A category (or tag) which can be referenced by articles and also renders a feed 
* `Shel.Blog:Content.LatestArticles` - Renders a sorted list of blog posts for example on your homepage
* `Shel.Blog:Constraint.Article` - Mixin to allow content types to be added to articles

### Upgrade from version 2.x or 3.x

A lot of prototypes and documents were refactored and therefore this upgrade will break your site.
The new structure tries to use the most recent best practices for Neos CMS and allows you to easily
override many parts of the rendering. 

But there is a node migration to update your nodes. Run it like this after installation:

    ./flow node:migrate 20190214140619
    
Blog feeds and categories also received a new content area for introduction texts (SEO!). 
Add them by running this: 
       
    ./flow node:repair  
    
But if you did an override on any prototype in your own package you should adapt the naming and structure.

The integrated support for `flattr` and `disqus` was removed. If you still need it, please add it yourself.

There is a new constraint mixin to determine which kind of elements are allowed in a blog article.
This change might change the behavior in your site, so you should add `'Shel.Blog:Constraint.Article': true` as
supertype to the content types you want to have available.

## Setup a new feed
 
After installation you have a new page type called `Blog feed`.
Add it to your site. For example in the site root and call it `Feed`.
Afterwards you can configure a few things in the inspector.

* `Entries to show` How many items should be shown at most.
* `Author` The author which will be included in the xml.
* `Description for the feed` A short description which will be included in the xml.

### Configure allowed content types

By default the blog article allows most elements defined in `Neos.NodeTypes`.
To add your own types, add `'Shel.Blog:Constraint.Article': true` as supertype to them.

The reason for this is that there might come new elements via plugins that don't work well
with the blog in standard or AMP mode.

Therefore you should make sure that those elements work well there.

### Html content

The html version will use your default page template and replace the `mainContent` area with your blog articles.
All fields are inline editable except the `publication date` which makes it easy to modify your articles pretty fast!

Each blog article includes a paging widget which allows you to navigate to the next/previous blog articles.

### Atom/Xml feed 

The atom/xml version will use it's own rendering and most of the time you don't need to change anything there.
It will contain the full version of your articles including html. So images and everything.
All active feeds will automatically be linked in the html header as meta tags.

### AMP rendering

As AMP itself is still work in progress, this feature is also work in progress.
This package tries to provide a good defaults you can start with and customize it for your needs.
As everything is written in Fusion, you can override and change anything you want.

After you put some blog articles online with the help of this package, Google should be able to find the AMP 
versions of each blog article after a few hours or days and provide the AMP version in it's search results.

Each blog article automatically includes a link in the `head` to it's AMP version.
The package includes a default css for the AMP version and renders the primary content area.

If you have additional custom content elements in a blog article like videos and other stuff
you might need to provide processors to make them compatible with AMP. 
See the `replaceImgTags` image processor as example.

Please test the AMP version every time you add new features to your blog pages!
Also be sure to check Google Search Console on your live site as it will inform you of errors.

Pull request with improvements to this feature are very welcome!

#### Customizing

The site is rendered as an array in `Shel.Blog:Layout.AmpPage` the object.
It contains a content object in it's body section which is an array you can override and extend with additional content.
By default provides basic layout components such as header, breadcrumb, blog content and pagination.

In the stylesheets section a basic css file included with this package is added inline. 
See the `Shel.Blog:Component.AmpStyles` object.
Replace it or add another stylesheet to modify the output. Remember the styles need to be inline for AMP.

Don't add additional your usual javascripts as this is not supported currently with AMP.

Check out https://www.ampproject.org/docs/get_started/create to learn more on how to get started with AMP.

#### Debugging

Verify the output of your blog with the developer mode for AMP by loading the AMP version and 
adding `#development=1` to the url.
Open the developer tools of your browser and AMP will show you it's verification result.    

Other plugins and packages you might have installed might break the AMP compatibility!
Please validate the rendered code by using the browser validator or any other method 
described [here](https://www.ampproject.org/docs/fundamentals/validate).

Before you create an issue for the AMP mode please run the validation and add the result to the issue.

#### Turning of AMP rendering mode

You can turn this off with this fusion script:

    root.shelBlogArticleAmp >
    prototype(Neos.Neos:Page).head.ampLink >

#### Routing

The routes for the sitemap and pagination are auto-included in the `Settings.yaml`.

## Features

* Atom feed support with the feed document type
* Content element showing latest blog entries
* Blog articles with their own template and navigation elements
* Categories to group articles
* Social buttons for twitter and facebook can be configured
* Easily customizeable
* AMP support for individual blog articles

## You found a problem or have ideas for improvements?

Fork this project at github and create a pull request :)
If you are not a developer, create an issue and tell me about your thoughts!
