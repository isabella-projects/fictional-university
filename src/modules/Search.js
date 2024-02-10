import $ from "jquery";

class Search {
    // Initiate object
    constructor() {
        this.openButton = $(".js-search-trigger");
        this.closeButton = $(".search-overlay__close");
        this.searchOverlay = $(".search-overlay");
        this.inputValue = $(".search-term");
        this.events();
    }

    events() {
        this.openButton.on("click", () => this.openOverlay());
        this.closeButton.on("click", () => this.closeOverlay());
    }

    openOverlay() {
        this.searchOverlay.addClass("search-overlay--active");
    }

    closeOverlay() {
        this.searchOverlay.removeClass("search-overlay--active");
        this.inputValue.val("");
    }
}

export default Search;
