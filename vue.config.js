module.exports = {
    configureWebpack: {
        resolve: {
            alias: {
                '@': '/frontend'
            }
        },
        entry: {
            app: './frontend/main.js'
        }
    },
    outputDir: './build',
    publicPath: process.env.NODE_ENV === 'production'
        ? '/build/'
        : '/',
    chainWebpack: config => {
        config
            .plugin('html')
            .tap(args => {
                args[0].template = './frontend/public/index.html'
                return args
            })
    }
}
