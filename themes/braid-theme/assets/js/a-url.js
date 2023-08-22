class Url {

    endpoint;

    queryString;

    stringUrl;

    constructor() {
        this.endpoint = window.location.pathname.split("/")
        this.queryString = window.location.search
        this.stringUrl = window.location.origin + window.location.pathname
    }

    stringfyQueryStringData(object) {
        const params = [];

        for (const key in object) {
            if (object.hasOwnProperty(key)) {
                const value = object[key];
                params.push(`${encodeURIComponent(key)}=${encodeURIComponent(value)}`);
            }
        }

        return params.join('&');
    }

    parseQueryStringData() {
        const params = new URLSearchParams(this.queryString);
        const queryObject = {};

        for (const [key, value] of params) {
            queryObject[key] = value;
        }

        return queryObject
    }

    getCurrentEndpoint() {
        this.endpoint = this.endpoint.filter((value) => value != "" && value != "framework-php" && value != "braid")
        this.endpoint = this.endpoint.length == 0 ? '/' : this.endpoint.join('/')
        return this.endpoint
    }
}