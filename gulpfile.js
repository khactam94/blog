var gulp = require('gulp');
var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */
gulp.task("copyfiles", function() {
    var source = "vendor/bower_dl/";
    var destination = 'public/vendor/';
    var copy = {
        'jquery/dist/jquery.js' : 'jquery',
        'bootstrap/dist/**' : 'bootstrap',
        'bootstrap/dist/fonts/**' : 'fonts',
        'bootstrap/less/**' : 'less/bootstrap',
        'fontawesome/less/**' : 'less/fontawesome',
    };
    var keys = Object.keys(foo);
    // Copy jQuery, Bootstrap, and FontAwesome
    for(srcfile in keys){
        gulp.src(source + srcfile)
            .pipe(gulp.dest(destination + copy[srcfile]));
    }
});

elixir(function(mix) {
    // Combine scripts
    mix.scripts([
            'jquery/dist/jquery.min.js',
            'bootstrap/dist/js/bootstrap.min.js',
            'fastclick/lib/fastclick.js',
            'nprogress/nprogress.js',
            'bootstrap-toggle/js/bootstrap-toggle.min.js',
            'moment/min/moment.min.js',
            'fullcalendar/dist/fullcalendar.min.js',
            'iCheck/icheck.min.js',
            'datatables.net/js/jquery.dataTables.min.js'
        ],
        'public/backend/js/vendor.js',
        'vendor/bower_dl'
    );

    // Compile css
    mix.styles([
            'font-awesome/css/font-awesome.min.css',
            'nprogress/nprogress.css',
            'bootstrap-toggle/css/bootstrap-toggle.min.css',
            'fullcalendar/dist/fullcalendar.min.css',
            'iCheck/skins/flat/green.css',
            'datatables.net-dt/css/jquery.dataTables.min.css'
        ],
        'public/backend/css/vendor.css',
        'vendor/bower_dl'
    );
});