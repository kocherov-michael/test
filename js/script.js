"use strict";

// показываем в инпуте название выбранного файла
document.querySelectorAll('input[type="file"]').forEach(function (input) {
  input.addEventListener('change', function () {
    if (this.files[0]) {
      this.closest('.custom-file').querySelector('label').innerHTML = this.files[0].name;
    } else {
      this.closest('.custom-file').querySelector('label').innerHTML = 'Не выбрано';
    }
  });
}); 
// выбор процента мутации

setPercent(); 
// выбор изменения цветовой схемы

checkInput();
 // выбор языка

setInputValue('language');
 // выбор темы

setInputValue('theme'); 



// показываем процент мутации

function setPercent() {
  var rangeElement = document.querySelector('[data-range]');
  var percentElement = document.querySelector("[data-percent]");
  percentElement.innerHTML = read('mutation') || 0;
  rangeElement.value = read('mutation') || 0;
  rangeElement.addEventListener("change", function (event) {
    percentElement.innerHTML = event.target.value;
    save('mutation', event.target.value);
  });
}



 // обработка селекта


function setInputValue(element) {
  var inputElement = document.querySelector('[data-' + element + ']');
  inputElement.value = read(element);
  inputElement.addEventListener('change', function (event) {
    save(element, inputElement.value);
  });
}




 // выбор изменения цветовой схемы


function checkInput() {
  var inputElement = document.querySelector('[data-scheme]');
  inputElement.checked = read('scheme');
  inputElement.addEventListener('change', function (event) {
    save('scheme', event.target.checked);
  });
}

function save(key, value) {
  localStorage.setItem(key, JSON.stringify(value));
}

function read(key) {
  return JSON.parse(localStorage.getItem(key));
}