/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue"
  ],
  theme: {
  },
  plugins: [
    require('daisyui'),
    
  ],
  daisyui: {
    themes: [ "aqua", "light"], // Define DaisyUI themes here
  },
  
}
