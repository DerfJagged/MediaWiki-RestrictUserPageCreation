<?php

class RestrictUserPageCreationHooks {
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
        $userpageThreshold = 2; // Default
        try {
            $threshold = MediaWiki\MediaWikiServices::getInstance()
	        ->getMainConfig()
	        ->get( 'RestrictUserPageCreationEditThreshold' );
            $userpageThreshold = $threshold;
        } catch (Exception $e) {}

        // Check user's edit count
        if ( $user->getEditCount() < $userpageThreshold ) {
            $status->fatal(
                wfMessage( 'restrictuserpagecreation-userpage-denied' )->params( $userpageThreshold )
            );	
            return false;
        }

        return true;
    }

    public static function onEmailUserAuthorizeSend( 
        $sender, 
        $status
    ): bool {
        // Use the configurable threshold
        $emailThreshold = 2; //Default
        try {
            $threshold = MediaWiki\MediaWikiServices::getInstance()
	        ->getMainConfig()
	        ->get( 'RestrictUserPageCreationEditThresholdForEmail' );
            $emailThreshold = $threshold;
        } catch (Exception $e) {}

        // Check user's edit count
        if ( $sender->getUser()->getEditCount() < $emailThreshold ) {
            $status->fatal(
                wfMessage( 'restrictuserpagecreation-email-denied' )->params( $emailThreshold )
            );	
            return false;
        }

        return true;
    }
}
