import $ from 'jquery';

class Search {
	// 1. describe and create/initiate our object
	constructor() {
		this.openButton = $('.js-search-trigger');
		this.closeButton = $('.search-overlay__close');
		this.searchOverlay = $('.search-overlay');
		this.searchField = $('#search-term');
		this.overlayStatus = false;
		this.events();
		this.typingTimer;
	}

	// 2. events
	events() {
		this.openButton.on('click', this.openOverlay.bind(this));
		this.closeButton.on('click', this.closeOverlay.bind(this));
		$(document).on('keydown', this.keyPressDispatcher.bind(this));
		this.searchField.on('keydown', this.typingLogic.bind(this));
	}

	// 3. methods (function, action...)
	openOverlay() {
		this.searchOverlay.addClass('search-overlay--active');
		$('body').addClass('body-no-scroll');
		this.overlayStatus = true;
	}

	closeOverlay() {
		this.searchOverlay.removeClass('search-overlay--active');
		$('body').removeClass('body-no-scroll');
		this.overlayStatus = false;
	}

	keyPressDispatcher(event) {
		if (event.key === 's' && this.overlayStatus === false) {
			this.openOverlay();
		} else if (event.key === 'Escape' && this.overlayStatus === true) {
			this.closeOverlay();
		}
	}

	typingLogic() {
		clearTimeout(this.typingTimer);
		this.typingTimer = setTimeout(function () {
			console.log('This is a timeout test');
		}, 2000);
	}
}

export default Search;
