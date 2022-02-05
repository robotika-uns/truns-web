module.exports = {
  content: [
    "./components/**/*.{js,vue,ts}",
    "./layouts/**/*.vue",
    "./pages/**/*.vue",
    "./plugins/**/*.{js,ts}",
    "./nuxt.config.{js,ts}",
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('daisyui'),
  ],
  daisyui: {
    themes: [
      {
        'mytheme': {
          'primary': '#c7c7c7',
          'primary-focus': '#ffffff',
          'primary-content': '#000000',
          'secondary': '#1b79c5',
          'secondary-focus': '#2094f3',
          'secondary-content': '#ffffff',
          'accent': '#37cdbe',
          'accent-focus': '#2aa79b',
          'accent-content': '#ffffff',
          'neutral': '#3d4451',
          'neutral-focus': '#14161a',
          'neutral-content': '#ffffff',
          'base-100': '#16181d',
          'base-200': '#21242b',
          'base-300': '#0f1115',
          'base-content': '#d6d6d6',
          'info': '#2094f3',
          'success': '#029400',
          'warning': '#ff9900',
          'error': '#ff2424',
        },
      },
    ],
  },
}
