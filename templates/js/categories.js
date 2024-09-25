// categories.js
document.getElementById('categories-toggle').addEventListener('click', function (e) {
    e.preventDefault();
    var menu = document.getElementById('categories-menu');
    menu.style.display = (menu.style.display === 'none' || menu.style.display === '') ? 'block' : 'none';
});

alert("Hello! I am an alert box!!");
console.log('cool');
