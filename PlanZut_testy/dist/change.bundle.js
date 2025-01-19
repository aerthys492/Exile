/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./src/js/change.js":
/*!**************************!*\
  !*** ./src/js/change.js ***!
  \**************************/
/***/ (() => {

eval("const darkModeToggle = document.getElementById('darkModeToggle');\r\ndarkModeToggle.addEventListener('click', () => {\r\n    document.body.classList.toggle('dark-mode');\r\n    darkModeToggle.textContent = document.body.classList.contains('dark-mode') ? '☀️' : '🌙';\r\n});\r\n\r\n// Funkcja obsługująca zmianę wielkości czcionki\r\nconst fontSmall = document.getElementById('fontSmall');\r\nconst fontMedium = document.getElementById('fontMedium');\r\nconst fontLarge = document.getElementById('fontLarge');\r\n\r\nfontSmall.addEventListener('click', () => {\r\n    document.body.style.fontSize = '16px';\r\n});\r\n\r\nfontMedium.addEventListener('click', () => {\r\n    document.body.style.fontSize = '20px';\r\n});\r\n\r\nfontLarge.addEventListener('click', () => {\r\n    document.body.style.fontSize = '24px';\r\n});\n\n//# sourceURL=webpack://planzut/./src/js/change.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./src/js/change.js"]();
/******/ 	
/******/ })()
;