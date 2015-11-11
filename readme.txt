=== Plugin Name ===
Contributors: enguerranws
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=BQNTS4S2PEQVN
Tags: youtube, content, videos, enguerranws, google api, youtube api, youtube importer, video importer
Requires at least: 3.0.1
Tested up to: 3.0.1
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Import YouTube videos as WP Posts lets you search for Youtube videos and add them quickly to your Wordpress website.

== Description ==

*English Version*

**Import YouTube videos as WP Posts** is a simple plugin that allow you to search Youtube videos from the admin panel (with keywords, channel or playlist ID) and add the videos you pick to your posts.

= It's a simple way : =
* to **feed your WordPress website with real content in minutes**
* to **display curated content from Youtube** on your website
* to **link a playlist or a channel to your website**

= How does it work ? =
1. Type a request : keywords, channel ID or playlist ID
2. Fill some parameters : taxonomy to feed, post type to feed, number of results to show
3. Some template tags (%title%, %user%, etc.) are available to customize the content you add to your WordPress website
4. Choose some videos and add them to your website or reject them

**Works on every themes** : it just feed an existing ressource (e.g. : Posts) with selected Youtube content.

*Available in French and English.*





*Version Française*

**Import YouTube videos as WP Posts** est un plugin tout simple qui permet de **chercher des vidéos Youtube depuis l'administration** de WordPress et de **les ajouter à son site rapidement**.

= Quelques utilisations : =
* **alimenter un site en quelques minutes avec du vrai contenu** venant de Youtube
* **afficher un contenu choisi sur son site**
* **faire le lien entre une playlist ou une chaîne Youtube**

= Comment ça marche ? =
1. Tapez une requête : mots-clé, ID de playlist, ID de chaîne
2. Réglez quelques paramètres : taxonomie à remplir, post type à remplir, nombre de vidéos à afficher, etc...
3. Il est possible de customiser votre contenu ajouté avec un petit système de template (%title%, %user%, etc.)
4. Une fois votre recherche effectuée, choisissez des vidéos, ajoutez-les à votre site ou rejetez celle qui ne vous plaisent pas.

**Ça fonctionne avec tous les thèmes** : le plugin ajoute les vidéos choisies à un type de ressources existant (ex: Articles).

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload `/import-youtube-videos-as-wp-post/` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Set up your Google API key in the Settings page
4. Search for Youtube content and add it to your Wordpress from the 'Import YouTube videos as WP Posts' menu


== Screenshots ==
1. Admin interface to search and add Youtube videos as WP posts
2. Admin settings for the plugin (Settings > Youtube importer)


== Frequently Asked Questions ==

= Can I choose the post type and the taxonomy I want to add videos to? =
Yes.

= How can I get a Google API key? =

To use this plugin, **you'll need to create a Google Youtube API key**. Dealing with Google Developers Console can be a bit confusing, you need to : create a project, make the API data you need active and generate a public API key. Here's how to do that:

1. Login to Google using your Google account.
2. Go to the Developers Console > Projects
Click on "Create a project" (you'll need to give it a title and an ID)
3. When your project his created, click on it on the project list
4. Go to the section API and authentication > API, and search for YouTube Data API v3, and click on the button on the right to make this API active.
5. Go to the Credentials section > Access to the public API anc click on the button "Make a key" > Server key
6. On the next box, you'll need to tell on which domains you allow the use of your app (e.g. 127.0.0.1, www.mydomain.com, etc).
7. Now it should have generated a API Key (e.g. AIzaFyD0aPCQjLFRbLnh4RKbVBlBgVCVSwjbFAg), copy-paste it on the box above.
8. It's done, congrats :)

= I got the message : 'Your Youtube API access is not defined, go set it on the settings page.' =
It's because you didn't fill the API key field (in the settings page) with your Google API key.

= I got the message : 'There is an error with your API key, it has been rejected by Google API Service.' =
This is mostly because you made a mistake typing / copying your API key. Check the API key field in the Settings page.


== Changelog ==

= 1.0 =
* Plugin init
