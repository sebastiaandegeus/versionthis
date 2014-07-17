Version This
============

This WordPress plugin automatically versions your enqueued javascript and css files with a md5 hash to the querystring based on the file content.


## How it works

The files to be versioned are checked by their path and a md5 hash is made from the content of the file. If the file content is the same this md5 hash is always the same so the version stays the same.

When a file changes the md5 hash changed and so the new hash gets added to the querystring and the browser will download the changed file and cache it again.


## How it use it

This plugin provided a function `version_this()` that can be used in your plugin or theme to tell Version This to start versioning that file or group of files.

### Examples

This will version all `js` and `css` files that are enqueued and that contain `my_awesome_theme` in the URL of the file:
```
version_this('my_awesome_theme');
```


This will version all 'js' files named 'cool.js':
```
version_this('cool.js');
```


This will version a very specific file that contains the URL path `/my_plugin/assets/style.css`:
```
version_this('/my_plugin/assets/style.css');
```


## Fatal Error when plugin not activated

If `version_this()` gets called when the Version This plugin is not activated it may cause a fatal error. There are a couple ways to prevent this

* Put Version This in mu-plugins to always have it activated and loaded.
* Wrap the `version_this()` call inside a function exists call like so:

```
if ( function_exists( 'version_this' ) ) {
  version_this('something_to_version');
}
```

## Bedrock

When the project has been setup as a Bedrock project WordPress is in a subdirectory called `/web/wp`. This causes conflicts. To solve this add this to your `wp-config.php` or `application.php`. The plugin will check for this constant to fix the pathing issues automatically.

```
define( 'BEDROCK', true );
```
