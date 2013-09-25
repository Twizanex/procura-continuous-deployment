<?php
/*
 * Función para obtener los items asignados a un perfil específico
 * 
 * @profileType Texto que identifica el tipo de perfil
 * @return Array de items de menú asociados al perfil
 */
function procura_custom_index_get_menu_items_by_profile ($profileType){
    
    if (empty($profileType))
        return NULL;

    //Qué fácil es coger entidades en función a metadatos:
    $options = array (
        'metadata_name' => 'profile_asigned',
        'metadata_value' => $profileType,
    );
    return elgg_get_entities_from_metadata($options);
}

/*
 * Función para informar al PRP que un perfil tiene permiso de acceso a una URL
 * 
 * NO SE PUEDE, porque ir a una URL no es una 'action' que este módulo pueda controlar.
 * (El simple acceso al módulo se tiene que controlar en cada módulo)
 */

/*
 * Función para posicionar los items del menú
 * 
 * @orden Entero que indica el número de orden del item dentro del menú
 * @return Texto para asignarle una clase en el CSS al item
 */
function posicionar_boton_menu($orden){
    if (is_null($orden)){
        $flotar='';
    }else{
        if ($orden%2==0 ){
            $flotar = '-izq';
        }else{
            $flotar='-der';
        }
    }
    return $flotar;
}

?>
