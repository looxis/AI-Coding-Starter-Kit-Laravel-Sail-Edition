/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
  ],
  theme: {
    extend: {
      // Add project-specific colors, fonts, and spacing here
      // Example:
      // colors: {
      //   primary: '#2563EB',
      //   'primary-hover': '#1D4ED8',
      // },
      // fontFamily: {
      //   sans: ['Inter', 'sans-serif'],
      // },
    },
  },
  plugins: [],
};
