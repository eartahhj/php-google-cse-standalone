#  Standalone PHP version to use Google CSE with Custom Search API on your website
You can install the **Google Programmable Search Engine** (previously Google CSE) on your Website by including these files somewhere in your folders.

## Why do you need this?
The standard Custom Search Engine from Google will show **ads** on your search results. If you are selling products and someone searches for them on your website, ads from your competitors might appear. This of course is annoying for your business.

## What is the solution?
This tool will allow you to run Google's Custom Search API **without ads** on your search results. No ads means you can show only the stuff from your website.

## Wordpress plugin and theme files
If you are interested in using Google CSE on Wordpress, check out the Wordpress version here: https://github.com/eartahhj/wp-google-cse

## Important
You will need to **create a Search Engine on Google Programmable Search Engine**, and **activate an API Key on Google Cloud**. More info below.

## Warning
**This plugin is FREE** but **the Custom Search API from Google is NOT free**. It costs **5 euros per 1000 search queries**, but the first 100 queries of everyday will be free. You might need to activate a **payment method** on Google to use the API Key (Nothing I can do about it).
Info here: https://developers.google.com/custom-search/docs/paid_element

## How to install
1) Download the `php-google-cse-standalone` folder or get the latest release
2) Edit the `search.php` file and insert your **Search Engine ID** and **API Key** in the variables `$searchEngineId` and `$searchEngineApiKey`. There are also some other variables you can change if needed.
3) Inside `/CodingHouse/` you can find all the code that makes the engine work
4) Inside `/assets/` you can change stylesheets (css) and add javascript if needed, the `cse.css` and `cse.js` files are included in the example that you can find at `/search.php`
5) `/search.php` is just an example, you will most likely need only the PHP code and you can change the HTML code as you prefer based on your website template
6) You can also change the CSS as you like, the default you can find will give some basic style but of course you will need to adjust it on your preferences.

## Example
Let's suppose you add `search.php` to your website inside your `public_html` folder. You can remove the HTML you don't need and just keep the PHP that will generate some HTML for you.

If you have routes and/or RewriteRules, I guess you can just add `search.php` somewhere and configure your routes to call that file. If you need a MVC logic, you might want to move the php from `search.php` inside a **Controller** and then just make a new **View** with as less php code as possible. Your choice, do whatever you prefer.

## Modifying the default HTML
The HTML code is inside `/CodingHouse/GoogleCSE/html/` and you can change it as you like. Make it more accessible, change classes, whatever.
Of course, if you change the `html` you will need to change the `css` accordingly.

## Multiple languages engines
When you have multiple languages, my recommendation is to configure one Google Search Engine per each language. Otherwise, you can configure just one engine to search in all your website.
It will be easier if your website is divided in languages by url (/en, /de, /it, etc.). If you use some javascript to change the language, I don't have a javascript version of the engine ready right now, I might make one in the future.

Anyway, to use multiple languages, when you have one way to establish the current language, you could make something like this example:

$language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
$searchEngineIds = ['en' => 'loremipsum', 'de' => 'dolorsit'];
$searchEngineId = \CodingHouse\GoogleCSE\GoogleCustomSearchEngine::getSearchEngineIdByLanguage($language, $searchEngineIds);

The `getSearchEngineIdByLanguage()` function is just a helper method defined in `GoogleCustomSearchEngine.php`

## How it works
Basically it will use the API Key to connect to Google's Custom Search API and it will use the Custom Search Engine ID to show search results from the pages of your websites that are indexed by Google.
Note: it will only show pages that have been indexed. Do not expect to see results from your website if it is being "noindexed" or if it is still not on Google.

The **PHP class** will take care of **sending the request to Google** and get a **JSON response**. It will handle this response and output it in your search results page.

See below how to obtain the API Key and the ID.

## How do I index my website on Google?
Have a look at **Google Search Console** (https://search.google.com/search-console/) and add your website there. Make sure your website can be crawled. If it is configured with "noindex" (common mistake on Wordpress websites) it will not be indexed, so no search results will be shown.

## How to get a Search Engine ID
You need to **create a new Search Engine** on https://programmablesearchengine.google.com/. After setting up the engine, you will receive an ID for it (once called CX).

## How to get an API Key
1) Head to https://cloud.google.com/ and create an account
2) Go to the console and create a new project if needed
3) Go to API and Services > Enable APIs and Services and enable the Custom Search API
4) Go to Credentials
5) On the top, click on Create Credentials > API Key. A dialog window will appear with your API Key. Copy it and configure it on the plugin settings page or in the code (read above How to install)
6) You will see a warning triangle near your API Key on Google Cloud, because the key is not restricted. You can protect it by clicking on the API Key's name, and under API Restrictions you will choose "Restrict key" and select only Custom Search API from the dropdown. You can select other APIs if you are using others with the same key. Click on Save.

Google's Custom Search API full documentation can be found here: https://developers.google.com/custom-search/docs/tutorial/introduction

## Promoted results
In Google CSE you can set promoted results to show before your normal results. Basically these are results that you want to highlight and are triggered by some defined keywords.
Let's say you want to show a specific page for the shoes you are selling: you can set some keywords triggers like "shoes", "men shoes", "red shoes" and show a specific URL for those. It will appear like a normal result, but will come out on top.

By default, promoted results are shown on top. In case you want to show promoted results on bottom, just switch the order of `renderNormalResults` and `renderPromoResults`.

You can remove  or comment `renderPromoResults` if you don't plan to use them.

## Pager
The pager works up to 10 pages (the API will show a maximum of 100 results).
In some cases, you might see a different number of results for the same search terms.
This is normal because Google indexes and renders results differently each time, so don't worry about it.
At times you might click page number 8 and when the page reloads you will see there are actually only 5 pages. This still depends on the results from Google, it is not a bug of this library.
