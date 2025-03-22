/** @type {import('tailwindcss').Config} */
export default {
    content: ["./src/**/*.{js,jsx,ts,tsx}"],
    theme: {
      extend: {
        animation: {
          flip: "flip 1s ease-in-out infinite",
        },
        keyframes: {
          flip: {
            "0%": { transform: "rotateY(0deg)" },
            "50%": { transform: "rotateY(180deg)" },
            "100%": { transform: "rotateY(0deg)" },
          },
        },
      },
    },
    plugins: [],
  };
  