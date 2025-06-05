const navItems = document.querySelectorAll('nav ul li a');
navItems.forEach(item => {
    item.addEventListener('click', e => {
        navItems.forEach(i => {
            i.parentElement.classList.remove('active');
        });
        item.parentElement.classList.add('active');
    });
});