// обработка события выбора валюты
$('#currency').change( (e) => {
    window.location = 'currency/change?currency=' + e.target.value;
//        console.log(e.target.value);
});



// обработка события выбора модификации - цвета товара
$('#colorSelector').change( (e) => {
//    window.location = 'currency/change?currency=' + e.target.value;

    let selectedOption = e.target[e.target.selectedIndex];
    console.log(selectedOption);

    console.log(selectedOption.dataset.id);
    console.log(selectedOption.dataset.title);
    console.log(selectedOption.dataset.price);
});

