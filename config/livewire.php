<?php

return [

    /*
    |---------------------------------------------------------------------------
    | Class Namespace
    |---------------------------------------------------------------------------
    |
    | Este valor establece el espacio de nombres raíz para las clases de componentes de Livewire en
    | tu aplicación. Este valor modificará la ubicación donde el sistema de detección automática
    | busca los componentes. También es utilizado por los comandos de creación de archivos.
    |
    */

    'class_namespace' => 'App\\Livewire',

    /*
    |---------------------------------------------------------------------------
    | View Path
    |---------------------------------------------------------------------------
    |
    | Este valor se utiliza para especificar dónde se almacenan las plantillas Blade de los componentes Livewire
    | al ejecutar comandos de creación de archivos como `artisan make:livewire`.
    | También se utiliza si decides omitir el método `render()` de un componente.
    |
    */

    'view_path' => resource_path('views/livewire'),

    /*
    |---------------------------------------------------------------------------
    | Layout
    |---------------------------------------------------------------------------
    | La vista que se utilizará como diseño (layout) al renderizar un único componente
    | como una página completa mediante `Route::get('/post/create', CreatePost::class);`.
    | En este caso, la vista devuelta por CreatePost se renderizará dentro de `$slot`.
    |
    */

    'layout' => 'components.layouts.app',

    /*
    |---------------------------------------------------------------------------
    | Lazy Loading Placeholder
    |---------------------------------------------------------------------------
    | Livewire te permite cargar de forma diferida (*lazy load*) aquellos componentes que, de otro modo, ralentizarían
    | la carga inicial de la página. Cada componente puede tener un marcador de posición personalizado o
    | puedes definir la vista de marcador de posición predeterminada para todos los componentes a continuación.
    |
    */

    'lazy_placeholder' => null,

    /*
    |---------------------------------------------------------------------------
    | Temporary File Uploads
    |---------------------------------------------------------------------------
    |
    | Livewire gestiona la carga de archivos almacenándolos en un directorio temporal
    | antes de que se guarden de forma permanente. Todas las cargas de archivos se dirigen a
    | un endpoint global para el almacenamiento temporal. Puedes configurarlo a continuación:
    |
    */

    'temporary_file_upload' => [
        'disk' => null,        // Example: 'local', 's3'              | Default: 'default'
        'rules' => null,       // Example: ['file', 'mimes:png,jpg']  | Default: ['required', 'file', 'max:12288'] (12MB)
        'directory' => null,   // Example: 'tmp'                      | Default: 'livewire-tmp'
        'middleware' => null,  // Example: 'throttle:5,1'             | Default: 'throttle:60,1'
        'preview_mimes' => [   // Supported file types for temporary pre-signed file URLs...
            'png', 'gif', 'bmp', 'svg', 'wav', 'mp4',
            'mov', 'avi', 'wmv', 'mp3', 'm4a',
            'jpg', 'jpeg', 'mpga', 'webp', 'wma',
        ],
        'max_upload_time' => 5, // Max duration (in minutes) before an upload is invalidated...
        'cleanup' => true, // Should cleanup temporary uploads older than 24 hrs...
    ],

    /*
    |---------------------------------------------------------------------------
    | Render On Redirect
    |---------------------------------------------------------------------------
    |
    | Este valor determina si Livewire ejecutará el método `render()` de un componente
    | después de que se haya iniciado una redirección mediante algo como `redirect(...)`.
    | Establecerlo en `true` hará que la vista se renderice una vez más antes de redirigir.
    |
    */

    'render_on_redirect' => false,

    /*
    |---------------------------------------------------------------------------
    | Eloquent Model Binding
    |---------------------------------------------------------------------------
    |
    | Las versiones anteriores de Livewire permitían vincular directamente propiedades 
    | de modelos Eloquent mediante `wire:model` por defecto. Sin embargo, este 
    | comportamiento se ha considerado demasiado "mágico" y, por ello, se ha condicionado 
    | a una bandera de funcionalidad (*feature flag*).
    |
    */

    'legacy_model_binding' => false,

    /*
    |---------------------------------------------------------------------------
    | Auto-inject Frontend Assets
    |---------------------------------------------------------------------------
    |
    | Por defecto, Livewire inyecta automáticamente su JavaScript y CSS en el
    | <head> y el <body> de las páginas que contienen componentes de Livewire. Si se deshabilita
    | este comportamiento, es necesario utilizar @livewireStyles y @livewireScripts.
    |
    */

    'inject_assets' => true,

    /*
    |---------------------------------------------------------------------------
    | Navigate (SPA mode)
    |---------------------------------------------------------------------------
    |
    | Al añadir `wire:navigate` a los enlaces de tu aplicación Livewire, Livewire
    | evitará el manejo predeterminado de los enlaces y, en su lugar, solicitará dichas páginas
    | mediante AJAX, creando un efecto similar al de una SPA. Configura este comportamiento aquí.
    |
    */

    'navigate' => [
        'show_progress_bar' => true,
        'progress_bar_color' => '#2299dd',
    ],

    /*
    |---------------------------------------------------------------------------
    | HTML Morph Markers
    |---------------------------------------------------------------------------
    |
    | Livewire «transforma» de forma inteligente el HTML existente en el HTML recién renderizado
    | tras cada actualización. Para hacer este proceso más fiable, Livewire inyecta
    | «marcadores» en el código Blade renderizado, rodeando las directivas @if, @class y @foreach.
    |
    */

    'inject_morph_markers' => true,

    /*
    |---------------------------------------------------------------------------
    | Smart Wire Keys
    |---------------------------------------------------------------------------
    |
    | Livewire utiliza bucles y las claves empleadas en ellos para generar claves inteligentes que
    | se aplican a los componentes anidados que carecen de ellas. Esto hace que el uso de
    | componentes anidados sea más fiable, al garantizar que todos cuenten con claves.
    |
    */

    'smart_wire_keys' => false,

    /*
    |---------------------------------------------------------------------------
    | Pagination Theme
    |---------------------------------------------------------------------------
    |
    | Al habilitar la funcionalidad de paginación de Livewire mediante el trait `WithPagination`,
    | Livewire utilizará plantillas de Tailwind para renderizar las vistas de paginación
    | en la página. Si prefieres utilizar Bootstrap CSS, puedes especificar: "bootstrap"
    |
    */

    'pagination_theme' => 'tailwind',

    /*
    |---------------------------------------------------------------------------
    | Release Token
    |---------------------------------------------------------------------------
    |
    | Este token se almacena en el lado del cliente y se envía con cada solicitud para 
    | verificar la sesión del usuario y comprobar si una nueva versión la ha invalidado. 
    | Si existe una discrepancia, se producirá un error y se solicitará actualizar el 
    | navegador.
    |
    */

    'release_token' => 'a',
];
