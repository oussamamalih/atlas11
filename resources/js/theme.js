document.addEventListener('alpine:init', () => {
    Alpine.store('theme', {
        theme: document.documentElement.getAttribute('data-theme') || 'dark',
        toggle() {
            this.theme = this.theme === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', this.theme);
            document.documentElement.classList.toggle('dark', this.theme === 'dark');
            try {
                localStorage.setItem('tx11-theme', this.theme);
            } catch (e) {}
        },
    });
});