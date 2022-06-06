module.exports = {
  content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
  ],
  theme: {
    container: {
        center: true,
        padding: '1.2rem',
    },
    extend: {
        colors: {
            'main-light': '#99c8e6',
            main: '#3298dc',
            'main-hover': '#288acc',
            'main-dark': '#1972ac',
        },
        animation: {
            blink: 'blink 1s linear infinite',
        },
        backgroundImage: {
           'home-hero': 'url(/storage/heros/home-hero.jpg)',
        },
        fontFamily: {
            lato: ['Lato', 'sans-serif'],
            code: ['JetBrainsMono', 'monospace'],
        },
        keyframes: {
            blink: {
                '50%': { opacity: 0 },
            }
        },
    },
  },
  plugins: [],
}
