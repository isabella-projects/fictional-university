import $ from 'jquery';

const TIMEOUT_DURATION = 2000;

export default class Search {
    // Initiate object
    constructor() {
        this.resultsDiv = $('#search-overlay__results');
        this.openButton = $('.js-search-trigger');
        this.closeButton = $('.search-overlay__close');
        this.searchOverlay = $('.search-overlay');
        this.inputValue = $('.search-term');
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
        this.isOverlayOpen = true;
    }

    closeOverlay() {
        this.searchOverlay.removeClass('search-overlay--active');
        $('body').removeClass('body-no-scroll');
        this.isOverlayOpen = false;
        this.inputValue.val('');
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
            }, TIMEOUT_DURATION);
        } else {
            this.resultsDiv.html('');
            this.isSpinnerVisible = false;
        }

        this.previousValue = this.searchField.val();
    }

    getResults() {
        this.resultsDiv.html(`Real results here..`);
        this.isSpinnerVisible = false;
    }
}
