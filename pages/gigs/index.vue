<template>
  <div class="gigs-page section">
    <div class="container">
      <div class="gigs-header" v-if="category">
        <h1 class="gigs-title">Kategori: {{ category }}</h1>
        <NuxtLink to="/" class="btn btn-outline btn-sm">Kembali</NuxtLink>
      </div>

      <div class="gigs-list" v-if="gigs.length > 0">
        <div class="gig-card" v-for="gig in gigs" :key="gig.id">
          <div class="gig-card-header">
            <h3 class="gig-title">{{ gig.title }}</h3>
            <span class="gig-status" :class="gig.status">{{ gig.status === 'active' ? 'Aktif' : 'Selesai' }}</span>
          </div>
          <p class="gig-desc">{{ gig.description }}</p>
          <div class="gig-card-footer">
            <span class="gig-category">{{ gig.category }}</span>
            <div class="gig-card-actions">
              <span class="gig-price">Rp{{ formatPrice(gig.price) }}</span>
            </div>
          </div>
        </div>
      </div>
      <div class="gigs-empty" v-else-if="!loading">
        <p>Tidak ada gig di kategori ini.</p>
      </div>
      <div class="gigs-loading" v-else>
        Memuat...
      </div>
    </div>
  </div>
</template>

<script>
const API_BASE = 'https://vokagigs.awancepat.my.id/server'

export default {
  name: 'GigsByCategoryPage',
  head() {
    return {
      title: this.category ? `${this.category} - Vokagigs` : 'Gigs - Vokagigs'
    }
  },
  data() {
    return {
      gigs: [],
      category: '',
      loading: true
    }
  },
  async mounted() {
    this.category = this.$route.query.category || ''
    if (this.category) {
      await this.loadGigs()
    } else {
      this.loading = false
    }
  },
  methods: {
    async loadGigs() {
      try {
        const response = await fetch(`${API_BASE}/gigs_by_category.php?category=${encodeURIComponent(this.category)}`)
        const result = await response.json()
        if (result.status === 'success') {
          this.gigs = result.gigs
        }
      } catch (err) {
        console.error('Failed to load gigs:', err)
      } finally {
        this.loading = false
      }
    },
    formatPrice(price) {
      return parseInt(price).toLocaleString('id-ID')
    }
  }
}
</script>

<style scoped>
.gigs-page {
  padding-top: 60px;
  min-height: calc(100vh - 70px);
}

.gigs-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 32px;
}

.gigs-title {
  font-family: 'Playfair Display', Georgia, serif;
  font-size: 28px;
  font-weight: 800;
  color: #111111;
}

.btn-sm {
  padding: 8px 20px;
  font-size: 14px;
}

.gigs-list {
  display: grid;
  gap: 16px;
}

.gig-card {
  padding: 20px;
  border: 1px solid rgba(0, 0, 0, 0.06);
  border-radius: 12px;
  transition: all 0.3s ease;
}

.gig-card:hover {
  border-color: rgba(0, 255, 17, 0.2);
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
}

.gig-card-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 8px;
}

.gig-title {
  font-family: 'Inter', sans-serif;
  font-size: 17px;
  font-weight: 600;
  color: #111111;
}

.gig-status {
  padding: 4px 12px;
  border-radius: 20px;
  font-family: 'Inter', sans-serif;
  font-size: 12px;
  font-weight: 600;
}

.gig-status.active {
  background: rgba(0, 255, 17, 0.1);
  color: #00cc0e;
}

.gig-desc {
  font-family: 'Inter', sans-serif;
  font-size: 14px;
  color: #777;
  margin-bottom: 12px;
  line-height: 1.6;
}

.gig-card-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.gig-card-actions {
  display: flex;
  align-items: center;
  gap: 12px;
}

.gig-category {
  font-family: 'Inter', sans-serif;
  font-size: 13px;
  color: #999;
}

.gig-price {
  font-family: 'Inter', sans-serif;
  font-size: 16px;
  font-weight: 700;
  color: #00ff11;
}

.gigs-empty,
.gigs-loading {
  text-align: center;
  padding: 80px 20px;
  font-family: 'Inter', sans-serif;
  font-size: 16px;
  color: #999;
}

@media (max-width: 768px) {
  .gigs-title {
    font-size: 22px;
  }

  .gigs-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 12px;
  }
}
</style>
