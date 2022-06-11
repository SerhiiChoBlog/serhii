module.exports = {
  content: [
      "./app/View/**/*.php",
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.ts",
      "./resources/**/*.vue",
  ],
  darkMode: 'class',
  theme: {
    container: {
        center: true,
        padding: '1rem',
    },
    extend: {
        colors: {
            'page': 'var(--color-page)',
            'page-second': 'var(--color-page-second)',
            'border': 'var(--color-border)',
            'font': 'var(--color-font)',
            'font-second': 'var(--color-font-second)',
            'link': 'var(--color-link)',
            'link-hover': 'var(--color-link-hover)',
            'main-light': 'var(--color-main-light)',
            'main': 'var(--color-main)',
            'main-hover': 'var(--color-main-hover)',
            'main-dark': 'var(--color-main-dark)',
        },
        animation: {
            blink: 'blink 800ms linear infinite',
        },
        backgroundImage: {
           'home-hero': 'url(/storage/heros/home-hero.jpg)',
        },
        fontFamily: {
            text: ['Lato', 'serif'],
            code: ['Code', 'monospace'],
        },
        keyframes: {
            blink: {
                '50%': { opacity: 0 },
            }
        },
    },
  },
  plugins: [
      require('@tailwindcss/typography'),
  ],
}
