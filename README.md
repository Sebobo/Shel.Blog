# A simple blog for TYPO3 Neos based on typoscript and yaml configurations without php.

This is the blog package I'm developing for a few projects including my [blog](http://www.mind-the-seb.de).

I will improve the documentation soon.

## Build with Typoscript & Yaml

All functions of this blog package are based on Typoscript and yaml configurations.

## Installation

Install via composer

`composer install sebastianhelzle/blog --save`

Include typoscript in your Root.ts2

`include: resource://SebastianHelzle.Blog/Private/TypoScripts/Library/Root.ts2`

You can overwrite and modify the different content elements to your needs.

## Features

* Atom feed support with the feed document type
* Latest blog entries content element
* Blog entry with it's own template and navigation elements
