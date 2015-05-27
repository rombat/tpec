/**
 * Created by Romain on 27/05/2015.
 */
var max_fields = 15; //maximum d'input permis
var wrapper = $('.ingredients-group'); //div encadrant
var add_button = $("#ajoutIngredient"); //ajout de champs
var del_button = $('#retraitIngredient');
var input_group = $('.ingredients-group-input')[0].outerHTML;

var x = 1; // Compteur d'ajouts
$(add_button).click(function (e) { // Event au click du bouton d'ajout
    e.preventDefault();
    if (x < max_fields) {
        x++;
        $(wrapper).append(input_group); //ajout d'un bloc d'input
    }
});

$(del_button).click(function (e) { //retrait d'un bloc d'input et du dernier index des tableaux d'input
    e.preventDefault();
    if (x > 1) {
        $('.ingredients-group-input').last().remove();
        x--;
    }
});