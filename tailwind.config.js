const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
    darkMode: "class",

    purge: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Nunito", ...defaultTheme.fontFamily.sans],
                lato: ["Lato", "serif"],
            },
            colors: {
                "ff-dark": "#252a2d",
                "ff-red": "#dc5049",
            },
            animation: {
                "ping-slow": "ping 8s cubic-bezier(0, 0, 0.2, 1) infinite",
            },
            keyframes: {
                ping: {
                    "99%, 100%": {
                        transform: "scale(2)",
                        opacity: "0",
                    },
                },
            },
            spacing: {
                144: "36rem", //576px
            },
            width: {
                128: "32rem",
                128: "32rem",
                132: "35rem",
            },
        },
    },

    variants: {
        extend: {
            opacity: ["disabled"],
        },
    },

    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
    ],
};
