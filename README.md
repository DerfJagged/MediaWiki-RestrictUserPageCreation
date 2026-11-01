# RestrictUserPageCreation
A MediaWiki extension that prevents users from creating a User Page or
sending email to other users unless they have submitted a required number
of edits to the wiki. Intended to be used as an anti-spam measure.

If Moderation is installed, only approved edits are counted.

## Installation
Requires Mediawiki 1.35 or higher. Add the following to LocalSettings.php:

```php
wfLoadExtension( "RestrictUserPageCreation" );
```

## Configuration
Add the following setting to LocalSettings.php with the desired threshold.
By default, both thresholds are set to 2 if not specified.

```
$wgRestrictUserPageCreationEditThreshold = 2;
$wgRestrictUserPageCreationEditThresholdForEmail = 2;
```

