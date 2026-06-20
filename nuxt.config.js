export default {
  mode: 'spa',
  head: {
    title: 'Vokagigs - Platform Gig Online Terpercaya',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: 'Vokagigs - Platform Gig Online Terpercaya untuk menemukan pekerja lepas profesional' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
      { rel: 'stylesheet', href: 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@700;800;900&display=swap' }
    ]
  },
  css: ['@/assets/css/main.css'],
  plugins: [],
  buildModules: [],
  modules: [],
  server: {
    port: 3000
  },
  router: {
    middleware: []
  }
}
