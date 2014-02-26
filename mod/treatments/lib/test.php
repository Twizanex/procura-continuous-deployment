<?php

/**
 * Funciones de test para el plugin de tratamientos
 * @package Treatments
 */

function treatments_create_fake_treatments(){
    $names = array(
        'Inclinacion lateral de cabeza',
        'Elevacion y descenso de hombros',
        'Rotacion de cuello',
        'Rotacion del tronco',
        'Inclinaciones laterales del tronco',
        'Caminar sobre una linea recta',
        'Desplazamientos laterales',
        );
    $categories = array(
        'Disminuir la rigidez', 
        'Mejorar el equilibrio y la estabilidad'
        );
    $levels = array(
        'Basico', 
        'Intermedio', 
        'Avanzado'
        );
        foreach ($names as $name) {
            $t = new ElggTreatment();
            $t->name = $name;
            $t->category = $categories[array_rand($categories)];
            $t->level = $levels[array_rand($levels)];
            $t->is_archived = false;
            $t->access_id=1;
            $t->save();            
        }
    
}

function treatments_delete_all_treatments(){
    // recuperamos los tratamientos
    $treatments_list = treatments_get_treatments_all();
    /* @var $treatment ElggTreatment */
    foreach ($treatments_list as $treatment) {
        $treatment->delete();
    }
}

