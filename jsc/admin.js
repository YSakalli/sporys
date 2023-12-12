$(document).ready(function () {
    var savedSection = localStorage.getItem('selectedSection');
    if (savedSection) {
        showContent(savedSection);
    }
});

function toggleMenu() {
    const menu = document.querySelector('.menu');
    menu.classList.toggle('show');
}

function showContent(sectionId) {
    localStorage.setItem('selectedSection', sectionId);

    const sections = document.querySelectorAll('.content-section');
    sections.forEach(section => {
        section.style.display = 'none';
    });

    const selectedSection = document.getElementById(sectionId);
    if (selectedSection) {
        selectedSection.style.display = 'block';
    }
}