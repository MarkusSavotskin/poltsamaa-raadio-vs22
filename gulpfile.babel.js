import gulp from 'gulp';
import newer from 'gulp-newer';
import plumber from 'gulp-plumber';
import notifier from 'node-notifier';
import imagemin from 'gulp-imagemin';
import rename from 'gulp-rename';
import gulpSass from 'gulp-sass';
import sourcemaps from 'gulp-sourcemaps';
import postcss from 'gulp-postcss';
import postcssAssets from 'postcss-assets';
import path from 'path';
import webpack from 'webpack-stream';
import UglifyJsPlugin from 'terser-webpack-plugin';
import autoprefixer from 'autoprefixer';
import cssMqpacker from 'css-mqpacker';
import sortCSSmq from 'sort-css-media-queries';
import cssnano from 'cssnano';
import shell from 'gulp-shell';
import replace from 'gulp-replace';
import gulpStylelint from 'gulp-stylelint';
import * as dartSass from 'sass';
import fs from 'fs';

/**
 * Configuration.
 */
const sass = gulpSass(dartSass);
const __dirname = path.dirname(new URL(import.meta.url).pathname);
const projectUrlName = 'starter-theme';
const projectUrl = process.env.TYPE === 'localhost' ? `localhost/${projectUrlName}` : `${projectUrlName}.test`;
const projectName = path.basename(__dirname);
const enableNotify = true;
const dir = {
  src: './',
  build: './',
};

const php = {
  src: `${dir.src}**/*.php`,
  build: dir.build,
};

const images = {
  src: `${dir.src}assets/src/img/**/*`,
  build: `${dir.build}assets/dist/img/`,
};

const css = {
  src: `${dir.src}assets/src/scss/main.scss`,
  adminsrc: `${dir.src}assets/src/scss/admin-main.scss`,
  watch: `${dir.src}assets/src/scss/**/*`,
  build: dir.build,
  sassOpts: {
    outputStyle: 'compressed',
    imagePath: images.build,
    precision: 3,
    errLogToConsole: true,
  },
  processors: [
    postcssAssets({
      loadPaths: ['assets/dist/img/', 'assets/dist/img/svg'],
      basePath: dir.build,
      baseUrl: `/wp-content/themes/${projectName}/`,
    }),
    autoprefixer,
    cssMqpacker({
      sort: sortCSSmq.desktopFirst,
    }),
  ],
};

if (process.env.NODE_ENV === 'production') {
  css.processors.push(cssnano);
}

const js = {
  src: `${dir.src}assets/src/js/app.js`,
  watch: [`${dir.src}assets/src/js/**/*`, `!${dir.src}assets/src/js/components/admin/**/*`],
  build: `${dir.build}assets/dist/js/`,
  filename: {
    dev: 'bundle.min.js',
    build: 'bundle.min.js',
  },
};

const adminsrc = {
  src: `${dir.src}assets/src/js/admin.js`,
  watch: `${dir.src}assets/src/js/components/admin/**/*`,
  build: `${dir.build}assets/dist/js/`,
  filename: {
    dev: 'admin.bundle.min.js',
    build: 'admin.bundle.min.js',
  },
};

const commonWebpackConfig = {
  watch: false,
  mode: 'development',
  devtool: 'eval-cheap-module-source-map',
  externals: {
    jquery: 'jQuery',
  },
  module: {
    rules: [
      {
        test: /\.js?$/,
        use: {
          loader: 'babel-loader',
          options: {
            exclude: /node_modules/,
            babelrc: true,
          },
        },
      },
      {
        test: /\.css$/,
        use: ['style-loader', 'css-loader'],
      },
      {
        test: /\.(png|jpe?g|gif|svg|eot|ttf|woff|woff2)$/,
        loader: 'url-loader',
        options: {
          limit: 8192,
        },
      },
    ],
  },
  resolve: {
    modules: [path.resolve(__dirname), 'node_modules'],
  },
};

let webPackConfig = {
  entry: js.src,
  output: {
    filename: js.filename.dev,
    path: path.resolve(js.build),
  },
  ...commonWebpackConfig,
};

let adminwebPackConfig = {
  entry: adminsrc.src,
  output: {
    filename: adminsrc.filename.dev,
    path: path.resolve(js.build),
  },
  ...commonWebpackConfig,
};

if (process.env.NODE_ENV === 'production') {
  webPackConfig = {
    ...webPackConfig,
    watch: false,
    mode: 'production',
    optimization: {
      minimizer: [
        new UglifyJsPlugin({
          terserOptions: {
            parallel: true,
            output: {
              comments: false,
            },
            toplevel: true,
          },
        }),
      ],
    },
  };
  delete webPackConfig.devtool;
  adminwebPackConfig = {
    ...adminwebPackConfig,
    watch: false,
    mode: 'production',
    optimization: {
      minimizer: [
        new UglifyJsPlugin({
          terserOptions: {
            parallel: true,
            output: {
              comments: false,
            },
            toplevel: true,
          },
        }),
      ],
    },
  };
  delete adminwebPackConfig.devtool;
}

const onError = () => {
  if (enableNotify) {
    notifier.notify({
      title: 'Gulp Task Error',
      message: 'Check the console.',
    });
  }
};

const imagesTask = () => {
  return gulp
    .src(images.src)
    .pipe(plumber({ errorHandle: onError }))
    .pipe(newer(images.build))
    .pipe(imagemin())
    .pipe(gulp.dest(images.build));
};

const cssTask = async () => {
  let $retVal = gulp.src(css.src).pipe(plumber({ errorHandle: onError }));

  if (process.env.NODE_ENV !== 'production') {
    $retVal = $retVal.pipe(sourcemaps.init());
  }

  $retVal = $retVal
    .pipe(
      sass(css.sassOpts).on('error', function (err) {
        console.log(err.toString());
        return onError();
      })
    )
    .pipe(postcss(css.processors))
    .pipe(
      rename({
        basename: 'style',
      })
    );

  if (process.env.NODE_ENV !== 'production') {
    $retVal = $retVal.pipe(sourcemaps.write());
  }

  const packageData = JSON.parse(fs.readFileSync('./package.json', 'utf-8'));
  $retVal = $retVal.pipe(replace('__PR_THEME_VERSION__', packageData.version));
  $retVal = $retVal.pipe(gulp.dest(css.build));

  return $retVal;
};

const lintCssTask = () => {
  return gulp.src(css.watch).pipe(
    gulpStylelint({
      reporters: [{ formatter: 'string', console: true }],
    })
  );
};

const admincssTask = async () => {
  let $retVal = gulp.src(css.adminsrc).pipe(plumber({ errorHandle: onError }));

  if (process.env.NODE_ENV !== 'production') {
    $retVal = $retVal.pipe(sourcemaps.init());
  }

  $retVal = $retVal
    .pipe(
      sass(css.sassOpts).on('error', function (err) {
        console.log(err.toString());
        return onError();
      })
    )
    .pipe(postcss(css.processors))
    .pipe(
      rename({
        basename: 'admin-style',
      })
    );

  if (process.env.NODE_ENV !== 'production') {
    $retVal = $retVal.pipe(sourcemaps.write());
  }

  const packageData = JSON.parse(fs.readFileSync('./package.json', 'utf-8'));
  $retVal = $retVal.pipe(replace('__PR_THEME_VERSION__', packageData.version));
  $retVal = $retVal.pipe(gulp.dest(css.build));

  return $retVal;
};

const jsTask = async (webpackConfig) => {
  return gulp
    .src(webpackConfig.entry)
    .pipe(plumber({ errorHandle: onError }))
    .pipe(webpack(webpackConfig))
    .pipe(gulp.dest(webpackConfig.output.path));
};

const bumpVersion = () => {
  return gulp.src(js.src).pipe(shell(['npm version patch']));
};

const serve = (done) => {
  done();
};

const reload = (done) => {
  done();
};

const imagesAndLintCss = gulp.parallel(imagesTask, lintCssTask);
const buildTasks = gulp.parallel(admincssTask, cssTask, jsTask.bind(null, webPackConfig));
const adminjsBuild = jsTask.bind(null, adminwebPackConfig);

const watchEverything = () => {
  gulp.watch(php.src, gulp.series(reload));
  gulp.watch(images.src, gulp.series(imagesTask));
  gulp.watch(css.watch, gulp.series(lintCssTask, gulp.parallel(cssTask, admincssTask)));
  gulp.watch(js.watch, gulp.series(jsTask.bind(null, webPackConfig)));
  gulp.watch(adminsrc.watch, gulp.series(adminjsBuild));
};

const development = gulp.series(imagesAndLintCss, buildTasks);
const build = gulp.series(imagesAndLintCss, bumpVersion, buildTasks);
const defaultTask = gulp.series(development, serve, watchEverything);

export { imagesTask, cssTask, admincssTask, jsTask, watchEverything, build };
export default defaultTask;
