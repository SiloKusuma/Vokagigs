<template>
  <div class="auth-page section">
    <div class="container">
      <div class="auth-container">
        <div class="auth-header">
          <h1 class="auth-title">{{ isLogin ? 'Masuk' : 'Daftar Akun' }}</h1>
          <p class="auth-subtitle">
            {{ isLogin ? 'Selamat datang kembali! Masuk ke akun Anda.' : 'Buat akun baru dan mulai perjalanan Anda.' }}
          </p>
        </div>

        <div class="auth-tabs">
          <button class="auth-tab" :class="{ active: isLogin }" @click="isLogin = true">Masuk</button>
          <button class="auth-tab" :class="{ active: !isLogin }" @click="isLogin = false">Daftar</button>
        </div>

        <div class="alert alert-error" v-if="error">
          {{ error }}
        </div>
        <div class="alert alert-success" v-if="success">
          {{ success }}
        </div>

        <form @submit.prevent="handleSubmit" class="auth-form">
          <div class="form-group" v-if="!isLogin">
            <label for="name">Nama Lengkap</label>
            <input type="text" id="name" v-model="form.name" placeholder="Masukkan nama lengkap" required />
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" v-model="form.email" placeholder="Masukkan email" required />
          </div>

          <div class="form-group">
            <label for="password">Kata Sandi</label>
            <input type="password" id="password" v-model="form.password" placeholder="Masukkan kata sandi" required />
          </div>

          <div class="form-group" v-if="!isLogin">
            <label for="confirm_password">Konfirmasi Kata Sandi</label>
            <input type="password" id="confirm_password" v-model="form.confirm_password" placeholder="Konfirmasi kata sandi" required />
          </div>

          <button type="submit" class="btn btn-primary btn-submit" :disabled="loading">
            <span v-if="loading">Memproses...</span>
            <span v-else>{{ isLogin ? 'Masuk' : 'Daftar' }}</span>
          </button>
        </form>

        <div class="auth-footer">
          <p v-if="isLogin">
            Belum punya akun? <a href="#" @click.prevent="isLogin = false">Daftar sekarang</a>
          </p>
          <p v-else>
            Sudah punya akun? <a href="#" @click.prevent="isLogin = true">Masuk</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
const API_BASE = 'https://vokagigs.awancepat.my.id/server'

export default {
  name: 'LoginPage',
  head() {
    return {
      title: this.isLogin ? 'Masuk - Vokagigs' : 'Daftar - Vokagigs'
    }
  },
  data() {
    return {
      isLogin: true,
      form: {
        name: '',
        email: '',
        password: '',
        confirm_password: ''
      },
      error: '',
      success: '',
      loading: false
    }
  },
  mounted() {
    const tab = this.$route.query.tab
    if (tab === 'register') {
      this.isLogin = false
    }
  },
  methods: {
    async handleSubmit() {
      this.error = ''
      this.success = ''

      if (!this.form.email || !this.form.password) {
        this.error = 'Harap isi semua field yang wajib'
        return
      }

      if (!this.isLogin) {
        if (!this.form.name) {
          this.error = 'Harap isi nama lengkap'
          return
        }
        if (this.form.password !== this.form.confirm_password) {
          this.error = 'Kata sandi tidak cocok'
          return
        }
        if (this.form.password.length < 6) {
          this.error = 'Kata sandi minimal 6 karakter'
          return
        }
      }

      this.loading = true

      try {
        const endpoint = this.isLogin ? `${API_BASE}/login.php` : `${API_BASE}/register.php`
        const body = this.isLogin
          ? { email: this.form.email, password: this.form.password }
          : { name: this.form.name, email: this.form.email, password: this.form.password }

        const response = await fetch(endpoint, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(body)
        })

        const result = await response.json()

        if (result.status === 'success') {
          if (this.isLogin) {
            localStorage.setItem('vokagigs_token', result.token)
            localStorage.setItem('vokagigs_user', JSON.stringify(result.user))
            this.$router.push('/dashboard')
          } else {
            this.success = 'Pendaftaran berhasil! Silakan masuk.'
            this.isLogin = true
            this.form.name = ''
            this.form.confirm_password = ''
            this.form.password = ''
          }
        } else {
          this.error = result.message || 'Terjadi kesalahan'
        }
      } catch (err) {
        this.error = 'Gagal terhubung ke server. Periksa koneksi Anda.'
      } finally {
        this.loading = false
      }
    }
  }
}
</script>

<style scoped>
.auth-page {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: calc(100vh - 70px);
  padding: 40px 0;
}

.auth-container {
  width: 100%;
  max-width: 440px;
  margin: 0 auto;
}

.auth-header {
  text-align: center;
  margin-bottom: 32px;
}

.auth-title {
  font-family: 'Playfair Display', Georgia, serif;
  font-size: 36px;
  font-weight: 800;
  color: #111111;
  margin-bottom: 8px;
}

.auth-subtitle {
  font-family: 'Inter', sans-serif;
  font-size: 15px;
  color: #666;
}

.auth-tabs {
  display: flex;
  background: #f5f5f5;
  border-radius: 12px;
  padding: 4px;
  margin-bottom: 28px;
}

.auth-tab {
  flex: 1;
  padding: 12px;
  border: none;
  background: transparent;
  font-family: 'Inter', sans-serif;
  font-size: 15px;
  font-weight: 600;
  color: #999;
  cursor: pointer;
  border-radius: 10px;
  transition: all 0.3s ease;
}

.auth-tab.active {
  background: #ffffff;
  color: #111111;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
}

.auth-form {
  background: #ffffff;
  padding: 36px;
  border-radius: 16px;
  border: 1px solid rgba(0, 0, 0, 0.06);
}

.btn-submit {
  width: 100%;
  padding: 14px;
  font-size: 16px;
  margin-top: 8px;
}

.btn-submit:disabled {
  opacity: 0.6;
  cursor: not-allowed;
  transform: none;
}

.auth-footer {
  text-align: center;
  margin-top: 24px;
  font-family: 'Inter', sans-serif;
  font-size: 14px;
  color: #666;
}

.auth-footer a {
  color: #00ff11;
  font-weight: 600;
}

@media (max-width: 768px) {
  .auth-page {
    padding: 20px 0;
    min-height: calc(100vh - 75px);
  }

  .auth-form {
    padding: 24px;
  }

  .auth-title {
    font-size: 28px;
  }
}
</style>
