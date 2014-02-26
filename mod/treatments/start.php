<?php

/**
 * Treatments
 *
 * @package treatments
 *
 */
elgg_register_event_handler('init', 'system', 'treatments_init');

/**
 * Init plugins tratamientos
 */
function treatments_init() {

    // registramos el menu
    $item = new ElggMenuItem('treatments', 'Treatments', 'treatments');
    elgg_register_menu_item('site', $item);

    // registramos librerías
    elgg_register_library('treatments', elgg_get_plugins_path() . 'treatments/lib/treatments.php');
    elgg_register_library('treatment_prescriptions', elgg_get_plugins_path() . 'treatments/lib/treatment_prescriptions.php');
    elgg_register_library('treatment_executions', elgg_get_plugins_path() . 'treatments/lib/treatment_executions.php');
    elgg_register_library('treatment_commons', elgg_get_plugins_path() . 'treatments/lib/treatment_commons.php');
    elgg_register_library('treatments_test', elgg_get_plugins_path() . 'treatments/lib/test.php');
    // 
    // cargamos las librerías (esto en realidad habría que hacerlo en cada página, para optimizar tiempos de carga...
    elgg_load_library('treatments');
    elgg_load_library('treatment_prescriptions');
    elgg_load_library('treatment_executions');
    elgg_load_library('treatment_commons');
    elgg_load_library('treatments_test');

    // registro de acciones
    $base_actions_dir = elgg_get_plugins_path() . 'treatments/actions';
    elgg_register_action('treatments/treatment/archive', "$base_actions_dir/treatments/treatment/archive.php");
    elgg_register_action('treatments/treatment/delete', "$base_actions_dir/treatments/treatment/delete.php");
    elgg_register_action('treatments/treatment/edit', "$base_actions_dir/treatments/treatment/edit.php");
    elgg_register_action('treatments/treatment/prescribe', "$base_actions_dir/treatments/treatment/prescribe.php");
    elgg_register_action('treatments/treatment/restore', "$base_actions_dir/treatments/treatment/restore.php");

    elgg_register_action('treatments/treatment_prescription/archive', "$base_actions_dir/treatments/treatment_prescription/archive.php");
    elgg_register_action('treatments/treatment_prescription/delete', "$base_actions_dir/treatments/treatment_prescription/delete.php");
    elgg_register_action('treatments/treatment_prescription/edit', "$base_actions_dir/treatments/treatment_prescription/edit.php");
    elgg_register_action('treatments/treatment_prescription/execute', "$base_actions_dir/treatments/treatment_prescription/execute.php");
    elgg_register_action('treatments/treatment_prescription/restore', "$base_actions_dir/treatments/treatment_prescription/restore.php");

    elgg_register_action('treatments/treatment_execution/archive', "$base_actions_dir/treatments/treatment_execution/archive.php");
    elgg_register_action('treatments/treatment_execution/delete', "$base_actions_dir/treatments/treatment_execution/delete.php");
    elgg_register_action('treatments/treatment_execution/edit', "$base_actions_dir/treatments/treatment_execution/edit.php");
    elgg_register_action('treatments/treatment_execution/evaluate', "$base_actions_dir/treatments/treatment_execution/evaluate.php");
    elgg_register_action('treatments/treatment_execution/register', "$base_actions_dir/treatments/treatment_execution/register.php");
    elgg_register_action('treatments/treatment_execution/restore', "$base_actions_dir/treatments/treatment_execution/restore.php");

    // Registro de java script. Opcion 1 ("selected pages")
    // 1. Creamos una copia cache de las vistas
    elgg_register_simplecache_view('js/treatments/treatments');
    // 2. Registramos la vista como codigo js
    $js_url = elgg_get_simplecache_url('js', 'treatments/treatments');
    elgg_register_js('treatments.treatments', $js_url);
    // en las visas que necesitemos usar este javascript, hay que incluir la
    // llamada a:
    elgg_load_js('treatments.treatments');
    // Registro de java script. Opcion 2 ("every page")
    // en este caso el procecidmiento normal sería extender la vista js de elgg:
//    elgg_extend_view('js/elgg', 'js/treatments/treatments');
//    elgg_load_js('lightbox');
//    elgg_load_css('lightbox');
    // routing of urls
    elgg_register_page_handler('treatments', 'treatments_page_handler');

    // Para permitir que usuarios distintos del propietario modifiquen entidades:
    elgg_register_plugin_hook_handler('permissions_check', 'all', 'treatments_permissions_check');
}

/**
 * Para controlar permisos de escritura de tratamientos
 * @param type $hook_name
 * @param type $entity_type
 * @param type $return_value
 * @param type $parameters
 * @return boolean|null 
 */
function treatments_permissions_check($hook_name, $entity_type, $return_value, $parameters) {

    $entity = $parameters['entity'];
    if ($entity instanceof ElggEntity) {
        switch ($entity->getSubtype()) {
            case ElggTreatment::SUBTYPE:
            case ElggTreatmentPrescription::SUBTYPE:
            case ElggTreatmentExecution::SUBTYPE:
            case ElggTreatmentSchedule::SUBTYPE:
                return true;

            default:
                return null;
        }

    }

    return null;
}

/**
 * Manejador de pagina
 * @param type $page 
 */
function treatments_page_handler($page) {

    // Recuperamos el path raiz para las páginas
    $pages_dir = elgg_get_plugins_path() . 'treatments/pages/treatments';

    // Analizamos la petición
    // this is a url like http://example.org/prp...
    if (count($page) == 0) {
        $page[0] = 'index';
    }

    // Pasamos la ruta a minusculas
    for ($index = 0; $index < count($page); $index++) {
        $page[$index] = strtolower($page[$index]);
    };

    switch ($page[0]) {
        case 'index': // treatments/index
            require "$pages_dir/index.php";
            return true;
        case 'prescriptor_shell': // treatments/prescriptor_shell
            require "$pages_dir/prescriptor_shell.php";
            return true;

        case 'patient_shell': // treatments/patient_shell
            require "$pages_dir/patient_shell.php";
            return true;

        case 'users_related': // treatments/users_related
            require "$pages_dir/users_related.php";
            return true;

        case 'treatment': // treatments/treatment/...
            if (count($page) == 1) {
                $page[1] = 'list'; // por defecto la lista de tratamientos
            }
            if (in_array($page[1], array("list", "view", "new", "edit", "prescribe"))) {
                require "$pages_dir/$page[0]/$page[1].php";
                return true;
            } else {
                require "$pages_dir/$page[0]/list.php";
                return true;
            }

        case 'treatment_prescription': // treatments/treatment_prescription/...
            if (count($page) == 1) {
                $page[1] = 'list'; // por defecto la lista de tratamientos asignados
            }
            if (in_array($page[1], array("list", "view", "edit", "execute", "executed"))) {
                require "$pages_dir/$page[0]/$page[1].php";
                return true;
            } else {
                require "$pages_dir/$page[0]/list.php";
                return true;
            }

        case 'treatment_execution': // treatments/treatment_execution/...
            if (count($page) == 1) {
                $page[1] = 'list'; // por defecto la lista de tratamientos ejecutados
            }
            if (in_array($page[1], array("list", "view", "register", "evaluate", "edit", "report"))) {
                require "$pages_dir/$page[0]/$page[1].php";
                return true;
            } else {
                require "$pages_dir/$page[0]/list.php";
                return true;
            }

        default: // xxx ==> treatments/treatment/list
            require "$pages_dir/treatment/list.php";
            return true;
    }
    // no hemos cazado la url, devolvemos false (aunque en realidad no deberíamos llegar aquí)
    return false;
}
