class Flaga extends HTMLElement {
    constructor() {
        super();
        this.shadow = this.attachShadow({mode: 'open'});
        this.render();
    }

    get kraj() {
        return this.getAttribute('kraj');
    }

    set kraj(value) {
        this.setAttribute('kraj', value);
    }
    
    static get observedAttributes() {
        return ['kraj'];
    }

    render() {
        if(this.kraj === 'xd') return;
        this.shadow.innerHTML = `
        <picture>
          <source
            type="image/webp"
            srcset="https://flagcdn.com/24x18/${this.kraj}.webp,
              https://flagcdn.com/48x36/${this.kraj}.webp 2x,
              https://flagcdn.com/72x54/${this.kraj}.webp 3x">
          <source
            type="image/png"
            srcset="https://flagcdn.com/24x18/${this.kraj}.png,
              https://flagcdn.com/48x36/${this.kraj}.png 2x,
              https://flagcdn.com/72x54/${this.kraj}.png 3x">
          <img
            src="https://flagcdn.com/24x18/${this.kraj}.png"
            width="24"
            height="18">
        </picture>`;
    }
}

customElements.define('flaga-kraju', Flaga);