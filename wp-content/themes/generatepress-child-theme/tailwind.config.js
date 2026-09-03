/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./*.php", "./**/*.php", "./**/*.html", "./ src/**/ *.css", "./ scripts/**/ *.js"],

  important: "#wyz-creations",
  safelist: [
    // WordPress editor output (post_content) can include these list
    // classes directly; they never appear as literal strings in the
    // scanned theme files, so Tailwind's content scanner never picks
    // them up on its own.
    'list-inside',
    'list-disc',
    'list-decimal',
    'list-none',
  ],
};
