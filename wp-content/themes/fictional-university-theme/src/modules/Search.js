import $ from 'jquery';

class Search {
	// 1. describe and create/initiate our object
	constructor() {
		this.resultsDiv = $('#search-overlay__results');
		this.openButton = $('.js-search-trigger');
		this.closeButton = $('.search-overlay__close');
		this.searchOverlay = $('.search-overlay');
		this.searchField = $('#search-term');
		this.overlayStatus = false;
		this.isSpinnerVisible = false;
		this.previousValue;
		this.events();
		this.typingTimer;
	}

	// 2. events
	events() {
		this.openButton.on('click', this.openOverlay.bind(this));
		this.closeButton.on('click', this.closeOverlay.bind(this));
		$(document).on('keydown', this.keyPressDispatcher.bind(this));
		this.searchField.on('keyup', this.typingLogic.bind(this));
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
		if (event.key === 's' && this.overlayStatus === false && !$('input,text').is(':focus')) {
			this.openOverlay();
		} else if (event.key === 'Escape' && this.overlayStatus === true) {
			this.closeOverlay();
		}
	}

	typingLogic() {
		if (this.searchField.val() != this.previousValue) {
			clearTimeout(this.typingTimer);

			if (this.searchField.val()) {
				if (!this.isSpinnerVisible) {
					this.resultsDiv.html('<div class="spinner-loader"></div>');
					this.isSpinnerVisible = true;
				}
				this.typingTimer = setTimeout(this.getResults.bind(this), 2000);
			} else {
				this.resultsDiv.html('');
				this.isSpinnerVisible = false;
			}
		}

		this.previousValue = this.searchField.val();
	}

	getResults() {
		this.resultsDiv.html('Imagine real search results here');
		this.isSpinnerVisible = false;
	}
}

export default Search;
