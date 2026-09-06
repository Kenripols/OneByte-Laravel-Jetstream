<?php

return [

    'models' => [

        /*
         *Al utilizar el trait "HasPermissions" de este paquete, es necesario saber qué
         * modelo de Eloquent se utilizará para recuperar los permisos. Por supuesto,
         * a menudo se trata simplemente del modelo "Permission", pero puedes utilizar el que prefieras.
         *
         * El modelo que desees utilizar como modelo de permiso debe implementar el
         * contrato `Spatie\Permission\Contracts\Permission`.
         */

        'permission' => Spatie\Permission\Models\Permission::class,

        /*
         * Al utilizar el trait "HasRoles" de este paquete, es necesario saber qué
         * modelo de Eloquent debe emplearse para recuperar los roles. Por supuesto,
         * a menudo se trata simplemente del modelo "Role", pero puedes utilizar el que prefieras.
         *
         * El modelo que desees utilizar como modelo de rol debe implementar el
         * contrato `Spatie\Permission\Contracts\Role`.
         */

        'role' => Spatie\Permission\Models\Role::class,

    ],

    'table_names' => [

        /*
         * Al utilizar el trait "HasRoles" de este paquete, necesitamos saber qué
         * tabla debe emplearse para recuperar los roles. Hemos elegido un valor
         * predeterminado básico, pero puedes cambiarlo fácilmente por cualquier otra tabla que prefieras.
         */

        'roles' => 'roles',

        /*
         * Al utilizar el trait "HasPermissions" de este paquete, es necesario saber qué
         * tabla debe emplearse para recuperar los permisos. Hemos seleccionado un valor
         * predeterminado básico, pero puedes cambiarlo fácilmente por cualquier otra tabla que prefieras.
         */

        'permissions' => 'permissions',

        /*
         * Al utilizar el trait "HasPermissions" de este paquete, es necesario saber qué
         * tabla debe emplearse para recuperar los permisos de tus modelos. Hemos elegido un
         * valor predeterminado básico, pero puedes cambiarlo fácilmente por cualquier otra tabla que prefieras.
         */

        'model_has_permissions' => 'model_has_permissions',

        /*
         * Al utilizar el trait "HasRoles" de este paquete, es necesario saber qué
         * tabla debe emplearse para recuperar los roles de tus modelos. Hemos elegido un
         * valor predeterminado básico, pero puedes cambiarlo fácilmente por cualquier otra tabla que prefieras.
         */

        'model_has_roles' => 'model_has_roles',

        /*
         * Al utilizar el trait "HasRoles" de este paquete, es necesario saber qué
         * tabla debe emplearse para recuperar los permisos de los roles. Hemos elegido un
         * valor predeterminado básico, pero puedes cambiarlo fácilmente por cualquier otra tabla que prefieras.
         */

        'role_has_permissions' => 'role_has_permissions',
    ],

    'column_names' => [
        /*
         * Cambia esto si deseas asignar nombres distintos a los predeterminados a las tablas dinámicas relacionadas.
         */
        'role_pivot_key' => null, // default 'role_id',
        'permission_pivot_key' => null, // default 'permission_id',

        /*
         * Cambia esto si deseas asignar un nombre distinto a `model_id` para la clave primaria del modelo relacionado.
         *
         * Por ejemplo, esto sería útil si todas tus claves primarias son UUID. En
         * ese caso, nómbralo `model_uuid`.
         */

        'model_morph_key' => 'model_id',

        /*
         * Cambia esto si deseas utilizar la funcionalidad de equipos y la clave foránea
         * de tu modelo relacionado es distinta de `team_id`.
         */

        'team_foreign_key' => 'team_id',
    ],

    /*
     * Cuando se establece en `true`, el método para verificar permisos se registrará en la puerta (*gate*).
     * Establézcalo en `false` si desea implementar una lógica personalizada para verificar permisos.
     */

    'register_permission_check_method' => true,

    /*
     * Cuando se establece en `true`, se registrará el oyente del evento `Laravel\Octane\Events\OperationTerminated`;
     * esto actualizará los permisos en cada evento `TickTerminated`, `TaskTerminated` y `RequestTerminated`.
     * NOTA: Esto no debería ser necesario en la mayoría de los casos, pero una combinación de Octane y Vapor se benefició de ello.
     */
    'register_octane_reset_listener' => false,

    /*
     * Los eventos se dispararán cuando un rol o un permiso sea assigned/unassigned:
     * \Spatie\Permission\Events\RoleAttached
     * \Spatie\Permission\Events\RoleDetached
     * \Spatie\Permission\Events\PermissionAttached
     * \Spatie\Permission\Events\PermissionDetached
     *
     * Para habilitarlo, establézcalo en *true* y, a continuación, cree oyentes para supervisar estos eventos.
     */
    'events_enabled' => false,

    /*
     * Teams Feature.
     * Cuando se establece en `true`, el paquete implementa equipos utilizando la clave foránea `team_foreign_key`.
     * Si desea que las migraciones registren la clave foránea `team_foreign_key`, debe
     * establecer esta opción en `true` antes de ejecutar la migración.
     * Si ya ha realizado la migración, deberá crear una nueva para añadir también
     * `team_foreign_key` a las tablas `roles`, `model_has_roles` y `model_has_permissions`
     * (consulte la versión más reciente del archivo de migración de este paquete).
     */

    'teams' => false,

    /*
     *La clase que se debe utilizar para resolver los permisos team id
     */
    'team_resolver' => \Spatie\Permission\DefaultTeamResolver::class,

    /*
     * Passport Client Credentials Grant
     * Cuando se establece en `true`, el paquete utilizará el cliente de Passport para verificar los permisos.
     */

    'use_passport_client_credentials' => false,

    /*
     * Cuando se establece en `true`, los nombres de los permisos requeridos se añaden a los mensajes de excepción.
     * Esto podría considerarse una fuga de información en algunos contextos, por lo que la configuración
     * predeterminada es `false` para garantizar la máxima seguridad.
     */

    'display_permission_in_exception' => false,

    /*
     * Cuando se establece en `true`, los nombres de los roles requeridos se incluyen en los mensajes de excepción.
     * Esto podría considerarse una fuga de información en algunos contextos, por lo que la configuración
     * predeterminada es `false` para garantizar la máxima seguridad.
     */

    'display_role_in_exception' => false,

    /*
     * Por defecto, las búsquedas de permisos con comodines están deshabilitadas.
     * Consulte la documentación para conocer la sintaxis admitida.
     */

    'enable_wildcard_permission' => false,

    /*
     * La clase que se utilizará para interpretar los permisos con comodines.
     * Si necesita modificar los delimitadores, sobrescriba la clase y especifique su nombre aquí.
     */
    // 'wildcard_permission' => Spatie\Permission\WildcardPermission::class,

    /* Cache-specific settings */

    'cache' => [

        /*
         * De forma predeterminada, todos los permisos se almacenan en caché durante 24 horas para mejorar el rendimiento.
         * Cuando se actualizan los permisos o roles, la caché se vacía automáticamente.
         */

        'expiration_time' => \DateInterval::createFromDateString('24 hours'),

        /*
         * La key de caché utilizada para almacenar todos los permisos.
         */

        'key' => 'spatie.permission.cache',

        /*
         * Opcionalmente, puedes indicar un controlador de caché específico para el 
         * almacenamiento en caché de permisos y roles, utilizando cualquiera de los 
         * controladores `store` enumerados en el archivo de configuración `cache.php`. 
         * Usar 'default' aquí significa utilizar el valor predeterminado definido 
         * en `cache.php`.
         */

        'store' => 'default',
    ],
];
