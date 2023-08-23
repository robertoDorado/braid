class Url {

    endpoint;

    queryString;

    stringUrl;

    getStringUrl() {
        this.stringUrl = window.location.origin + window.location.pathname
        return this.stringUrl
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
        this.queryString = window.location.search
        const params = new URLSearchParams(this.queryString);
        const queryObject = {};

        for (const [key, value] of params) {
            queryObject[key] = value;
        }

        return queryObject
    }

    getCurrentEndpoint() {
        this.endpoint = window.location.pathname.split("/")
        if (Array.isArray(this.endpoint)) {
            this.endpoint = this.endpoint.filter((value) => value != "" && value != "framework-php" && value != "braid")
            this.endpoint = this.endpoint.length == 0 ? '/' : this.endpoint.join('/')
            return this.endpoint
        }
    }
}

const url = new Url()