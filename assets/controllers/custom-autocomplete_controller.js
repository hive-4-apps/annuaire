import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    initialize() {
        this._onPreConnect = this._onPreConnect.bind(this);
        this._onConnect = this._onConnect.bind(this);
    }

    connect() {
        this.element.addEventListener('autocomplete:pre-connect', this._onPreConnect);
        this.element.addEventListener('autocomplete:connect', this._onConnect);
    }

    disconnect() {
        // You should always remove listeners when the controller is disconnected to avoid side-effects
        this.element.removeEventListener('autocomplete:connect', this._onConnect);
        this.element.removeEventListener('autocomplete:pre-connect', this._onPreConnect);
    }

    _onPreConnect(event) {
        // TomSelect has not been initialized - options can be changed
        console.log(event.detail.options); // Options that will be used to initialize TomSelect
        event.detail.options.onChange = (value) => {
            // ...
        };

        event.detail.options.createText = function (input) {
            return 'Ajouter ' + input;
        };
    }

    _onConnect(event) {
        // TomSelect has just been intialized and you can access details from the event
        console.log(event.detail.tomSelect); // TomSelect instance
        console.log(event.detail.options); // Options used to initialize TomSelect
    }
}
