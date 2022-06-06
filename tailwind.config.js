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
            'main-dark': '#1972ac',
        }
    },
  },
  plugins: [],
}
