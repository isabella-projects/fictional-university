import $ from 'jquery';

const TYPING_TIMER = 2000;
const FOCUS_TIMER = 400;

export default class Search {
    // Initiate object
    constructor() {
        this.addSearchHTML();
        this.resultsDiv = $('#search-overlay__results');
        this.openButton = $('.js-search-trigger');
        this.closeButton = $('.search-overlay__close');
        this.searchOverlay = $('.search-overlay');
        this.searchField = $('#search-term');
        this.events();
        this.previousValue;
        this.isOverlayOpen = false;
        this.isSpinnerVisible = false;
        this.typingTimer;
    }

    // Events
    events() {
        this.openButton.on('click', () => this.openOverlay());
        this.closeButton.on('click', () => this.closeOverlay());
        $(document).on('keydown', (e) => this.keyPressDispatcher(e));
        this.searchField.on('keyup', () => this.typingLogic());
    }

    // Methods
    openOverlay() {
        this.searchOverlay.addClass('search-overlay--active');
        $('body').addClass('body-no-scroll');
        setTimeout(() => this.searchField.trigger('focus'), FOCUS_TIMER);
        this.isOverlayOpen = true;
    }

    closeOverlay() {
        this.searchOverlay.removeClass('search-overlay--active');
        this.searchField.val('');
        $('body').removeClass('body-no-scroll');
        this.isOverlayOpen = false;
    }

    keyPressDispatcher(e) {
        if (e.keyCode == 83 && !this.isOverlayOpen && !$('input, textarea').is(':focus')) {
            this.openOverlay();
        }

        if (e.keyCode == 27 && this.searchOverlay.hasClass('search-overlay--active') && this.isOverlayOpen) {
            this.closeOverlay();
        }

        console.log(`Word: ${e.key} | Code: ${e.keyCode}`);
    }

    typingLogic() {
        if (this.searchField.val() === this.previousValue) {
            return;
        }

        clearTimeout(this.typingTimer);

        if (this.searchField.val()) {
            if (!this.isSpinnerVisible) {
                this.resultsDiv.html('<div class="spinner-loader"></div>');
                this.isSpinnerVisible = true;
            }

            this.typingTimer = setTimeout(() => {
                this.getResults();
            }, TYPING_TIMER);
        } else {
            this.resultsDiv.html('');
            this.isSpinnerVisible = false;
        }

        this.previousValue = this.searchField.val();
    }

    getResults() {
        $.when(
            $.getJSON(universityData.root_url + '/wp-json/wp/v2/posts?search=' + this.searchField.val()),
            $.getJSON(universityData.root_url + '/wp-json/wp/v2/pages?search=' + this.searchField.val())
        ).then(
            (posts, pages) => {
                let combinedResults = posts[0].concat(pages[0]);
                this.resultsDiv.html(`
                <h2 class="search-overlay__section-title">General Information</h2>
                ${combinedResults.length ? '<ul class="link-list min-list">' : '<p>No general information matches that search.</p>'}
                    ${combinedResults
                        .map(
                            (item) =>
                                `<li><a href="${item.link}">${item.title.rendered}</a> ${item.type == 'post' ? ` by ${item.authorName}` : ''}</li>`
                        )
                        .join('')}
                ${combinedResults.length ? '</ul>' : ''}
            `);
                this.isSpinnerVisible = false;
            },
            () => {
                this.resultsDiv.html('<p>Unexpected error occured! Please try again.</p>');
            }
        );
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
