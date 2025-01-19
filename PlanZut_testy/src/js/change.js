const darkModeToggle = document.getElementById('darkModeToggle');
darkModeToggle.addEventListener('click', () => {
    document.body.classList.toggle('dark-mode');
    darkModeToggle.textContent = document.body.classList.contains('dark-mode') ? '☀️' : '🌙';
});

// Funkcja obsługująca zmianę wielkości czcionki
const fontSmall = document.getElementById('fontSmall');
const fontMedium = document.getElementById('fontMedium');
const fontLarge = document.getElementById('fontLarge');

fontSmall.addEventListener('click', () => {
    document.body.style.fontSize = '16px';
});

fontMedium.addEventListener('click', () => {
    document.body.style.fontSize = '20px';
});

fontLarge.addEventListener('click', () => {
    document.body.style.fontSize = '24px';
});