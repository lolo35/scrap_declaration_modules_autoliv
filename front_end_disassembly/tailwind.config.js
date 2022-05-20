module.exports = {
  content: [
    './public/index.html',
    './src/**/*.{vue,js,html}'
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('tailwindcss-debug-screens')
  ],
}
