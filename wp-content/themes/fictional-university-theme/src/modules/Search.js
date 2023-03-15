import $ from 'jquery';

class Search {
	// 1. describe and create/initiate our object
	constructor() {
		this.addSearchHTML(); // Instantiate search modal
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
		this.searchField.val('');
		setTimeout(() => this.searchField.focus(), 300);
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
				this.typingTimer = setTimeout(this.getResults.bind(this), 750);
			} else {
				this.resultsDiv.html('');
				this.isSpinnerVisible = false;
			}
		}

		this.previousValue = this.searchField.val();
	}

	// getResults() {
	// 	// Revised fetch

	// 	// Jquery fetch method
	// 	$.getJSON(universityData.root_url + `/wp-json/wp/v2/posts?search=${this.searchField.val()}`, (posts) => {
	// 		$.getJSON(universityData.root_url + `/wp-json/wp/v2/pages?search=${this.searchField.val()}`, (pages) => {
	// 			let combinedResults = posts.concat(pages);
	// 			this.resultsDiv.html(`
	//         <h2 class="search-overlay__section-title">General Information</h2>
	//         ${combinedResults.length ? '<ul class="link-list min-list">' : '<p>No general information matches that search</p>'}
	//             ${combinedResults.map((result) => `<li><a href="${result.link}">${result.title.rendered}</a></li>`).join('')}
	//         ${combinedResults.length ? '</ul>' : ''}
	//         `);
	// 			this.isSpinnerVisible = false;
	// 		});
	// 	});
	// }

	async getResults() {
		let postAPI = universityData.root_url + `/wp-json/wp/v2/posts?search=${this.searchField.val()}`;
		let pageAPI = universityData.root_url + `/wp-json/wp/v2/pages?search=${this.searchField.val()}`;

		let responsePosts = await fetch(postAPI);
		let posts = await responsePosts.json();

		let responsePages = await fetch(pageAPI);
		let pages = await responsePages.json();

		let combinedResults = posts.concat(pages);

		this.resultsDiv.html(`
            <h2 class="search-overlay__section-title">General Information</h2>
            ${combinedResults.length ? '<ul class="link-list min-list">' : '<p>No general information matches that search</p>'}
                ${combinedResults.map((result) => `<li><a href="${result.link}">${result.title.rendered}</a></li>`).join('')}
            ${combinedResults.length ? '</ul>' : ''}
            `);
		this.isSpinnerVisible = false;
	}

	addSearchHTML() {
		$('body').append(`
        <div class="search-overlay">
  <div class="search-overlay__top">
    <div class="container">
      <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
      <input type="text" class="search-term" placeholder="What are you looking for?" id="search-term" autocomplete="off">
      <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
    </div>
  </div>
  <div class="container">
    <div id="search-overlay__results"></div>
  </div>
</div>
        `);
	}
}

export default Search;
