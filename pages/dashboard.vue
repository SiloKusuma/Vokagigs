<template>
  <div class="dashboard-page section">
    <div class="container">
      <div class="dashboard-alert alert alert-error" v-if="!isLoggedIn">
        Silakan <NuxtLink to="/login">masuk</NuxtLink> untuk mengakses dashboard.
      </div>

      <template v-if="isLoggedIn">
        <div class="dashboard-header">
          <div>
            <h1 class="dashboard-title">Dashboard</h1>
            <p class="dashboard-welcome">Selamat datang, <strong>{{ user.name }}</strong>!</p>
          </div>
          <button class="btn btn-outline btn-logout" @click="handleLogout">Keluar</button>
        </div>

        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-card-icon">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#00ff11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><briefcase xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></briefcase></svg>
            </div>
            <div class="stat-card-info">
              <span class="stat-card-value">{{ stats.total_gigs }}</span>
              <span class="stat-card-label">Total Gigs</span>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-card-icon">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#00ff11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><check-circle xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></check-circle></svg>
            </div>
            <div class="stat-card-info">
              <span class="stat-card-value">{{ stats.completed }}</span>
              <span class="stat-card-label">Selesai</span>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-card-icon">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#00ff11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><clock xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></clock></svg>
            </div>
            <div class="stat-card-info">
              <span class="stat-card-value">{{ stats.in_progress }}</span>
              <span class="stat-card-label">Berjalan</span>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-card-icon">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#00ff11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><dollar-sign xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></dollar-sign></svg>
            </div>
            <div class="stat-card-info">
              <span class="stat-card-value">Rp{{ formatPrice(stats.earnings) }}</span>
              <span class="stat-card-label">Pendapatan</span>
            </div>
          </div>
        </div>

        <div class="dashboard-content">
          <div class="dashboard-section">
            <div class="section-header">
              <h2>Gigs Saya</h2>
              <button class="btn btn-primary btn-sm" @click="showAddForm = !showAddForm">
                + Tambah Gig
              </button>
            </div>

            <div class="add-gig-form" v-if="showAddForm">
              <h3>Buat Gig Baru</h3>
              <form @submit.prevent="handleAddGig">
                <div class="form-group">
                  <label>Judul Gig</label>
                  <input type="text" v-model="newGig.title" placeholder="Masukkan judul gig" required />
                </div>
                <div class="form-group">
                  <label>Deskripsi</label>
                  <textarea v-model="newGig.description" placeholder="Deskripsikan layanan Anda" rows="4" required></textarea>
                </div>
                <div class="form-row">
                  <div class="form-group">
                    <label>Kategori</label>
                    <select v-model="newGig.category" required>
                      <option value="">Pilih kategori</option>
                      <option value="Desain Grafis">Desain Grafis</option>
                      <option value="Penulisan & Terjemahan">Penulisan & Terjemahan</option>
                      <option value="Pemasaran Digital">Pemasaran Digital</option>
                      <option value="Programming & Tech">Programming & Tech</option>
                      <option value="Video & Animasi">Video & Animasi</option>
                      <option value="Musik & Audio">Musik & Audio</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Harga (Rp)</label>
                    <input type="number" v-model="newGig.price" placeholder="Harga" required min="1000" />
                  </div>
                </div>
                <div class="form-actions">
                  <button type="submit" class="btn btn-primary" :disabled="addingGig">
                    {{ addingGig ? 'Menyimpan...' : 'Simpan Gig' }}
                  </button>
                  <button type="button" class="btn btn-secondary" @click="showAddForm = false">Batal</button>
                </div>
              </form>
            </div>

            <div class="gigs-list" v-if="gigs.length > 0">
              <div class="gig-card" v-for="gig in gigs" :key="gig.id">
                <div class="gig-card-header">
                  <h3 class="gig-title">{{ gig.title }}</h3>
                  <span class="gig-status" :class="gig.status">{{ gig.status === 'active' ? 'Aktif' : gig.status === 'completed' ? 'Selesai' : 'Tertunda' }}</span>
                </div>
                <p class="gig-desc">{{ gig.description }}</p>
                <div class="gig-card-footer">
                  <span class="gig-category">{{ gig.category }}</span>
                  <span class="gig-price">Rp{{ formatPrice(gig.price) }}</span>
                </div>
              </div>
            </div>
            <div class="empty-state" v-else>
              <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#ddd" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><briefcase xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></briefcase></svg>
              <p>Belum ada gig. Buat gig pertama Anda!</p>
            </div>
          </div>
        </div>
      </template>
    </div>
  </div>
</template>

<script>
const API_BASE = 'https://vokagigs.awancepat.my.id/server'

export default {
  name: 'DashboardPage',
  head() {
    return {
      title: 'Dashboard - Vokagigs'
    }
  },
  data() {
    return {
      isLoggedIn: false,
      user: {},
      stats: {
        total_gigs: 0,
        completed: 0,
        in_progress: 0,
        earnings: 0
      },
      gigs: [],
      showAddForm: false,
      addingGig: false,
      newGig: {
        title: '',
        description: '',
        category: '',
        price: ''
      }
    }
  },
  mounted() {
    this.checkAuth()
  },
  methods: {
    checkAuth() {
      const token = localStorage.getItem('vokagigs_token')
      const user = localStorage.getItem('vokagigs_user')
      if (token && user) {
        this.isLoggedIn = true
        this.user = JSON.parse(user)
        this.loadDashboard()
      } else {
        this.isLoggedIn = false
      }
    },
    async loadDashboard() {
      try {
        const token = localStorage.getItem('vokagigs_token')
        const response = await fetch(`${API_BASE}/dashboard.php`, {
          headers: {
            'Authorization': `Bearer ${token}`
          }
        })
        const result = await response.json()
        if (result.status === 'success') {
          this.stats = result.stats
          this.gigs = result.gigs
        }
      } catch (err) {
        console.error('Failed to load dashboard:', err)
      }
    },
    async handleAddGig() {
      this.addingGig = true
      try {
        const token = localStorage.getItem('vokagigs_token')
        const response = await fetch(`${API_BASE}/gigs.php`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`
          },
          body: JSON.stringify(this.newGig)
        })
        const result = await response.json()
        if (result.status === 'success') {
          this.gigs.unshift(result.gig)
          this.showAddForm = false
          this.newGig = { title: '', description: '', category: '', price: '' }
          this.stats.total_gigs++
        }
      } catch (err) {
        console.error('Failed to add gig:', err)
      } finally {
        this.addingGig = false
      }
    },
    handleLogout() {
      localStorage.removeItem('vokagigs_token')
      localStorage.removeItem('vokagigs_user')
      this.isLoggedIn = false
      this.$router.push('/')
    },
    formatPrice(price) {
      return parseInt(price).toLocaleString('id-ID')
    }
  }
}
</script>

<style scoped>
.dashboard-page {
  padding-top: 40px;
  min-height: calc(100vh - 70px);
}

.dashboard-alert {
  text-align: center;
  padding: 60px 20px;
}

.dashboard-alert a {
  color: #00ff11;
  font-weight: 600;
  text-decoration: underline;
}

.dashboard-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 40px;
}

.dashboard-title {
  font-family: 'Playfair Display', Georgia, serif;
  font-size: 36px;
  font-weight: 800;
  color: #111111;
  margin-bottom: 4px;
}

.dashboard-welcome {
  font-family: 'Inter', sans-serif;
  font-size: 16px;
  color: #666;
}

.btn-logout {
  border-color: #d32f2f;
  color: #d32f2f;
}

.btn-logout:hover {
  background: #d32f2f;
  color: #fff;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
  margin-bottom: 40px;
}

.stat-card {
  display: flex;
  align-items: center;
  gap: 16px;
  background: #ffffff;
  padding: 24px;
  border-radius: 16px;
  border: 1px solid rgba(0, 0, 0, 0.06);
  transition: all 0.3s ease;
}

.stat-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.04);
}

.stat-card-icon {
  width: 48px;
  height: 48px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(0, 255, 17, 0.08);
  border-radius: 12px;
  flex-shrink: 0;
}

.stat-card-info {
  display: flex;
  flex-direction: column;
}

.stat-card-value {
  font-family: 'Playfair Display', Georgia, serif;
  font-size: 22px;
  font-weight: 800;
  color: #111111;
}

.stat-card-label {
  font-family: 'Inter', sans-serif;
  font-size: 13px;
  color: #888;
}

.dashboard-section {
  background: #ffffff;
  border-radius: 16px;
  border: 1px solid rgba(0, 0, 0, 0.06);
  padding: 32px;
}

.section-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 24px;
}

.section-header h2 {
  font-family: 'Inter', sans-serif;
  font-size: 22px;
  font-weight: 700;
  color: #111111;
}

.add-gig-form {
  background: #f9f9f9;
  padding: 28px;
  border-radius: 12px;
  margin-bottom: 28px;
  border: 1px solid rgba(0, 255, 17, 0.15);
}

.add-gig-form h3 {
  font-family: 'Inter', sans-serif;
  font-size: 18px;
  font-weight: 600;
  color: #111111;
  margin-bottom: 20px;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
}

.form-actions {
  display: flex;
  gap: 12px;
  margin-top: 8px;
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

.gig-status.completed {
  background: rgba(33, 150, 243, 0.1);
  color: #1976d2;
}

.gig-status.pending {
  background: rgba(255, 152, 0, 0.1);
  color: #f57c00;
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

.empty-state {
  text-align: center;
  padding: 60px 20px;
}

.empty-state p {
  font-family: 'Inter', sans-serif;
  font-size: 15px;
  color: #999;
  margin-top: 12px;
}

@media (max-width: 768px) {
  .stats-grid {
    grid-template-columns: repeat(2, 1fr);
  }

  .dashboard-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 16px;
  }

  .dashboard-section {
    padding: 20px;
  }

  .form-row {
    grid-template-columns: 1fr;
  }

  .dashboard-title {
    font-size: 28px;
  }
}
</style>
