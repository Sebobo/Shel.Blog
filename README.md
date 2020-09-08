# A simple configurable blog/news plugin for Neos CMS with AMP support                                

[![Latest Stable Version](https://poser.pugx.org/shel/blog/v/stable)](https://packagist.org/packages/shel/blog)
[![Total Downloads](https://poser.pugx.org/shel/blog/downloads)](https://packagist.org/packages/shel/blog)
[![License](https://poser.pugx.org/shel/blog/license)](https://packagist.org/packages/shel/blog)

I developed this blog package for several projects including my own [blog](http://www.mind-the-seb.de).

## Built with Fusion & AFX & YAML

Almost all features of this blog package are based on Fusion, AFX and YAML configurations. 
So it's very easy to extend and adapt to your needs.   

## Features

* Each blog feed has its own Atom feed
* Content element showing latest blog entries
* Blog articles with their own template and navigation elements
* Categories to group articles, optionally with their own feeds
* Social buttons for Twitter and Facebook which can be extended
* Easily customizeable
* AMP support for individual blog articles

### Coming up

* Author pages which can be referenced in articles (optional)
* Make AMP styles more customizable and integrate https://www.ampstart.com/templates#news-blog by default

## Installation

Add the dependency to your site package like this

    composer require --no-update shel/blog
    
And then run `composer update` in your project's root folder.

You can overwrite and modify the different content elements to your needs:

* `Shel.Blog:Document.Article` - A single blog post
* `Shel.Blog:Document.Feed` - The container for blog entries which also works as archive and Atom feed
* `Shel.Blog:Document.Category` - A category (or tag) which can be referenced by articles and also renders a feed 
* `Shel.Blog:Content.LatestArticles` - Renders a sorted list of blog posts, for example on your homepage
* `Shel.Blog:Constraint.Article` - Mixin to allow content types to be added to articles

### Upgrade from version 2.x or 3.x

A lot of prototypes and documents were refactored and therefore this upgrade will break your site.
The new structure tries to use the most recent best practices for Neos CMS and allows you to easily
override many parts of the rendering. 

But there is a node migration to update your nodes. Run it like this after updating:

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
Add it to your site - for example in the site root - and call it `Feed`.
Afterwards you can configure a few things in the inspector.

* `Entries to show` How many items should be shown at most.
* `Author` The author which will be included in the xml.
* `Description for the feed` A short description which will be included in the xml.

### Setup page rendering

By default the `Feed`, `Category` and `Article` document types will inherit their rendering from `Neos.Neos:Page`.
So if you extended this prototype in your own site package, the rendering should work fine as this
package will override the `Neos.Neos:PrimaryContent` prototype which most projects use to render the main content area.
This way the blog will render its own content where you usually have your main content.

If not you might get an error like `No template path set. ...`.
Then you have to tell the package which document prototype it should use as basis.

For the `Neos.Demo` site package it would look like this:

    prototype(Shel.Blog:Document.GenericBlogPage) < prototype(Neos.NodeTypes:Page)
  
This way, the feed, category and article document types will know how to render.
Of course you can also give each of their prototypes a different parent prototype instead of the `GenericBlogPage`.

That would look like this:

    prototype(Shel.Blog:Document.Feed) < prototype(My.Package:MyFeedPage) 
    prototype(Shel.Blog:Document.Article) < prototype(My.Package:MyArticlePage) 
    
Changing the parent prototype of `Feed` will also change the one for `Category` as it inherits from `Feed`.
    
Remember that you need to render the `Neos.Neos:PrimaryContent` object somewhere to get output. 

### Configure allowed content types

By default the blog article allows most elements defined in `Neos.NodeTypes`.
To add your own types, add `'Shel.Blog:Constraint.Article': true` as supertype to them.

The reason for this is that there might come new elements via plugins that don't work well
with the blog in standard or AMP mode.

Therefore you should make sure that those elements work well there.

### HTML content

The HTML version will use your default page template and replace the `mainContent` area with your blog articles.
All fields are inline editable except the `publication date` which makes it easy to modify your articles pretty fast!

Each blog article includes a paging widget which allows you to navigate to the next/previous blog articles.

### Atom/XML feed 

The Atom/XML version will use its own rendering and most of the time you don't need to change anything there.
It will contain the full version of your articles including HTML. So images and everything.
All active pages of type `Shel.Blog:Document.Feed` will automatically be linked in the HTML header as meta tags.

Category pages can work the same but their feed link is hidden by default.
You can enable this by unchecking `Hide feed link` in the categories inspector options. 

### AMP rendering

As AMP itself is still work in progress, this feature is also work in progress.
This package tries to provide good defaults you can start with and customize to your needs.
As everything is written in Fusion, you can override and change anything you want.

After you publish some blog articles with the help of this package, Google should be able to find the AMP 
versions of each article after a few hours or days and provide the AMP version in its search results.

Each blog article automatically includes a link in the `head` to its AMP version.
The package includes a default CSS for the AMP version and renders the primary content area.

If you have additional custom content elements in a blog article like videos and other stuff
you might need to provide processors to make them compatible with AMP. 
See the `replaceImgTags` image processor as example.

If you have installed the neos/googleanalytics package aside with shel/blog all analytics tags will be diabled to be AMP confirmative.  
You could add a tag manager with

```yaml
Shel:
  Blog:
    analytics:
      tagManager:
        id: <gtm tag manager id>
```

Please test the AMP version every time you add new features to your blog pages!
Also be sure to check Google Search Console on your live site as it will inform you of errors.

Pull request with improvements to this feature are very welcome!

#### Customizing

The site is rendered as an array in the `Shel.Blog:Layout.AmpPage` object.
It contains a content object in its body section which is an array you can override and extend with additional content.
By default it provides basic layout components such as header, breadcrumb, blog content and pagination.

In the stylesheets section a basic CSS file provided by this package is added inline; see the `Shel.Blog:Component.AmpStyles` object.
Replace it or add another stylesheet to modify the output. Remember that the styles need to be inline for AMP.

Don't add additional JavaScript as this is currently not supported with AMP.

Check out https://www.ampproject.org/docs/get_started/create to learn more on how to get started with AMP.

#### Debugging

Verify the output of your blog with the developer mode for AMP by loading the AMP version and 
adding `#development=1` to the url.
Open the developer tools of your browser and AMP will show you its verification result.    

Other plugins and packages you might have installed might break AMP compatibility!
Please validate the rendered code by using the browser validator or any other method 
described [here](https://www.ampproject.org/docs/fundamentals/validate).

Before you create an issue for the AMP mode please run the validation and add the result to the issue.

#### Turning off AMP rendering mode

You can turn this off with this fusion script:

    root.shelBlogArticleAmp >
    prototype(Neos.Neos:Page).head.ampLink >

#### Routing

The routes for the sitemap and pagination are auto-included in the `Settings.yaml`.

## You found a problem or have ideas for improvements?

Fork this project at GitHub and create a pull request :)
If you are not a developer, create an issue and tell me about your thoughts!
