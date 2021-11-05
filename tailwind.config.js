const defaultTheme = require('tailwindcss/defaultTheme')
const colors = require('tailwindcss/colors')

module.exports = {
    mode: 'jit',

    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Satoshi', ...defaultTheme.fontFamily.sans],
            },
            outline: {
                gray: `1px solid ${colors.gray[300]}`,
            },
        },
    },

    variants: {
        extend: {},
    },

    plugins: [
        require('@tailwindcss/forms'), //
    ],
}
