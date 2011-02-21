=== WP Relative Date ===
Contributors: dartiss
Donate link: http://artiss.co.uk/donate
Tags: date, relative, ago, years, months, days, hours, minutes, seconds
Requires at least: 2.5
Tested up to: 3.0.5
Stable tag: 1.0

Display a relative date (e.g. "4 days ago")

== Description ==

"Relative dates" is a method where instead of showing the exact date of a post, you can say it was posted "4 days ago." Tomorrow, this message would say "5 days ago."

This plugin has been designed to be called from your theme to display these relative dates as required.

It is based on code from a number of sites (none of which can be proven to be the originator!) but has been improved and converted to work with WordPress.

All relative dates are only shown at 2 depths and are not designed to be 100% accurate, but rather to give the reader an idea as to how old something is.

The dates will be shown in one the following formats, depending on relevance...

Years, months
Years, weeks
Months, weeks
Months, days
Weeks, days
Days, hours
Hours, minutes
Minutes, seconds
Seconds

Some example...

Something that is 1 years and 2 months and 3 weeks old will be output as "1 years, 2 months".
Something that is 1 years and 0 months and 3 weeks old will be output as "1 years, 3 weeks".

To use, you simply call either `get_relative_date` or `relative_date` - the first will return the relative date and the second will output it.

One parameter is required and that's a date in Unix format (more on that in a minute). A second date can be specified, if you wish, and the output will be the difference between the 2 dates. Otherwise the current date and time is assumed.

All dates specified must be in Unix format. In most cases you'll probably use this plugin to display a post time. That is returned by the code `get_the_time()`. By specifying `get_the_time('U')` instead, it will return it in Unix format.

So, to return the relative date instead you'd specify `get_relative_date(get_the_time('U'))`. Put that together along with an appropriate script to check that the plugin is active, you might have something like this in your theme...

`if (function_exists('get_relative_date')) {
    echo "Created ".get_relative_date(get_the_time('U'))." ago.";
}`

If you need to convert other dates/times to Unix format, you may want to look at the PHP commands [`date`](http://php.net/manual/en/function.date.php "date") and [`strtotime`](http://www.php.net/manual/en/function.strtotime.php "strtotime").

**For help with this plugin, or simply to comment or get in touch, please read the appropriate section in "Other Notes" for details. This plugin, and all support, is supplied for free, but [donations](http://artiss.co.uk/donate "Donate") are always welcome.**

== Licence ==

This WordPRess plugin is licensed under the [GPLv2 (or later)](http://wordpress.org/about/gpl/ "GNU General Public License
").

== Support ==

All of my plugins are supported via [my website](http://www.artiss.co.uk "Artiss.co.uk").

Please feel free to visit the site for plugin updates and development news - either visit the site regularly, follow [my news feed](http://www.artiss.co.uk/feed "RSS News Feed") or [follow me on Twitter](http://www.twitter.com/artiss_tech "Artiss.co.uk on Twitter") (@artiss_tech).

For problems, suggestions or enhancements for this plugin, there is [a dedicated page](http://www.artiss.co.uk/wp-relative-date "WP Relative Date") and [a forum](http://www.artiss.co.uk/forum "WordPress Plugins Forum"). The dedicated page will also list any known issues and planned enhancements.

Alternatively, please [contact me directly](http://www.artiss.co.uk/contact "Contact Me"). 

**This plugin, and all support, is supplied for free, but [donations](http://artiss.co.uk/donate "Donate") are always welcome.**

== Installation ==

1. Upload the entire `wp-relative-date`folder to your wp-content/plugins/ directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. That's it, you're done - you just need to add the function call to your theme!

== Frequently Asked Questions ==

= Which version of PHP does this plugin work with? =

It has been tested and been found valid from PHP 4 upwards.

= How can I get help or request possible changes =

Feel free to report any problems, or suggestions for enhancements, to me via [my forum](http://www.artiss.co.uk/forum "WordPress Plugins Forum") or [my contact form](http://www.artiss.co.uk/contact "Contact Me"). However, please check the [dedicated plugin page](http://www.artiss.co.uk/wp-relative-date "WP Relative Date") first for any known bugs or planned enhancements.

== Changelog ==  
  
= 1.0 =
* Initial release

== Upgrade Notice ==

= 1.0 =
* Initial release