<template>
  <div class="gig-detail-page section">
    <div class="container">
      <div class="gig-detail" v-if="gig">
        <div class="gig-detail-header">
          <h1 class="gig-detail-title">{{ gig.title }}</h1>
          <span class="gig-detail-status" :class="gig.status">{{ gig.status === 'active' ? 'Aktif' : gig.status === 'completed' ? 'Selesai' : 'Tertunda' }}</span>
        </div>
        <div class="gig-detail-meta">
          <div class="gig-detail-category">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
              <polyline points="22,6 12,13 2,6"/>
            </svg>
            {{ gig.category }}
          </div>
          <div class="gig-detail-price">Rp{{ formatPrice(gig.price) }}</div>
        </div>
        <p class="gig-detail-desc">{{ gig.description }}</p>
      </div>
      <div class="gig-detail-loading" v-else-if="loading">
        Memuat...
      </div>
      <div class="gig-detail-error" v-else>
        Gig tidak ditemukan.
      </div>
    </div>
  </div>
</template>

<script>
const API_BASE = 'https://vokagigs.awancepat.my.id/server'

export default {
  name: 'GigDetailPage',
  head() {
    return {
      title: this.gig ? `${this.gig.title} - Vokagigs` : 'Gig - Vokagigs'
    }
  },
  data() {
    return {
      gig: null,
      loading: true
    }
  },
  async mounted() {
    const id = parseInt(this.$route.params.id, 10)
    if (!id || isNaN(id)) {
      this.loading = false
      return
    }
    try {
      const response = await fetch(`${API_BASE}/gig_detail.php?id=${id}`)
      const result = await response.json()
      if (result.status === 'success') {
        this.gig = result.gig
      }
    } catch (err) {
      console.error('Failed to load gig:', err)
    } finally {
      this.loading = false
    }
  },
  methods: {
    formatPrice(price) {
      return parseInt(price).toLocaleString('id-ID')
    }
  }
}
</script>

<style scoped>
.gig-detail-page {
  padding-top: 60px;
  min-height: calc(100vh - 70px);
}

.gig-detail {
  max-width: 720px;
  margin: 0 auto;
  background: #ffffff;
  border-radius: 16px;
  border: 1px solid rgba(0, 0, 0, 0.06);
  padding: 40px;
}

.gig-detail-header {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 16px;
  margin-bottom: 20px;
}

.gig-detail-title {
  font-family: 'Playfair Display', Georgia, serif;
  font-size: 32px;
  font-weight: 800;
  color: #111111;
  line-height: 1.3;
}

.gig-detail-status {
  padding: 6px 16px;
  border-radius: 20px;
  font-family: 'Inter', sans-serif;
  font-size: 13px;
  font-weight: 600;
  white-space: nowrap;
  flex-shrink: 0;
}

.gig-detail-status.active {
  background: rgba(0, 255, 17, 0.1);
  color: #00cc0e;
}

.gig-detail-status.completed {
  background: rgba(33, 150, 243, 0.1);
  color: #1976d2;
}

.gig-detail-status.pending {
  background: rgba(255, 152, 0, 0.1);
  color: #f57c00;
}

.gig-detail-meta {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 24px;
  padding-bottom: 24px;
  border-bottom: 1px solid rgba(0, 0, 0, 0.06);
}

.gig-detail-category {
  display: flex;
  align-items: center;
  gap: 8px;
  font-family: 'Inter', sans-serif;
  font-size: 14px;
  color: #888;
}

.gig-detail-price {
  font-family: 'Inter', sans-serif;
  font-size: 24px;
  font-weight: 700;
  color: #00ff11;
}

.gig-detail-desc {
  font-family: 'Inter', sans-serif;
  font-size: 16px;
  color: #555;
  line-height: 1.8;
}

.gig-detail-loading,
.gig-detail-error {
  text-align: center;
  padding: 80px 20px;
  font-family: 'Inter', sans-serif;
  font-size: 16px;
  color: #999;
}

@media (max-width: 768px) {
  .gig-detail {
    padding: 24px;
  }

  .gig-detail-title {
    font-size: 24px;
  }

  .gig-detail-header {
    flex-direction: column;
  }

  .gig-detail-meta {
    flex-direction: column;
    align-items: flex-start;
    gap: 12px;
  }
}
</style>
