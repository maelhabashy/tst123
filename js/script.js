// Sliding Navigation Bar
let lastScrollTop = 0;
const nav = document.querySelector('.sliding-nav');

window.addEventListener('scroll', () => {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    if (scrollTop > lastScrollTop) {
        // Scroll down
        nav.style.top = '-80px'; // Hide the navigation bar
    } else {
        // Scroll up
        nav.style.top = '0'; // Show the navigation bar
    }
    lastScrollTop = scrollTop;
});