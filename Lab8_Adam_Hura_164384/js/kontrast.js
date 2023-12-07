function kontrast() {
    var tdElements = document.getElementsByClassName('main');
    var button = document.querySelector('button');

    for (var i = 0; i < tdElements.length; i++) {
        if (tdElements[i].style.backgroundColor === 'rgb(250, 225, 205)' || tdElements[i].style.backgroundColor === '') {
            tdElements[i].style.backgroundColor = 'rgb(19, 18, 18)';
            tdElements[i].style.color = 'rgb(250, 225, 205)';
            button.style.backgroundColor = 'rgb(250, 225, 205)';
            button.style.color = 'rgb(19, 18, 18)';
        } else {
            tdElements[i].style.backgroundColor = 'rgb(250, 225, 205)';
            tdElements[i].style.color = 'rgb(19, 18, 18)';
            button.style.backgroundColor = 'rgb(19, 18, 18)';
            button.style.color = 'rgb(250, 225, 205)';
        }
    }
}