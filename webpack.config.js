var Encore = require('@symfony/webpack-encore');

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if you JavaScript imports CSS.
     */


    .addEntry('userjs', './assets/js/user.js')  
    .addStyleEntry('user', './assets/css/user.css') 
    .addEntry('opinajs', './assets/js/opina.js')    
    .addEntry('app', './assets/js/app.js')
    //.addStyleEntry('app', './assets/css/app.css')
    .addStyleEntry('opina', './assets/css/opina.css')
    .addEntry('saludjs', './assets/js/saludjs.js')    
    .addStyleEntry('salud', './assets/css/salud.css')
    .addStyleEntry('telefono', './assets/css/telefono.css')
    .addStyleEntry('ayto', './assets/css/ayto.css')
    .addStyleEntry('inicio', './assets/css/inicio.css')
    .addEntry('incidenciasjs', './assets/js/incidenciajs.js')
    .addStyleEntry('incidenciacss', './assets/css/incidenciacss.css')
    .addStyleEntry('register', './assets/css/register_footer.css')
    .addStyleEntry('vecino', './assets/css/vecino.css')
    .addEntry('eventojs', './assets/js/evento.js')  
    .addStyleEntry('evento', './assets/css/evento.css')
  

    .enableSingleRuntimeChunk()


    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // enables Sass/SCSS support
    //.enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment if you're having problems with a jQuery plugin
    .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
