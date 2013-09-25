<?php
/* Devuelve el tipo de usuario en String. Asume que un usuario solo tiene un tipo (devuelve
el primero) */
function tipoUsuario($user) {
    if (elgg_is_admin_user($user->guid)) return "Administrador";
    if ($user->custom_profile_type) return get_entity($user->custom_profile_type)->getTitle();
    return "NotFoud";
	
}
// De c�mo complicarse la vida innecesariamente perdiendo dos horas de tu vida.
// Dejo todo comentado para recordar en el futuro que a menudo, la mejor soluci�n es la m�s simple.
function getPacienteScormID($user) {
//	$data = profile_manager_get_user_profile_data($user);
////	var_dump($data);
//	$pacienteScormID = $data['pacienteScormID'];
////	var_dump($pacienteScormID);
//	$value = $pacienteScormID->value;
////	var_dump($value);
//	return $value;
	return $user->pacienteScormID;
}

function setPacienteScormID($user,$id) {
//	$categorized_fields = profile_manager_get_categorized_fields($user);
////	var_dump($categorized_fields);
//	$cats = $categorized_fields['fields'];
//// 	var_dump($cats);
// 	foreach ($cats as $cat) {
////		var_dump($cat);
//		foreach ($cat as $val) {
////			var_dump($val->getAttributes());
//		}
// 	}

	$user->pacienteScormID = $id;
	$user->save();
	
	
//	$data = profile_manager_get_user_profile_data($user);
////	var_dump($data);
////	var_dump($pacienteScormID);
//	$data['pacienteScormID']->value = $id;
////	((object) $data)->save();
//	$user->save();
////	$data['pacienteScormID']->save();
}

/**
 * Otras funciones comunes en Procura
 */
// 	MIOOOOOOOOOOOOOOOOOOOOOOOOOOO 
/**
 * @param type $user: Usuario para el que se quieren encontrar las relaciones
 * @param type $tipo_relacion: Tipo de relación a encontrar para el paciente dado. Puede ser nulo
 * @return Lista de usuarios para los que se cumple el tipo de relación indicada
 */
function procura_get_users_by_relation($user, $tipo_relacion=NULL){
    /*
    // SI SE HICIESE BIEN, SE USARÍA ESTA FUNCIÓN:
    $options = array(
		'relationship' => $tipo_relacion,
		'relationship_guid' => $user->guid,
		'types' => 'user',
		'subtypes' => ELGG_ENTITIES_ANY_VALUE,
		'limit' => 1000,
		'offset' => 0
	);
    $relaciones = elgg_get_entities_from_relationship($options);
     */
    
    // PERO SI SE CREA UN NUEVO TIPO DE entity PARA LAS RELACIONES, SERÍA ALGO ASÍ:
    $options = array ('type' => 'object', 'subtype' => 'relacion');
    $entidades_relacion = elgg_get_entities($options);
    $relaciones = array ();
    
    /* Si tipo_relacion es vacío o nulo, se obtienen todas las relaciones
     * Se comparan los dos lados de la relación, no sólo el origen.
     * Si no, no podríamos obtener los contactos de un paciente
     */
    if (is_null($tipo_relacion) || $tipo_relacion == ''){        
      foreach ($entidades_relacion as $entidad){
        // $entidad->entidad2 NUNCA es el de perfil "Paciente"          
        if ($entidad->entidad2 == $user->guid){
            $relaciones[] = get_user($entidad->entidad1);            
        }
        if ($entidad->entidad1==$user->guid){
            $relaciones[] = get_user($entidad->entidad2);  
        }
      }       
    }else{
        foreach ($entidades_relacion as $entidad){
            // $entidad->entidad2 NUNCA es el de perfil "Paciente"
            if ($entidad->tiporelacion == $tipo_relacion){
                if ($entidad->entidad2 == $user->guid){
                    $relaciones[] = get_user($entidad->entidad1);            
                }
                if ($entidad->entidad1==$user->guid){
                    $relaciones[] = get_user($entidad->entidad2);  
                }
            }
        }
    }
    
    return $relaciones; // Array de entidades usuario
}

/*
 * Función para determinar si un botón de menú ha de estar en la columna derecha o en
 * la izquierda de la página:
 *  - Si el orden es par, aparecerá a la izquierda de la página
 *  - Si el orden es impar, aparecerá a la derecha de la página
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