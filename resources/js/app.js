// Alpine ships with Livewire 4. Register the typewriter once Alpine boots.
document.addEventListener('alpine:init', () => {
    window.Alpine.data('typewriter', (phrases = [], opts = {}) => ({
        phrases,
        output: '',
        index: 0,
        running: false,
        speed: opts.speed ?? 55,
        deleteSpeed: opts.deleteSpeed ?? 26,
        pause: opts.pause ?? 1600,

        start() {
            const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            if (reduced || this.phrases.length === 0) {
                // No motion: show the first line in full, no caret churn.
                this.output = this.phrases[0] ?? '';
                return;
            }

            this.running = true;
            this.loop();
        },

        async loop() {
            // Type the first phrase, then rotate through the rest indefinitely.
            // A single phrase types once and stays put.
            while (this.running) {
                await this.type(this.phrases[this.index]);
                await this.wait(this.pause);

                if (this.phrases.length === 1) {
                    return;
                }

                await this.erase();
                this.index = (this.index + 1) % this.phrases.length;
                await this.wait(280);
            }
        },

        type(text) {
            return new Promise((resolve) => {
                let i = 0;
                const tick = () => {
                    this.output = text.slice(0, ++i);
                    i < text.length ? setTimeout(tick, this.speed) : resolve();
                };
                tick();
            });
        },

        erase() {
            return new Promise((resolve) => {
                const tick = () => {
                    this.output = this.output.slice(0, -1);
                    this.output.length ? setTimeout(tick, this.deleteSpeed) : resolve();
                };
                tick();
            });
        },

        wait(ms) {
            return new Promise((resolve) => setTimeout(resolve, ms));
        },
    }));
});
