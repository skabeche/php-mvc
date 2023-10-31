/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./../App/Views/**/*.{html,php}",
    "./index.{html,php}",
    "./partials/**/*.{html,php}"
  ],
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
  theme: {
    screens: {
      sm: '480px',
      md: '768px',
      lg: '976px',
      xl: '1200px',
    },
    container: {
      center: true,
      padding: {
        DEFAULT: '1rem',
        sm: '1.2rem',
        md: '1.2rem',
        lg: '0.5rem',
        xl: '0.5rem',
      },
    },
    extend: {
      fontFamily: {
        sans: ['Open Sans', 'sans-serif'],
      },
      colors: {
        'black': '#000000',
        gray: {
          50: '#f9f9f9',
          100: '#f5f5f5',
          200: '#eeeeee',
          300: '#e0e0e0',
          400: '#bdbdbd',
          500: '#9e9e9e',
          600: '#888888',
          700: '#616161',
          800: '#424242',
          900: '#212121',
        },
      },
      boxShadow: {
        'lg': '0px 5px 15px 2px rgba(0, 0, 0, 0.1), 0px 5px 15px 2px rgba(0, 0, 0, 0.1)',
      },
      backgroundImage: {
      },
    },
  },
}

