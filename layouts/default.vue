<template>
  <div>
    <GridBackground />
    <nav class="navbar" v-if="!isMobile">
      <div class="navbar-container">
        <NuxtLink to="/" class="navbar-logo">
          <span class="logo-text">Vokagigs</span>
        </NuxtLink>
        <div class="navbar-links">
          <NuxtLink to="/" class="nav-link">Beranda</NuxtLink>
          <a href="/#features" class="nav-link">Fitur</a>
          <a href="/#categories" class="nav-link">Kategori</a>
          <a href="/#how-it-works" class="nav-link">Cara Kerja</a>
        </div>
        <div class="navbar-actions">
          <NuxtLink to="/login" class="btn btn-outline btn-sm">Masuk</NuxtLink>
          <NuxtLink to="/login?tab=register" class="btn btn-primary btn-sm">Daftar</NuxtLink>
        </div>
      </div>
    </nav>

    <main class="main-content" :class="{ 'has-mobile-nav': isMobile }">
      <Nuxt />
    </main>

    <nav class="mobile-bottom-nav" v-if="isMobile">
      <NuxtLink to="/" class="mobile-nav-item" :class="{ active: $nuxt.$route.path === '/' }">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        <span>Beranda</span>
      </NuxtLink>
      <a href="/#features" class="mobile-nav-item">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
        <span>Fitur</span>
      </a>
      <NuxtLink to="/login" class="mobile-nav-item" :class="{ active: $nuxt.$route.path === '/login' }">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
        <span>Masuk</span>
      </NuxtLink>
      <NuxtLink to="/dashboard" class="mobile-nav-item" :class="{ active: $nuxt.$route.path === '/dashboard' }">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9"/><rect x="14" y="3" width="7" height="5"/><rect x="14" y="12" width="7" height="9"/><rect x="3" y="16" width="7" height="5"/></svg>
        <span>Dashboard</span>
      </NuxtLink>
    </nav>

    <footer class="footer">
      <div class="container">
        <div class="footer-content">
          <div class="footer-brand">
            <h3>Vokagigs</h3>
            <p>Platform gig online terpercaya untuk menghubungkan talenta terbaik dengan proyek terbaik.</p>
          </div>
          <div class="footer-links">
            <div class="footer-col">
              <h4>Navigasi</h4>
              <a href="/">Beranda</a>
              <a href="/#features">Fitur</a>
              <a href="/#categories">Kategori</a>
              <a href="/#how-it-works">Cara Kerja</a>
            </div>
            <div class="footer-col">
              <h4>Akun</h4>
              <a href="/login">Masuk</a>
              <a href="/login?tab=register">Daftar</a>
              <a href="/dashboard">Dashboard</a>
            </div>
          </div>
        </div>
        <div class="footer-bottom">
          <p>&copy; 2026 Vokagigs. All rights reserved.</p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script>
export default {
  name: 'DefaultLayout',
  data() {
    return {
      isMobile: false
    }
  },
  mounted() {
    this.checkScreen()
    window.addEventListener('resize', this.checkScreen)
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.checkScreen)
  },
  methods: {
    checkScreen() {
      this.isMobile = window.innerWidth < 768
    }
  }
}
</script>

<style scoped>
.navbar {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 1000;
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(20px);
  border-bottom: 1px solid rgba(0, 255, 17, 0.1);
  padding: 0 20px;
}

.navbar-container {
  max-width: 1200px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 70px;
}

.navbar-logo {
  text-decoration: none;
}

.logo-text {
  font-family: 'Playfair Display', Georgia, serif;
  font-size: 28px;
  font-weight: 800;
  color: #111111;
  letter-spacing: -0.5px;
}

.logo-text span {
  color: #00ff11;
}

.navbar-links {
  display: flex;
  align-items: center;
  gap: 32px;
}

.nav-link {
  font-family: 'Inter', sans-serif;
  font-size: 15px;
  font-weight: 500;
  color: #333;
  text-decoration: none;
  transition: color 0.3s ease;
  position: relative;
}

.nav-link::after {
  content: '';
  position: absolute;
  bottom: -4px;
  left: 0;
  width: 0;
  height: 2px;
  background: #00ff11;
  transition: width 0.3s ease;
}

.nav-link:hover {
  color: #00ff11;
}

.nav-link:hover::after {
  width: 100%;
}

.navbar-actions {
  display: flex;
  align-items: center;
  gap: 12px;
}

.btn-sm {
  padding: 8px 20px;
  font-size: 14px;
}

.main-content {
  min-height: 100vh;
  padding-top: 70px;
}

.main-content.has-mobile-nav {
  padding-bottom: 80px;
}

.mobile-bottom-nav {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  z-index: 1000;
  background: rgba(255, 255, 255, 0.98);
  backdrop-filter: blur(20px);
  border-top: 1px solid rgba(0, 255, 17, 0.15);
  display: flex;
  justify-content: space-around;
  align-items: center;
  height: 75px;
  padding: 8px 0;
  box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.05);
}

.mobile-nav-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 2px;
  text-decoration: none;
  color: #999;
  font-family: 'Inter', sans-serif;
  font-size: 11px;
  font-weight: 500;
  transition: color 0.3s ease;
  padding: 4px 12px;
  border-radius: 8px;
}

.mobile-nav-item svg {
  width: 22px;
  height: 22px;
}

.mobile-nav-item.active,
.mobile-nav-item:hover {
  color: #00ff11;
}

.footer {
  background: #111111;
  color: #ffffff;
  padding: 60px 0 30px;
  position: relative;
  z-index: 1;
}

.footer-content {
  display: grid;
  grid-template-columns: 1.5fr 1fr;
  gap: 60px;
  margin-bottom: 40px;
}

.footer-brand h3 {
  font-family: 'Playfair Display', Georgia, serif;
  font-size: 28px;
  font-weight: 800;
  margin-bottom: 12px;
  color: #00ff11;
}

.footer-brand p {
  font-family: 'Inter', sans-serif;
  font-size: 15px;
  color: #aaa;
  line-height: 1.7;
  max-width: 400px;
}

.footer-links {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 40px;
}

.footer-col h4 {
  font-family: 'Inter', sans-serif;
  font-size: 16px;
  font-weight: 600;
  color: #ffffff;
  margin-bottom: 16px;
}

.footer-col a {
  display: block;
  font-family: 'Inter', sans-serif;
  font-size: 14px;
  color: #aaa;
  margin-bottom: 10px;
  transition: color 0.3s ease;
}

.footer-col a:hover {
  color: #00ff11;
}

.footer-bottom {
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  padding-top: 20px;
  text-align: center;
}

.footer-bottom p {
  font-family: 'Inter', sans-serif;
  font-size: 13px;
  color: #777;
}

@media (max-width: 768px) {
  .footer-content {
    grid-template-columns: 1fr;
    gap: 40px;
  }

  .footer-links {
    gap: 30px;
  }

  .footer {
    padding: 40px 0 100px;
  }
}
</style>
