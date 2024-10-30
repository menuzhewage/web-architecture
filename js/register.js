const cursor = document.querySelector('.cursor');

document.addEventListener('mousemove', (e) => {
    cursor.style.top = `${e.clientY}px`;
    cursor.style.left = `${e.clientX}px`;
});

document.addEventListener('click', () => {
    cursor.classList.add('expand');

    setTimeout(() => {
        cursor.classList.remove('expand');
    }, 500);
});
