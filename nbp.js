export class RequestsNBP extends XMLHttpRequest {
    constructor() {
        super();
        this.url = `http://api.nbp.pl/api`;
    }

    getLastRates(code, topCount = 10) {
        this.open('GET', `${this.url}/exchangerates/rates/A/${code}/last/${topCount}`);
        this.setRequestHeader('Accept', 'application/json');
        this.send();
        return this.getPromise();
    }

    getRate(code, date = '') {
        this.open('GET', `${this.url}/exchangerates/rates/A/${code}/${date}`);
        this.setRequestHeader('Accept', 'application/json');
        this.send();
        return this.getPromise();
    }

    getTables(date = '') {
        this.open('GET', `${this.url}/exchangerates/tables/A/${date || 'today'}`);
        this.setRequestHeader('Accept', 'application/json');
        this.send();
        return this.getPromise();
    }

    getLastTables(topCount = 1) {
        this.open('GET', `${this.url}/exchangerates/tables/A/last/${topCount}`);
        this.setRequestHeader('Accept', 'application/json');
        this.send();
        return this.getPromise();
    }

    getPromise() {
        return new Promise((resolve, reject) => {
            this.addEventListener('load', () => {
                if (this.status === 200) {
                    resolve(JSON.parse(this.responseText));
                } else {
                    reject(new Error('Błąd!'));
                }
            });
        });
    }
}