const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    daisyui: {
        themes: [
            {
                light: {
                    ...require("daisyui/src/colors/themes")["[data-theme=light]"],
                    "--rounded-box": "0",
                    "--rounded-btn": "0",
                    "--rounded-badge": "0",
                    "--animation-btn": "0.25s",
                    "--animation-input": "0.2s",
                    "--btn-text-case": "uppercase",
                    "--btn-focus-scale": "0.95",
                    "--border-btn": "1px",
                    "--tab-border": "1px",
                    "--tab-radius": "0",
                },
                dark: {
                    ...require("daisyui/src/colors/themes")["[data-theme=dark]"],
                    "--rounded-box": "0",
                    "--rounded-btn": "0",
                    "--rounded-badge": "0",
                    "--animation-btn": "0.25s",
                    "--animation-input": "0.2s",
                    "--btn-text-case": "uppercase",
                    "--btn-focus-scale": "0.95",
                    "--border-btn": "1px",
                    "--tab-border": "1px",
                    "--tab-radius": "0",
                },
            },
        ],
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require("daisyui"),
    ],
};
