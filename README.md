# RestrictUserPageCreation
A MediaWiki extension that prevents users from creating a User Page unless
they have submitted a required number of edits to the wiki. If Moderation
is installed, only approved edits are counted.

## Installation
Requires Mediawiki 1.35 or higher. Add the following to LocalSettings.php:

```php
wfLoadExtension( "RestrictUserPageCreation" );
```

## Configuration
Add the following setting to LocalSettings.php with the desired threshold.
By default, the threshold is set to 2.

```
$wgRestrictUserPageCreationEditThreshold = 2;
```

