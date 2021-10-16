const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const cleanCSS = require('gulp-clean-css');
const purgecss = require('gulp-purgecss');
const purgecssWordpress = require('purgecss-with-wordpress');
const cssMinify = require('gulp-css-minify');

gulp.task('default', () => {
    return gulp
        .src('./sass/style.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./'))
        .pipe(gulp.dest('./sass/'))
        .pipe(
            purgecss({
                content: [
                    'header.php',
                    'footer.php',
                    'category.php',
                    'archive.php',
                    '404.php',
                    'comments.php',
                    'functions.php',
                    'page.php',
                    'search.php',
                    'searchform.php',
                    'sidebar.php',
                    'single.php',
                    'tag.php',
                    'templates/**/*.php',
                    'template-parts/**/*.php',
                    'bigcommerce/**/*.php',
                    'inc/**/*.php',
                    'modules/**/*.php',
                    'modules/**/*.js',
                    'page-*.php',
                    'js/**/*.js',
                ],
                safelist: [
                    ...purgecssWordpress.safelist,
                    //general               
                    /^content/,
                    /^article/,
                    /^feature/,
                    /^filter/,
                    /^heading/,
                    /shop/,
                    /^form-check/,
                    /^clear-btn/,
                    /promo/,
                    /^large/,
                    /^lity/,
                    /^mega-/,
                    /menu/,
                    /slick/,
                    /^sbi/,
                    /^swiper/,
                    /^sorting/,	
                    /wpfp/,
                    //bigc
                    /^bc-*/,
                    /^bigcommerce/,
                    /cart/,
                    /product-detail/,
                    /yotpo/,
                    /font-color-primary/,
                    /review/,
                    /^write/,
                    //custom home
                    /hero/,  
                    /^custom-gallery/,
                    //gravity forms
                    /gfield/,
                    /gform/,
                    /ginput/,
                    //ultimate member
                    /^um/,
                    /um-/,
                    /data-tab/,	
                    /signout/,                                                
                ],
            })
        )
        .pipe(cleanCSS({ compatibility: 'ie11' }))
        .pipe(cssMinify())
        .pipe(gulp.dest('./sass/style.purge'));

});

gulp.task('watch', () => {
    gulp.watch('./sass/**/*.scss', gulp.series('default'));
});