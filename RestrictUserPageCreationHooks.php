<?php

class RestrictUserPageCreationHooks {
    // Default edit threshold (can be overridden in LocalSettings.php)
    public static $threshold = 2;

    public static function onEditFilterMergedContent(
        $context,
        $content,
	$status,
        $summary,
	$user,
	$minoredit
    ): bool {
        // Get the Title object from the context (Article or IContextSource)
        if ( method_exists( $context, 'getTitle' ) ) {
            $title = $context->getTitle();
        } else {
            return true; // Can't get title; allow edit just in case
        }

        // Only act on user pages
        if ( $title->getNamespace() !== NS_USER ) {
            return true;
        }

        // Allow if editing an existing page
        if ( $title->exists() ) {
            return true;
	}

	// Use the configurable threshold
        $threshold = MediaWiki\MediaWikiServices::getInstance()
	    ->getMainConfig()
	    ->get( 'RestrictUserPageCreationEditThreshold' );


        // Check user's edit count
        if ( $user->getEditCount() < $threshold ) {
            $status->fatal(
                wfMessage( 'restrictuserpagecreation-denied' )->params( $threshold )
            );	
            return false;
        }

        return true;
    }
}

