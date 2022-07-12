const plugin = require("tailwindcss/plugin");

module.exports = {
  content: ["*.{html,js,php}"],
  theme: {
    container: {
      center: true,
      padding: {
        DEFAULT: "2rem",
        xl: "4rem",
      },
    },
    extend: {},
  },
  plugins: [require("@tailwindcss/forms")],
};
