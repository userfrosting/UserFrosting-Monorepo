const Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.UF_MODE || 'dev');
}

Encore
    .setOutputPath('public/assets')
    .setPublicPath('/assets/')
    .addEntry('app', './app/assets/main.js')
    .addEntry('dashboard', './app/assets/dashboard.js')
    .addEntry('page.dashboard', './app/assets/page.dashboard.js')
    .addEntry('page.activities', './app/assets/page.activities.js')
    .addEntry('page.roles', './app/assets/page.roles.js')
    .addEntry('page.user', './app/assets/page.user.js')
    .addEntry('page.users', './app/assets/page.users.js')
    .addEntry('page.register', './node_modules/theme-adminlte/app/assets/register.js')
    .addEntry('page.sign-in', './node_modules/theme-adminlte/app/assets/sign-in.js')
    .addEntry('page.forgot-password', './node_modules/theme-adminlte/app/assets/forgot-password.js')
    .addEntry('page.resend-verification', './node_modules/theme-adminlte/app/assets/resend-verification.js')
    .addEntry('page.set-or-reset-password', './node_modules/theme-adminlte/app/assets/set-or-reset-password.js')
    .addEntry('page.account-settings', './node_modules/theme-adminlte/app/assets/account-settings.js')
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })
    .enableSassLoader()
    .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();