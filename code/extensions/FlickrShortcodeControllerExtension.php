<?php

class FlickrShortcodeControllerExtension extends Extension {

	/**
	 * An array of actions that can be accessed via a request. Each array element should be an action name, and the
	 * permissions or conditions required to allow the user to access it.
	 *
	 * <code>
	 * array (
	 *     'action', // anyone can access this action
	 *     'action' => true, // same as above
	 *     'action' => 'ADMIN', // you must have ADMIN permissions to access this action
	 *     'action' => '->checkAction' // you can only access this action if $this->checkAction() returns true
	 * );
	 * </code>
	 *
	 * @var array
	 */

	public static function FlickrShortcodeHandler($arguments) {

		$service = new FlickrService();

		$userId = FLICKR_USER;
		$service->setApiKey(FLICKR_API_KEY);
		$controller = new FlickrShortcodeControllerExtension();

		// set defaults
		$type = 'gallery';
		$columns = 2;

		if (isset($arguments['type'])) {
			$type = $arguments['type'];
		}
		if (isset($arguments['columns'])) {$columns = $arguments['columns'];}
		if (isset($arguments['set'])) {$setID = $arguments['set'];}


		switch($type){

			case "slideshow":
				return $controller->buildFlickrSet($setID, $type);
				break;

			case "gallery":

				//Photo Gallery if photo or tag argument set
				if (isset($arguments['photo'])) {
					$photoId = $arguments['photo'];
					return $controller->buildFlickrSingle($photoId);
					/* [flickr tag="xxxxxx"] */
				} elseif (isset($arguments['tag'])) {
					$tag = $arguments['tag'];
					return $controller->buildFlickrSetFromTag($tag, $type, $columns);
				}

				//Otherwise build a normal gallery based on a set.
				$set = $service->getPhotosetById($arguments['set']);
				if (isset($set)) {
					return $controller->buildFlickrSet($set, $type, $columns);
				}else{
					return null;
				}
				break;


			default:

				break;

		}

	}

	public function buildFlickrSet($set, $type = 'gallery', $columns = 2) {
		$template = new SSViewer('FlickrSet');
		$customise = array();
		$customise['Photoset'] = $set;
		$customise['FlickrUser'] = FLICKR_USER;
		$customise['Type'] = $type;
		//If we use a slideshow, don't call the service (performance woes), just generate an iframe and return it.
		if($type=="slideshow"){

			return $template->process(new ArrayData($customise));
		}

		//If we aren't using a slideshow, go ahead and access the service
		$service = new FlickrService();
		$service->setApiKey(FLICKR_API_KEY);

		$photosFromSet = $service->getPhotosInPhotoset($set->id);
		
		$customise['Photos'] = $photosFromSet;
		$customise['Columns'] = $columns;

		
		// //return the customised template
		return $template->process(new ArrayData($customise));

	}

	public function buildFlickrSetFromTag($tag, $type = 'gallery', $columns = 2) {
		$service = new FlickrService();
		$service->setApiKey(FLICKR_API_KEY);

		$photosFromTag = $service->getPhotosWithTag($tag, FLICKR_USER);

		$customise['Photos'] = $photosFromTag;

		$customise['Type'] = $type;
		$customise['Columns'] = $columns;

		$template = new SSViewer('FlickrSet');
		//return the customised template
		return $template->process(new ArrayData($customise));

	}

	public function buildFlickrSingle($photo_Id) {
		$service = new FlickrService();
		$service->setApiKey(FLICKR_API_KEY);
		$photo = $service->getPhotoById($photo_Id,FLICKR_USER);
		$customise = array(
			'Photo' => $photo

		);


		$template = new SSViewer('FlickrSingle');
		//return the customised template
		return $template->process(new ArrayData($customise));

	}
}
