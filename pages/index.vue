<template>
  <div class="landing">
    <section class="hero section">
      <div class="container">
        <div class="hero-wrapper">
          <div class="hero-content">
            <div class="hero-badge">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="#00ff11"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
              Platform Gig Online Terpercaya
            </div>
            <h1 class="hero-title">
              Temukan <span class="text-green">Talenta</span> Terbaik<br>Untuk Proyek Anda
            </h1>
            <p class="hero-subtitle">
              Vokagigs menghubungkan Anda dengan ribuan pekerja lepas profesional<br>
              di berbagai bidang. Mulai proyek Anda hari ini.
            </p>
            <div class="hero-actions">
              <NuxtLink to="/login?tab=register" class="btn btn-primary btn-lg">
                Mulai Sekarang
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
              </NuxtLink>
              <a href="#features" class="btn btn-secondary btn-lg">
                Pelajari Lebih Lanjut
              </a>
            </div>
            <div class="hero-stats">
              <div class="stat-item">
                <span class="stat-number">10K+</span>
                <span class="stat-label">Pekerja Lepas</span>
              </div>
              <div class="stat-item">
                <span class="stat-number">5K+</span>
                <span class="stat-label">Proyek Selesai</span>
              </div>
              <div class="stat-item">
                <span class="stat-number">98%</span>
                <span class="stat-label">Kepuasan</span>
              </div>
            </div>
          </div>
          <div class="hero-banner">
            <img src="/banner1.png" alt="Vokagigs Banner" class="banner-img" />
          </div>
        </div>
      </div>
    </section>

    <section id="features" class="features-section section">
      <div class="container">
        <h2 class="section-title">Mengapa Memilih Vokagigs?</h2>
        <p class="section-subtitle">Platform gig online dengan berbagai keunggulan untuk Anda</p>
        <div class="features-grid">
          <div class="feature-card" v-for="(feature, index) in features" :key="index">
            <div class="feature-icon" v-html="feature.icon"></div>
            <h3 class="feature-title">{{ feature.title }}</h3>
            <p class="feature-desc">{{ feature.description }}</p>
          </div>
        </div>
      </div>
    </section>

    <section id="categories" class="categories-section section">
      <div class="container">
        <h2 class="section-title">Kategori Populer</h2>
        <p class="section-subtitle">Temukan berbagai layanan dari talenta terbaik</p>
        <div class="categories-grid">
          <div class="category-card" v-for="(cat, index) in categories" :key="index">
            <div class="category-icon" v-html="cat.icon"></div>
            <h3 class="category-name">{{ cat.name }}</h3>
            <p class="category-count">{{ cat.count }} gigs</p>
          </div>
        </div>
      </div>
    </section>

    <section id="how-it-works" class="how-section section">
      <div class="container">
        <h2 class="section-title">Bagaimana Cara Kerjanya?</h2>
        <p class="section-subtitle">Mulai dalam 3 langkah mudah</p>
        <div class="steps">
          <div class="step" v-for="(step, index) in steps" :key="index">
            <div class="step-number">{{ index + 1 }}</div>
            <h3 class="step-title">{{ step.title }}</h3>
            <p class="step-desc">{{ step.description }}</p>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
export default {
  name: 'LandingPage',
  head() {
    return {
      title: 'Vokagigs - Platform Gig Online Terpercaya'
    }
  },
  data() {
    return {
      features: [
        {
          icon: '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#00ff11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>',
          title: 'Mudah Digunakan',
          description: 'Antarmuka yang intuitif dan mudah digunakan, baik untuk klien maupun pekerja lepas.'
        },
        {
          icon: '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#00ff11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
          title: 'Cepat & Efisien',
          description: 'Temukan talenta yang tepat untuk proyek Anda dengan cepat dan efisien.'
        },
        {
          icon: '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#00ff11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
          title: 'Aman & Terpercaya',
          description: 'Sistem pembayaran yang aman dan terpercaya untuk melindungi kedua belah pihak.'
        },
        {
          icon: '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#00ff11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
          title: 'Komunitas Besar',
          description: 'Bergabung dengan ribuan talenta profesional dari berbagai bidang dan keahlian.'
        },
        {
          icon: '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#00ff11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>',
          title: 'Kualitas Terjamin',
          description: 'Sistem rating dan review untuk memastikan kualitas pekerjaan yang terbaik.'
        },
        {
          icon: '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#00ff11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 4 2 4-2 4-2"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/></svg>',
          title: 'Support 24/7',
          description: 'Tim dukungan kami siap membantu Anda kapan saja, 24 jam sehari, 7 hari seminggu.'
        }
      ],
      categories: [
        { name: 'Desain Grafis', count: 1200, icon: '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#00ff11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>' },
        { name: 'Penulisan & Terjemahan', count: 850, icon: '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#00ff11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>' },
        { name: 'Pemasaran Digital', count: 950, icon: '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#00ff11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>' },
        { name: 'Programming & Tech', count: 1500, icon: '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#00ff11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>' },
        { name: 'Video & Animasi', count: 700, icon: '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#00ff11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>' },
        { name: 'Musik & Audio', count: 450, icon: '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#00ff11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>' }
      ],
      steps: [
        {
          title: 'Daftar Akun',
          description: 'Buat akun gratis Anda di Vokagigs sebagai klien atau pekerja lepas dalam hitungan menit.'
        },
        {
          title: 'Temukan atau Tawarkan',
          description: 'Cari proyek yang sesuai atau tawarkan jasa Anda kepada ribuan klien potensial.'
        },
        {
          title: 'Mulai Bekerja',
          description: 'Mulai proyek Anda dan dapatkan hasil berkualitas tinggi dengan sistem yang terjamin.'
        }
      ]
    }
  }
}
</script>

<style scoped>
.hero {
  padding-top: 100px;
}

.hero-wrapper {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 60px;
  align-items: center;
}

.hero-content {
  max-width: 100%;
}

.hero-banner {
  display: flex;
  align-items: center;
  justify-content: center;
}

.banner-img {
  width: 100%;
  max-width: 540px;
  height: auto;
  border-radius: 16px;
}

.hero-badge {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 8px 20px;
  background: rgba(0, 255, 17, 0.08);
  border: 1px solid rgba(0, 255, 17, 0.2);
  border-radius: 50px;
  font-family: 'Inter', sans-serif;
  font-size: 14px;
  font-weight: 500;
  color: #00cc0e;
  margin-bottom: 24px;
}

.hero-title {
  font-family: 'Playfair Display', Georgia, serif;
  font-size: 62px;
  font-weight: 900;
  color: #111111;
  line-height: 1.1;
  margin-bottom: 24px;
  letter-spacing: -1px;
}

.text-green {
  color: #00ff11;
}

.hero-subtitle {
  font-family: 'Inter', sans-serif;
  font-size: 18px;
  color: #666;
  line-height: 1.7;
  margin-bottom: 36px;
}

.hero-actions {
  display: flex;
  align-items: center;
  justify-content: flex-start;
  gap: 16px;
  margin-bottom: 60px;
}

.btn-lg {
  padding: 16px 36px;
  font-size: 17px;
  border-radius: 10px;
}

.hero-stats {
  display: flex;
  justify-content: flex-start;
  gap: 60px;
  padding: 30px 0;
  border-top: 1px solid rgba(0, 0, 0, 0.06);
}

.stat-item {
  text-align: left;
}

.stat-number {
  display: block;
  font-family: 'Playfair Display', Georgia, serif;
  font-size: 36px;
  font-weight: 800;
  color: #111111;
  margin-bottom: 4px;
}

.stat-label {
  font-family: 'Inter', sans-serif;
  font-size: 14px;
  color: #888;
  font-weight: 500;
}

.features-section {
  background: rgba(0, 0, 0, 0.02);
}

.features-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 30px;
}

.feature-card {
  background: #ffffff;
  padding: 36px;
  border-radius: 16px;
  border: 1px solid rgba(0, 0, 0, 0.06);
  transition: all 0.4s ease;
}

.feature-card:hover {
  background: #00ff11;
  transform: translateY(-4px);
}

.feature-card:hover .feature-title,
.feature-card:hover .feature-desc {
  color: #ffffff;
}

.feature-card:hover .feature-icon {
  background: #0a7a0e;
}

.feature-card:hover .feature-icon svg {
  stroke: #ffffff;
}

.feature-icon {
  width: 56px;
  height: 56px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(0, 255, 17, 0.08);
  border-radius: 14px;
  margin-bottom: 20px;
  transition: all 0.4s ease;
}

.feature-icon svg {
  transition: stroke 0.4s ease;
}

.feature-title {
  font-family: 'Inter', sans-serif;
  font-size: 20px;
  font-weight: 700;
  color: #111111;
  margin-bottom: 10px;
  transition: color 0.4s ease;
}

.feature-desc {
  font-family: 'Inter', sans-serif;
  font-size: 15px;
  color: #666;
  line-height: 1.7;
  transition: color 0.4s ease;
}

.categories-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
}

.category-card {
  background: #ffffff;
  padding: 32px;
  border-radius: 16px;
  border: 1px solid rgba(0, 0, 0, 0.06);
  text-align: center;
  transition: all 0.4s ease;
  cursor: pointer;
}

.category-card:hover {
  transform: translateY(-2px);
}

.category-icon {
  width: 56px;
  height: 56px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(0, 255, 17, 0.08);
  border-radius: 14px;
  margin: 0 auto 16px;
}

.category-name {
  font-family: 'Inter', sans-serif;
  font-size: 18px;
  font-weight: 700;
  color: #111111;
  margin-bottom: 6px;
}

.category-count {
  font-family: 'Inter', sans-serif;
  font-size: 14px;
  color: #00ff11;
  font-weight: 500;
}

.how-section {
  background: rgba(0, 0, 0, 0.02);
}

.steps {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 40px;
  max-width: 900px;
  margin: 0 auto;
}

.step {
  text-align: center;
  padding: 40px 30px;
}

.step-number {
  width: 64px;
  height: 64px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 20px;
  background: #00ff11;
  color: #ffffff;
  font-family: 'Playfair Display', Georgia, serif;
  font-size: 28px;
  font-weight: 800;
  border-radius: 50%;
}

.step-title {
  font-family: 'Inter', sans-serif;
  font-size: 22px;
  font-weight: 700;
  color: #111111;
  margin-bottom: 12px;
}

.step-desc {
  font-family: 'Inter', sans-serif;
  font-size: 15px;
  color: #666;
  line-height: 1.7;
}

.cta-coin {
  margin-bottom: 24px;
  display: flex;
  justify-content: center;
}

.coin-img {
  width: 130px;
  height: auto;
  display: block;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.15);
  padding: 12px;
}

.cta-card {
  background: linear-gradient(135deg, #00ff11, #00cc0e);
  border-radius: 24px;
  padding: 80px 40px;
  text-align: center;
}

.cta-title {
  font-family: 'Playfair Display', Georgia, serif;
  font-size: 48px;
  font-weight: 800;
  color: #111111;
  margin-bottom: 16px;
}

.cta-text {
  font-family: 'Inter', sans-serif;
  font-size: 18px;
  color: rgba(17, 17, 17, 0.7);
  margin-bottom: 36px;
  max-width: 500px;
  margin-left: auto;
  margin-right: auto;
}

.cta-actions {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 16px;
}

.cta-actions .btn-outline {
  border-color: #111111;
  color: #111111;
}

.cta-actions .btn-outline:hover {
  background: #111111;
  color: #ffffff;
}

@media (max-width: 768px) {
  .hero {
    padding-top: 80px;
  }

  .hero-wrapper {
    grid-template-columns: 1fr;
    gap: 30px;
  }

  .hero-banner {
    order: -1;
  }

  .banner-img {
    max-width: 100%;
  }

  .hero-title {
    font-size: 36px;
  }

  .hero-subtitle {
    font-size: 16px;
  }

  .hero-actions {
    flex-direction: column;
  }

  .hero-stats {
    gap: 30px;
    flex-wrap: wrap;
  }

  .stat-number {
    font-size: 28px;
  }

  .features-grid {
    grid-template-columns: 1fr;
  }

  .categories-grid {
    grid-template-columns: 1fr 1fr;
  }

  .steps {
    grid-template-columns: 1fr;
    gap: 20px;
  }

  .cta-card {
    padding: 50px 24px;
  }

  .cta-title {
    font-size: 32px;
  }

  .cta-actions {
    flex-direction: column;
  }
}
</style>
