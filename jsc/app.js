
window.addEventListener("scroll", function () {
    var header = document.querySelector("header")
    header.classList.toggle("active", window.scrollY > 0);
})

let cards = document.querySelectorAll('.card');

cards.forEach(function (card) {
    card.addEventListener('click', function () {

        cards.forEach(function (c) {
            c.classList.remove('active');
        });

        card.classList.add('active');
    });
});

window.addEventListener('load', fg_load)

function fg_load() {
    document.getElementById('loading').style.display = 'none'

}
