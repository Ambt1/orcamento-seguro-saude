const gulp = require('gulp');
const watch = require('gulp-watch');
const gulpZip = require('gulp-zip');

const sourceFiles = 'app/**/*.*';
const distFiles = 'wp/wp-content/plugins/calculo-segurosaude';
 
gulp.task('copy', function() {
  gulp.src(sourceFiles)
      .pipe(gulp.dest(distFiles));
});

gulp.task('watch', function(){
	gulp.watch('app/**/*.*', ['copy']) ;
  // gulp.watch(sourceFiles, function(){
  //   gulp.src(sourceFiles)
  //     .pipe(gulp.dest(distFiles));
  // })
});

gulp.task('build', function(){
  gulp.src(sourceFiles)
      .pipe(gulpZip(`saude-plugin.zip`))
      .pipe(gulp.dest('dist'))
});