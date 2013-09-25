<?php

/**
 * The core language file is in /languages/en.php and each plugin has its
 * language files in a languages directory. To change a string, copy the
 * mapping into this file.
 *
 * For example, to change the blog Tools menu item
 * from "Blog" to "Rantings", copy this pair:
 * 			'blog' => "Blog",
 * into the $mapping array so that it looks like:
 * 			'blog' => "Rantings",
 *
 * Follow this pattern for any other string you want to change. Make sure this
 * plugin is lower in the plugin list than any plugin that it is modifying.
 *
 * If you want to add languages other than English, name the file according to
 * the language's ISO 639-1 code: http://en.wikipedia.org/wiki/List_of_ISO_639-1_codes
 */
$mapping = array(
    // admin menu 
    'admin:prp' => "Permisos y perfiles",
    'admin:prp:module_actions' => "Configurar acciones de módulos",
    'admin:prp:relation_names' => "Configurar tipos de relaciones admitidos",

    // Tooltips
    'prp:tooltips:more_info_relation_names_list' => "
            <b>Tipos de relaciones</b><br />
            Puedes dar de alta nuevos tipos de relacion, modificar y/o eliminar los ya existentes.<br /><br />
    ",
    'prp:tooltips:more_info_module_actions_list' => "
            <b>Acciones de modulos</b><br />
            Puedes configurar los permisos de cada acción, haciendo click en la acción correspondiente.<br /><br />
    ",
    'prp:tooltips:more_info_module_actions_test_list' => "
            <b>Acciones de modulos</b><br />
            Puedes dar de alta o eliminar acciones, haciendo click en el botón correspondiente.<br /><br />
    ",
    'prp:tooltips:more_info_actions' => "
            <b>Acciones</b><br />
            Acciones varias relacionadas.<br /><br />
    ",
    
    // LIB
    'prp:error:admin_required' => 'Se requieren permisos de administrador para realizar la operacion solicitada',
    'prp:error:module_not_found' => 'El modulo indicado no es valido',
    'prp:error:user_profile_not_valid' => 'El perfil del usuario no es valido',
    'prp:error:relation_name_not_valid' => 'El tipo de relacion indicado no es valido',
    
    // ACTIONS
    // prp/relation_names    
    'prp:actions:relations:names:save:error' => 'Se ha producido algun error al guardar el tipo de relacion',
    'prp:actions:relations:names:save:ok' => 'Se ha guardado correctamente el tipo de relacion',
    'prp:actions:relations:names:delete:error' => 'Se ha producido algun error al eliminar el tipo de relacion',
    'prp:actions:relations:names:delete:ok' => 'Se ha eliminado correctamente el tipo de relacion',
    'prp:actions:relations:names:import:error' => 'Se ha producido algun error al importar los tipos de relaciones',
    'prp:actions:relations:names:import:ok' => 'Se han importado correctamente los tipos de relaciones',
    'prp:actions:relations:names:export:error' => 'Se ha producido algun error al exportar los tipos de relaciones',
    'prp:actions:relations:names:export:ok' => 'Se han exportado correctamente los tipos de relaciones',
    'prp:actions:relations:add:error' => 'Se ha producido algun error al establecer la relacion',
    'prp:actions:relations:add:ok' => 'Se ha establecido correctamete la relacion',
    'prp:actions:relations:delete:error' => 'Se ha producido algun error al eliminar la relacion',
    'prp:actions:relations:delete:ok' => 'Se ha eliminado correctamete la relacion',
    'prp:actions:relations:delete_all:error' => 'Se ha producido algun error al eliminar las relaciones del usuario',
    'prp:actions:relations:delete_all:ok' => 'Se han eliminado correctamete las relaciones del usuario',
    // prp/module_actions
    'prp:actions:module_actions:add:error' => 'Se ha producido algun error al registrar la acción del módulo',
    'prp:actions:module_actions:add:ok' => 'Se han registrado correctamente la acción del módulo',
    'prp:actions:module_actions:save:error' => 'Se ha producido algun error al guardar los permisos de la acción del módulo',
    'prp:actions:module_actions:save:ok' => 'Se han guardado correctamente los permisos de la acción del módulo',
    'prp:actions:module_actions:delete:error' => 'Se ha producido algun error al eliminar la acción del módulo',
    'prp:actions:module_actions:delete:ok' => 'Se ha eliminado correctamente la acción del módulo',
    'prp:actions:module_actions:import:error' => 'Se ha producido algun error al importar los permisos de acciones de módulos',
    'prp:actions:module_actions:import:ok' => 'Se han importado correctamente los permisos de acciones de módulos',
    'prp:actions:module_actions:export:error' => 'Se ha producido algun error al exportar los permisos de acciones de módulos',
    'prp:actions:module_actions:export:ok' => 'Se han exportado correctamente los permisos de acciones de módulos',
    // prp/profile_permissions
    'prp:actions:profile_permissions:save:error' => 'Se ha producido algun error al guardar los permisos del campo de perfil',
    'prp:actions:profile_permissions:save:ok' => 'Se han guardado correctamente los permisos del campo de perfil',
    'prp:actions:profile_permissions:delete:error' => 'Se ha producido algun error al eliminar los permisos del campo de perfil',
    'prp:actions:profile_permissions:delete:ok' => 'Se han eliminado correctamente los permisos del campo de perfil',
    'prp:actions:profile_permissions:delete_all:error' => 'Se ha producido algun error al eliminar los permisos de campos de perfiles',
    'prp:actions:profile_permissions:delete_all:ok' => 'Se han eliminado correctamete los permisos de campos de perfiles',
    'prp:actions:profile_permissions:import:error' => 'Se ha producido algun error al importar los permisos de campos de perfiles',
    'prp:actions:profile_permissions:import:ok' => 'Se han importado correctamente los permisos de campos de perfiles',
    'prp:actions:profile_permissions:export:error' => 'Se ha producido algun error al exportar los permisos de campos de perfiles',
    'prp:actions:profile_permissions:export:ok' => 'Se han exportado correctamente los permisos de campos de perfiles',
    
    // PAGES
    // prp/admin/relation_names
    'prp:pages:admin:relation_names:title' => 'Tipos de relaciones admitidas por la plataforma',
    'prp:pages:admin:relation_names:info' => 'Puedes dar de alta nuevos tipos de relacion, modificar y/o eliminar los ya existentes',
    // prp/test/relations
    'prp:pages:test:relations:title' => 'Relaciones definidas entre los usuarios de la plataforma',
    'prp:pages:test:relations:info' => 'Puedes establecer nuevas relaciones, o eliminar las relaciones existentes',
    // prp/forms/relation_name
    'prp:pages:forms:relation_name:title' => 'Propiedades del tipo de relación',
    // prp/forms/relation
    'prp:pages:forms:relation:title' => 'Establecer nueva relación',
    // prp/admin/module_actions
    'prp:pages:admin:module_actions:title' => 'Acciones de módulos registradas en la plataforma',
    'prp:pages:admin:module_actions:info' => 'Puedes configurar los permisos de cada acción, haciendo click en la acción correspondiente',
    // prp/test/module_actions
    'prp:pages:test:module_actions:title' => 'Acciones de módulos registradas en la plataforma',
    'prp:pages:test:module_actions:info' => 'Puedes dar de alta o eliminar acciones, haciendo click en el botón correspondiente',
    // prp/forms/module_action
    'prp:pages:forms:module_action:title' => 'Propiedades de la acción de modulo',
    // prp/forms/add_module_action
    'prp:pages:forms:add_module_action:title' => 'Establecer nueva acción de modulo',
    // prp/admin/profile_permissions
    'prp:pages:admin:profile_permissions:title' => 'Permisos para las categorías de los campos de perfil registrados en la plataforma',
    'prp:pages:admin:profile_permissions:info' => 'Puedes configurar los permisos de los capmos, haciendo click en la categoría correspondiente',

    // VIEWS
    // prp/relations/names/list
    'prp:views:relations:names:list:title' => 'Tipos de relaciones admitidas por la plataforma',
    //prp/relation/names/actions
    'prp:views:relation_names:actions:title' => 'Acciones',
    'prp:views:relation_names:actions:more_info' => 'Puedes importar y exportar los tipos de relaciones configurados',
    'prp:views:relation_names:actions:add' => 'Añadir',
    'prp:views:relation_names:actions:add:description' => 'Definir un nuevo tipo de relacion',
    'prp:views:relation_names:actions:import' => 'Importar',
    'prp:views:relation_names:actions:import:description' => 'Importar los tipos de relaciones configurados previamente',
    'prp:views:relation_names:actions:export' => 'Exportar',
    'prp:views:relation_names:actions:export:description' => 'Exportar los tipos de relaciones configurados actualmente',
    'prp:views:relation_names:actions:export:confirm' => 'Desea exportar los tipos de relaciones configurados?',
    // prp/relations/user/list
    'prp:views:relations:user:list:title' => 'Relaciones definidas para el usuario %s con otros usuarios:',
    // prp/module_actions/list
    'prp:views:module_actions:list:title' => 'Acciones de módulos registradas en la plataforma',
    //prp/module_actions/actions
    'prp:views:module_actions:actions:title' => 'Acciones',
    'prp:views:module_actions:actions:more_info' => 'Puedes importar y exportar la configuración de las acciones',
    'prp:views:module_actions:actions:import' => 'Importar',
    'prp:views:module_actions:actions:import:description' => 'Importar acciones de modulos configuradas previamente',
    'prp:views:module_actions:actions:export' => 'Exportar',
    'prp:views:module_actions:actions:export:description' => 'Exportar las acciones de modulos configuradas actualmente',
    'prp:views:module_actions:actions:export:confirm' => 'Desea exportar las acciones configuradas?',
    
    // VIEWS/FORMS
    // prp/relations/names/save
    'prp:forms:relations:names:save:title' => 'Tipo de relación',
    'prp:forms:relations:names:save:info' => 'Indica las propiedades del tipo de relación',
    'prp:forms:relations:names:save:relation_name_label' => 'Introduce el codigo de la relacion',
    'prp:forms:relations:names:save:relation_title_label' => 'Introduce el nombre de la relacion',
    'prp:forms:relations:names:save:subject_profiles_label' => 'Marca los perfiles admitidos como "subject" para el tipo de relacion',
    'prp:forms:relations:names:save:object_profiles_label' => 'Marca los perfiles admitidos como "object" para el tipo de relacion',
    'prp:forms:relations:names:save:allowed_profiles_label' => 'Marca los perfiles que pueden establecer el tipo de relacion',
    // prp/relations/names/import
    'prp:forms:relations:names:import:title' => 'Importar tipos de relaciones',
    'prp:forms:relations:names:import:info' => 'Puedes importar los tipos de relaciones guardadas previamente en un fichero',
    'prp:forms:relations:names:import:fileupload_label' => 'Fichero para cargar tipos de relaciones:',
    // prp/relations/add
    'prp:forms:relations:add:title' => 'Establecer relacion para el usuario %s',
    'prp:forms:relations:add:info' => 'Indica las propiedades de la relacion que quieres establecer',
    'prp:forms:relations:add:object_user_label' => 'Selecciona el usuario con el que quieres establecer la relacion',
    'prp:forms:relations:add:relation_name_label' => 'Selecciona el tipo de relacion que quieres establecer con el usuario',
    
    // prp/module_actions/save
    'prp:forms:module_actions:save:title' => 'Accion de modulo',
    'prp:forms:module_actions:save:info' => 'Indica los permisos de la accion del módulo',
    'prp:forms:module_actions:save:name_label' => 'Acción:',
    'prp:forms:module_actions:save:module_label' => 'Módulo:',
    'prp:forms:module_actions:save:requires_profile_label' => 'Requerir perfiles para ejecutar la acción',
    'prp:forms:module_actions:save:required_profiles_label' => 'Permitir ejecutar la acción si el usuario es de uno de los perfiles siguientes',
    'prp:forms:module_actions:save:requires_relation_label' => 'Requerir relacion para ejecutar la acción',
    'prp:forms:module_actions:save:required_relations_label' => 'Permitir ejecutar la acción si el usuario tiene con el otro usuario alguna de la siguientes relaciones',
    'prp:forms:module_actions:save:requires_owner_label' => 'Requerir que el usuario sea el propietario del objecto para ejecutar la acción',
    // prp/module_actions/add
    'prp:forms:module_actions:add:title' => 'Alta de accion de módulo',
    'prp:forms:module_actions:add:info' => 'Indica la acción a dar de alta',
    'prp:forms:module_actions:add:action_name_label' => 'Codigo de la acción:',
    'prp:forms:module_actions:add:action_title_label' => 'Descripción de la acción:',
    'prp:forms:module_actions:add:module_name_label' => 'Codigo del módulo (plugin):',
    // prp/module_actions/import
    'prp:forms:module_actions:import:title' => 'Importar acciones de modulo',
    'prp:forms:module_actions:import:info' => 'Puedes importar las acciones de modulos guardadas previamente en un fichero',
    'prp:forms:module_actions:import:fileupload_label' => 'Fichero para cargar acciones:',
    
    // JS
    // relations
    'prp:js:relations:names:delete:confirm' => '¿Desea eliminar el tipo de relacion indicado?',
    'prp:js:relations:delete:confirm' => '¿Desea eliminar la relacion indicada?',
    'prp:js:relations:delete_all:confirm' => '¿Desea eliminar todas las relaciones del usuario indicado?',

    'prp:js:module_actions:delete:confirm' => '¿Desea eliminar la accion de modulo indicada?',
    
    // OBJETOS
    //prp_module_action
    'prp:object:prp_module_action:required_profiles_label' => 'Perfiles requeridos para poder ejecutar la acción: %s',
    'prp:object:prp_module_action:no_require_profiles_label' => 'No se requieren perfiles para ejecutar la acción',
    'prp:object:prp_module_action:required_relations_label' => 'Relaciones con el usuario requeridas para poder ejecutar la acción: %s',
    'prp:object:prp_module_action:no_require_relations_label' => 'No se requiere relacion con el usuario para ejecutar la acción',
    'prp:object:prp_module_action:requires_owner' => 'Se requiere ser el propietario del objeto para ejecutar la accion',
    'prp:object:prp_module_action:no_requires_owner' => 'No se requiere ser el propietario del objeto para ejecutar la accion',
    'prp:settings:profiles:title' => 'Profiles',
    'prp:settings:profiles:label' => 'Procur@ platform supports the following profiles:',
    'prp:settings:profiles:add' => 'Add new profile:',
    


// permissions/test/add form body
    'prp:permissions:test:add:instructions' => 'Introduce las propiedades de la nueva accion',
    'prp:permissions:test:add:action' => 'Indica el nombre de la nueva accion',
    'prp:permissions:test:add:module' => 'Indica el modulo',
    //prp/relation_names/list
    'prp:relation_names:list:title' => 'Tipos de relaciones a establecer entre los usuarios',
    'prp:relation_names:list:no_names' => 'Todavia no se ha definido ninguna relacion, usa el boton "Add" para definir relaciones',
// mensajes de error
    'prp:error:no_save' => 'Se ha producido algun error al guardar el tipo de relacion',
    'prp:error:no_delete' => 'Se ha producido algun error al eliminar el tipo de relacion',
    'prp:status:save' => 'Se ha guardado correctamente el tipo de relacion',
    'prp:error:delete' => 'Se ha eliminado correctamente el tipo de relacion',
);

//TODO: renombrar a es.php, y crear cadenas para inglés
add_translation('es', $mapping);
add_translation('en', $mapping);
