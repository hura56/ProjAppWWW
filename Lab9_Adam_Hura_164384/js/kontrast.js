//----------------------------------------------//
//          Metoda kontrast()                   //
//----------------------------------------------//
// Metoda po wcisnieciu przycisku zmienia kolor
// tła na ciemny i spowrotem na jasny po 
// ponownym wciśnięciu

function kontrast() {
    var tdElements = document.getElementsByClassName('main');
    var button = document.querySelector('button');

    for (var i = 0; i < tdElements.length; i++) {
        if (tdElements[i].style.backgroundColor === 'rgb(250, 247, 205)' || tdElements[i].style.backgroundColor === '') {
            tdElements[i].style.backgroundColor = 'rgb(66, 66, 66)';
            tdElements[i].style.color = 'rgb(250, 247, 205)';
            button.style.backgroundColor = 'rgb(250, 247, 205)';
            button.style.color = 'rgb(66, 66, 66)';
        } else {
            tdElements[i].style.backgroundColor = 'rgb(250, 247, 205)';
            tdElements[i].style.color = 'rgb(66, 66, 66)';
            button.style.backgroundColor = 'rgb(66, 66, 66)';
            button.style.color = 'rgb(250, 247, 205)';
        }
    }
}