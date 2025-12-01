/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./templates/**/*.php",
    "./pages/**/*.php",
    "./public/**/*.php",
    "./public/**/*.html",
  ],
  theme: {
    extend: {
      maxWidth: {
        'screen-xl': '1280px',
      },
    },
  },
  plugins: [],
}

