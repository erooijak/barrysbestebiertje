=== Admin Stylur ===

Contributors: grayghostvisuals
Stable tag: 1.3
Requires at least: 4.0
Tested up to: 4.0
Tags: admin, dashboard, login, styling, customize
License: GPLv2 or later
Donate link: http://www.giveforward.com

Customized login form views for your wp-admin and dashboard screens.

== Description ==

Customized login form views for your wp-admin and dashboard screens. Read more about the customization of your admin via the <a href="http://codex.wordpress.org/Creating_Admin_Themes">WordPress Codex</a>. Additional features include setting the login logo to the URL of your blogsetting and adjusting the title attribute to your blog's name. Also provided is a logo uploader (found under the “Appearance” dashboard menu item) to swap the default WordPress logo on all login screens along with the ability to add a custom stylesheet that overrides the plugin's defaults.

NOTE:
Layout uses [flexbox](http://caniuse.com/#search=flexbox). Error messages use [transforms](http://caniuse.com/#search=transforms), [transitions](http://caniuse.com/#search=transitions) and [animations](http://caniuse.com/#search=animations). Vendor prefixes supplied where required. Consider yourself warned.

== Installation ==

1. Download the plugin
2. Upload to your “plugins” directory
3. Celebrate good times

**NOTE:**
*If you desire a custom stylesheet that overrides admin stylur's default styles you must do the following…*

1. In your theme's '``css``' folder make a new folder called '``admin-stylur``'.
2. Create a CSS file called '``wplogin.css``'.
3. Move '``wplogin.css``' to the '``[my_theme]/css/admin-stylur``' directory.
4. Enjoy custom stylesheet action homeslice.

== Frequently Asked Questions ==

= Where's the custom logo uploader located? =
You'll find the logo uploader under WordPress' “Appearance” menu item located on your admin dashboard. The sub-item option is titled “admin-stylur.”

= Where are the styles at dawg? =
Go to the “plugins” menu via your dashboard and select the admin-stylur's “edit” link.

= So you're just giving me a plain old CSS file? =
Sort of. Just some login cleanup cause I never like the way it looks, but I still want the integrity of the original login page design.

= What if I want custom styles that override admin stylur's defaults? =
Simply upload a custom stylesheet named '``wplogin.css``' to your theme's '``css/admin-stylur``' directory. Of course, you'll need to create a directory named '``admin-stylur``' within your '``css``' directory first. The rest is history. Happy customizing.

= What if I don't want custom styles that override admin stylur's defaults? =
The primary admin-stylur script detects the presence of a custom stylesheet and loads accordingly. No worries dawg! Bro fists all day long.

= What is the airspeed velocity of a swallow? =
Pretty fast.

== Changelog ==

= 1.3 =
* Adds the ability to detect the presence of a custom stylesheet that overrides the plugin's default styles.

= 1.2 =
* Fixed flexbox layout for IE10. Adds new plugin icon for plugin directory and cleans stylesheet

= 1.1 =
* First Commit! Yay!

== Upgrade Notice ==

Your current version is wack. Don't worry though because if you update me everything will be just fine even if you think you have an older version of WordPress. I promise I won't hurt you…pinky swear.

== Screenshots ==

1. login
2. login error message
3. logout message
4. Forgot password
5. Forgot password error message
6. Session expired
7. Session expired error message
8. WordPress update message
9. Custom logo uploader screen
