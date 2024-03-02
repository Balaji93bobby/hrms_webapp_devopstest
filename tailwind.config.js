/** @type {import('tailwindcss').Config} */
const plugin = require('tailwindcss/plugin')
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {},
    },
    plugins: [

        plugin(function ({ addComponents, theme }) {
            addComponents({
                '.tw-card': {
                    backgroundColor: theme('colors.white'),
                    borderRadius: theme('borderRadius.lg'),
                    boxShadow: theme('boxShadow.xl'),
                    padding: theme('spacing.4'),

                }
            })
        })
    ],
    plugins: [
    ]
}
